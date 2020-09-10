<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Core;

/**
 * Genome config class.
 */
class Config
{
    /**
     * Genome module id.
     *
     * @var string
     */
    protected $genomeId = 'genome';

    /**
     * Genome host.
     *
     * @var string
     */
    protected $genomeHost = 'https://hpp-service.genome.eu/hpp';

    /**
     * Please do not change this place.
     * It is important to guarantee the future development of this OXID eShop extension and to keep it free of charge.
     * Thanks!
     *
     * @var array Partner codes based on edition
     */
    protected $partnerCodes = array(
        'EE' => 'OXID_Cart_EnterpriseECS',
        'PE' => 'OXID_Cart_ProfessionalECS',
        'CE' => 'OXID_Cart_CommunityECS',
        'SHORTCUT' => 'Oxid_Cart_ECS_Shortcut'
    );

    /**
     * Return Genome module id.
     *
     * @return string
     */
    public function getModuleId(): string
    {
        return $this->genomeId;
    }

    /**
     * Sets Genome host.
     *
     * @param string $genomeHost
     */
    public function setGenomeHost(string $genomeHost): void
    {
        $this->genomeHost = $genomeHost;
    }

    /**
     * Returns Genome host.
     *
     * @return string
     */
    public function getGenomeHost(): string
    {
        return $this->genomeHost;
    }

    /**
     * Check if sandbox mode is enabled.
     *
     * @return bool
     */
    public function isSandboxEnabled(): bool
    {
        return $this->getParameter('blGenomeSandboxMode');
    }

    /**
     * Get shop url.
     * 
     * @param bool $admin if admin
     * @return string
     */
    public function getShopUrl($admin = null): string
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getCurrentShopUrl($admin);
    }

    /**
     * Wrapper to get language object from registry.
     *
     * @return \OxidEsales\Eshop\Core\Language
     */
    public function getLang(): \OxidEsales\Eshop\Core\Language
    {
        return \OxidEsales\Eshop\Core\Registry::getLang();
    }

    /**
     * Please do not change this place.
     * It is important to guarantee the future development of this OXID eShop extension and to keep it free of charge.
     * Thanks!
     *
     * @return string partner code.
     */
    public function getPartnerCode(): string
    {
        $facts = new \OxidEsales\Facts\Facts();
        $key = $this->isShortcutPayment() ? self::PARTNERCODE_SHORTCUT_KEY : $facts->getEdition();

        return $this->partnerCodes[$key];
    }

    /**
     * Returns active shop id.
     *
     * @return integer
     */
    protected function getShopId(): int
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
    }

    /**
     * Returns oxConfig instance.
     *
     * @return \OxidEsales\Eshop\Core\Config
     */
    protected function getConfig(): \OxidEsales\Eshop\Core\Config
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig();
    }

    /**
     * Retrieve apropriate (sandbox/prod) publick key.
     * @return string
     */
    public function getPublicKey(): string
    {
        if ($this->isSandboxEnabled()) {
            $publicKey = $this->getParameter('sGenomeTestPublicKey');
        } else {
            $publicKey = $this->getParameter('sGenomePublickKey');
        }

        return $publicKey;
    }
    
    /**
     * Retrieve apropriate (sandbox/prod) private key.
     * @return string
     */
    public function getPrivateKey(): string
    {
        if ($this->isSandboxEnabled()) {
            $privateKey = $this->getParameter('sGenomeTestPrivateKey');
        } else {
            $privateKey = $this->getParameter('sGenomePrivateKey');
        }

        return $privateKey;
    }
    
    /**
     * Returns module config parameter value.
     *
     * @param string $paramName Parameter name.
     *
     * @return mixed
     */
    public function getParameter($paramName)
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam($paramName);
    }
}
