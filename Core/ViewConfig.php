<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Core;

/**
 * ViewConfig class wrapper for Genome module.
 *
 * @mixin \OxidEsales\Eshop\Core\ViewConfig
 */
class ViewConfig extends ViewConfig_parent
{
    /** @var null \Genome\GenomeModule\Core\Config */
    protected $genomeConfig = null;

    /**
     * Returns Genome config.
     *
     * @return \Genome\GenomeModule\Core\Config
     */
    protected function getGenomeConfig(): \Genome\GenomeModule\Core\Config
    {
        if (is_null($this->genomeConfig)) {
            $this->genomeConfig = oxNew(\Genome\GenomeModule\Core\Config::class);
        }

        return $this->genomeConfig;
    }
    
    /**
     * Check if order has been already refunded.
     * @param string $orderId
     * @return string
     */
    public function isOrderRefunded(string $orderId): string
    {
        $order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class)->getGenomeOrder($orderId);
        return $order->getOrderStatus() === $order::GENOME_PAYMENT_REFUNDED;
    }
    
    /**
     * Check if order payment is completed.
     * @param string $orderId
     * @return string
     */
    public function isOrderCompleted(string $orderId): string
    {
        $order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class)->getGenomeOrder($orderId);
        return $order->getOrderStatus() === $order::GENOME_PAYMENT_COMPLETED;
    }
}
