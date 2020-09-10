<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Model;

/**
 * Trait Common Trait class.
 */
trait CommonTrait
{
    /**
     * @var \Genome\GenomeModule\Core\Logger
     */
    protected $logger = null;
    
    /**
     * Genome service.
     *
     * @var \Genome\GenomeModule\Core\GenomeService|null
     */
    protected $genomeService = null;  
    
    /**
     * Return Genome logger.
     *
     * @return \Genome\GenomeModule\Core\Logger
     */
    public function getLogger(): \Genome\GenomeModule\Core\Logger
    {
        if (is_null($this->logger)) {
            $session = \OxidEsales\Eshop\Core\Registry::getSession();
            $this->logger = oxNew(\Genome\GenomeModule\Core\Logger::class);
            $this->logger->setLoggerSessionId($session->getId());
        }

        return $this->logger;
    }
    
    /**
     * Retrieve Genome service.
     *
     * @return \Genome\GenomeModule\Core\GenomeService
     */
    public function getGenomeService(): \Genome\GenomeModule\Core\GenomeService
    {
        if (is_null($this->genomeService)) {
            $this->setGenomeService(oxNew(\Genome\GenomeModule\Core\GenomeService::class));
        }

        return $this->genomeService;
    }
    
    /**
     * Sets Genome service.
     *
     * @param \Genome\GenomeModule\Core\GenomeService $genomeService
     * @return void
     */
    public function setGenomeService(\Genome\GenomeModule\Core\GenomeService $genomeService): void
    {
        $this->genomeService = $genomeService;
    }
}
