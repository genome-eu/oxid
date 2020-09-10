<?php
/**
 * This file is part of OXID Genome module.
 */
namespace Genome\GenomeModule\Controller;

/**
 * Genome Standard Checkout dispatcher class.
 */
class StandardDispatcher extends GenomeFrontendController
{
    /**
     * Genome checkout processing.
     * @return string
     */
    public function setCheckout(): string
    {
        $session = \OxidEsales\Eshop\Core\Registry::getSession();
        $session->setVariable("genome", "1");
        
        try {
            $basket = $session->getBasket();
            $basket->setPayment("oxidgenome");
            $basket->onUpdate();
            $basket->calculateBasket(true);

        } catch (\OxidEsales\Eshop\Core\Exception\StandardException $excp) {
            return "basket";
        }
        
        return 'order';
    }
}
