<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Core;

/**
 * Class defines what module does on Shop events.
 */
class Events
{
    /**
     * Add Genome payment method set EN and DE long descriptions
     * @return void
     */
    public static function addPaymentMethod(): void
    {
        $paymentDescriptions = array(
            'en' => '<div>When selecting this payment method you are being redirected to Genome where you can do your order payment.</div>',
            'de' => '<div>Wenn Sie diese Zahlungsmethode wählen, werden Sie zu Genome weitergeleitet, wo Sie die Zahlung Ihrer Bestellung vornehmen können.</div>'
        );

        $payment = oxNew(\OxidEsales\Eshop\Application\Model\Payment::class);
        
        if (!$payment->load('oxidgenome')) {
            $payment->setId('oxidgenome');
            $payment->oxpayments__oxactive = new \OxidEsales\Eshop\Core\Field(1);
            $payment->oxpayments__oxdesc = new \OxidEsales\Eshop\Core\Field('Genome');
            $payment->oxpayments__oxaddsum = new \OxidEsales\Eshop\Core\Field(0);
            $payment->oxpayments__oxaddsumtype = new \OxidEsales\Eshop\Core\Field('abs');
            $payment->oxpayments__oxfromboni = new \OxidEsales\Eshop\Core\Field(0);
            $payment->oxpayments__oxfromamount = new \OxidEsales\Eshop\Core\Field(0);
            $payment->oxpayments__oxtoamount = new \OxidEsales\Eshop\Core\Field(10000);

            $language = \OxidEsales\Eshop\Core\Registry::getLang();
            $languages = $language->getLanguageIds();
            
            foreach ($paymentDescriptions as $languageAbbreviation => $description) {
                $languageId = array_search($languageAbbreviation, $languages);
                if ($languageId !== false) {
                    $payment->setLanguage($languageId);
                    $payment->oxpayments__oxlongdesc = new \OxidEsales\Eshop\Core\Field($description);
                    $payment->save();
                }
            }
        }
    }

    /**
     * Check if Genome is used for sub-shops.
     *
     * @return bool
     */
    public static function isGenomeActiveOnSubShops(): bool
    {
        $active = false;
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();
        $extensionChecker = oxNew(\Genome\GenomeModule\Core\ExtensionChecker::class);
        $shops = $config->getShopIds();
        $activeShopId = $config->getShopId();

        foreach ($shops as $shopId) {
            if ($shopId != $activeShopId) {
                $extensionChecker->setShopId($shopId);
                $extensionChecker->setExtensionId('genome');
                if ($extensionChecker->isActive()) {
                    $active = true;
                    break;
                }
            }
        }

        return $active;
    }

    /**
     * Disables Genome payment method.
     * @return void
     */
    public static function disablePaymentMethod(): void
    {
        $payment = oxNew(\OxidEsales\Eshop\Application\Model\Payment::class);
        if ($payment->load('oxidgenome')) {
            $payment->oxpayments__oxactive = new \OxidEsales\Eshop\Core\Field(0);
            $payment->save();
        }
    }

    /**
     * Activates Genome payment method.
     * @return void
     */
    public static function enablePaymentMethod(): void
    {
        $payment = oxNew(\OxidEsales\Eshop\Application\Model\Payment::class);
        $payment->load('oxidgenome');
        $payment->oxpayments__oxactive = new \OxidEsales\Eshop\Core\Field(1);
        $payment->save();
    }

    /**
     * Execute action on activate event.
     * @return void
     */
    public static function onActivate(): void
    {
        // adding record to oxPayment table
        self::addPaymentMethod();

        // enabling Genome payment method
        self::enablePaymentMethod();
    }

    /**
     * Execute action on deactivate event.
     *
     * @return null
     */
    public static function onDeactivate()
    {
        // If Genome is activated on other sub shops - do not remove payment method
        if ('EE' == \OxidEsales\Eshop\Core\Registry::getConfig()->getEdition() && self::isGenomeActiveOnSubShops()) {
            return;
        }
        self::disablePaymentMethod();
    }
}
