<?php
/**
 * This file is part of OXID Genome module.
 */
namespace Genome\GenomeModule\Controller\Admin;

/**
 * Refund class wrapper for Genome module
 */
class RefundController extends GenomeAdminController
{
    /**
     * Order refund result status.
     * @var bool
     */
    private $refundResult = null;
    
    public function __construct()
    {
        parent::__construct();
        $this->logger->setTitle('Refund request');
    }
    
    /**
     * Render/ajax response functionality.
     * @return string
     */
    public function render(): string
    {
        if (is_bool($this->refundResult)) {
            return $this->ajaxRefundResponse();
        } else {
            return $this->defaultRender();
        }
    }
    
    /**
     * Ajax refund request response.
     * @return string
     */
    private function ajaxRefundResponse(): string
    {
        if ($this->refundResult) {
            $templateName = 'refund_success.tpl';
        } else {
            $templateName = 'refund_failed.tpl';
        }
        return $templateName;
    }
    
    /**
     * Default render functionality.
     * @return string
     */
    private function defaultRender(): string
    {
        parent::render();

        $this->_aViewData["sOxid"] = $this->getEditObjectId();
        if ($this->isGenomeOrder()) {
            $this->_aViewData['oOrder'] = $this->getEditObject();
        } else {
            $this->_aViewData['sMessage'] = \OxidEsales\Eshop\Core\Registry::getLang()->translateString("GENOME_ONLY_PAYMENT");
        }

        return "order_genome.tpl";
    }

    /**
     * Returns editable order object.
     *
     * @return \Genome\GenomeModule\Model\Order
     */
    public function getEditObject(): \Genome\GenomeModule\Model\Order
    {
        $soxId = $this->getEditObjectId();
        if ($this->_oEditObject === null && isset($soxId) && $soxId != '-1') {
            $this->_oEditObject = oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
            $this->_oEditObject->load($soxId);
        }

        return $this->_oEditObject;
    }
    
    /**
     * Refund fucntionality.
     * @return void
     */
    public function refund(): void
    {
        if (($_SERVER['REQUEST_METHOD'] === 'POST') && $this->isGenomeOrder()) {
            
            $orderId = \oxRegistry::getConfig()->getRequestParameter('oxid', null);
        
            if ($orderId) {
                $order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class)->getGenomeOrder($orderId);
                
                if ($order->getOrderStatus() !== $order::GENOME_PAYMENT_REFUNDED) {
                    $result = $this->genomeService->refundTransaction($order);
                    $this->logger->log($result['message']);
                    $this->refundResult = $result['status'];
                }
            }
        }
    }

    /**
     * Method checks is order was made with Genome module.
     *
     * @return bool
     */
    public function isGenomeOrder(): bool
    {
        $active = false;

        $order = $this->getEditObject();
        if ($order && $order->getFieldData('oxpaymenttype') == 'oxidgenome') {
            $active = true;
        }

        return $active;
    }
}
