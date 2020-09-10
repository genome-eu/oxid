<?php
/**
 * This file is part of OXID Genome module.
 */
namespace Genome\GenomeModule\Controller\Admin;

use OxidEsales\EshopCommunity\Internal\Transition\ShopEvents\AfterRequestProcessedEvent;

/**
 * Base genome admin controller class.
 */
class GenomeAdminController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * Genome service.
     *
     * @var \Genome\GenomeModule\Core\GenomeService|null
     */
    protected $genomeService = null;  
    
    /**
     * @var \Genome\GenomeModule\Core\Logger
     */
    protected $logger = null;
    
    public function __construct() {
        $this->getLogger();
        $this->getGenomeService();
        parent::__construct();
    }
    
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
    
    /**
     * Executes method (creates class and then executes). Returns executed
     * function result.
     *
     * @param string $sFunction name of function to execute
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException system component exception
     */
    public function executeFunction($sFunction)
    {
        if ($sFunction && !self::$_blExecuted) {
            if (method_exists($this, $sFunction)) {
                $this->$sFunction();
                self::$_blExecuted = true;
                $this->dispatchEvent(new AfterRequestProcessedEvent());
            } else {
                // was not executed on any level ?
                if (!$this->_blIsComponent) {
                    /** @var \OxidEsales\Eshop\Core\Exception\SystemComponentException $oEx */
                    $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\SystemComponentException::class);
                    $oEx->setMessage('ERROR_MESSAGE_SYSTEMCOMPONENT_FUNCTIONNOTFOUND' . ' ' . $sFunction);
                    $oEx->setComponent($sFunction);
                    throw $oEx;
                }
            }
        }
    }
}
