<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Controller;

/**
 * Payment class wrapper for Genome module.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\PaymentController
 */
class PaymentController extends PaymentController_parent
{
    /**
     * Detects if current payment must be processed by Genome and instead of standard validation
     * redirects to standard Genome dispatcher
     *
     * @return mixed
     */
    public function validatePayment()
    {
        $paymentId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('paymentid');
        $session = \OxidEsales\Eshop\Core\Registry::getSession();
        $basket = $session->getBasket();
        
        if ($paymentId === 'oxidgenome' && $basket->getBruttoSum()) {
            $session->setVariable('paymentid', 'oxidgenome');

            return 'genomestandarddispatcher?fnc=setCheckout';
        }

        return parent::validatePayment();
    }
}
