<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Controller;

/**
 * @mixin \OxidEsales\Eshop\Application\Controller\ThankyouController
 */
class ThankYouController extends ThankYouController_parent
{
    const GENOME_PAYMENT_DECLINE_STATUS = 'decline';
    
    public function render()
    {
        return parent::render();
    }
    
    /**
     * Thankyou page post processing.
     * @return boolean
     */
    public function checkOrderProcessing(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }
        
        $transactionStatus = \oxRegistry::getConfig()->getRequestParameter('status');
        
        $order = $this->getOrder();
        
        $code = \oxRegistry::getConfig()->getRequestParameter('code', '');                    
        $message = \oxRegistry::getConfig()->getRequestParameter('message', '');
            
        if ($transactionStatus === self::GENOME_PAYMENT_DECLINE_STATUS) {
            $order->setOrderErrorStatus('Payment declined. ' . $message . ' (' . $code . ')');
            return false;
        } elseif ($order->getOrderStatus() !== $order::GENOME_PAYMENT_COMPLETED) {
            $order->setOrderSuccessStatus('Payment processing. ' . $message . ' (' . $code . ')');
        }
        
        return true;
    }
}
