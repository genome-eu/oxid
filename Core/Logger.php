<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Core;

/**
 * Base logger class.
 */
class Logger
{
    /**
     * Logger session id.
     *
     * @var string
     */
    protected $loggerSessionId;

    /**
     * Log title
     */
    protected $logTitle = '';
    
    /**
     * Sets logger session id.
     *
     * @param string $id session id
     * @return void
     */
    public function setLoggerSessionId($id): void
    {
        $this->loggerSessionId = $id;
    }

    /**
     * Returns loggers session id.
     *
     * @return string
     */
    public function getLoggerSessionId(): string
    {
        return $this->loggerSessionId;
    }

    /**
     * Returns full log file path.
     *
     * @return string
     */
    protected function getLogFilePath(): string
    {
        $logDirectoryPath = \OxidEsales\Eshop\Core\Registry::getConfig()->getLogsDir();

        return $logDirectoryPath . 'genome.log';
    }

    /**
     * Set log title.
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->logTitle = $title;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->logTitle;
    }

    /**
     * Writes log message.
     *
     * @param mixed $logData Logger data.
     * @return void
     */
    public function log($logData): void
    {
        $handle = fopen($this->getLogFilePath(), "a+");
        
        if ($handle !== false) {
            fwrite($handle, "======================= " . $this->getTitle() . " [" . date("Y-m-d H:i:s") . "] ======================= #\n\n");
            fwrite($handle, "SESS ID: " . $this->getLoggerSessionId() . "\n");
            fwrite($handle, "Message: " . $logData . "\n\n");
            fclose($handle);
        }

        //resetting log title
        $this->setTitle('');
    }
}
