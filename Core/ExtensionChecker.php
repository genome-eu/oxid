<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Core;

/**
 * Genome Extension checker, check if extension is active on shop/sub-shop
 */
class ExtensionChecker
{
    /**
     * Shop id.
     *
     * @var string
     */
    protected $shopId = null;

    /**
     * Extension id.
     *
     * @var string
     */
    protected $extensionId = '';

    /**
     * Set shop id.
     *
     * @param string $shopId
     * @return void
     */
    public function setShopId(string $shopId): void
    {
        $this->shopId = $shopId;
    }

    /**
     * Return shop id.
     *
     * @return string
     */
    public function getShopId(): string
    {
        if (is_null($this->shopId)) {
            $this->setShopId(\OxidEsales\Eshop\Core\Registry::getConfig()->getShopId());
        }

        return $this->shopId;
    }

    /**
     * Set extension id.
     *
     * @param string $extensionId
     * @return void
     */
    public function setExtensionId(string $extensionId): void
    {
        $this->extensionId = $extensionId;
    }

    /**
     * Return extension id.
     *
     * @return string
     */
    public function getExtensionId(): string
    {
        return $this->extensionId;
    }

    /**
     * Return extended classes array.
     *
     * @return array
     */
    protected function getExtendedClasses(): array
    {
        return $this->getConfigValue('aModules');
    }

    /**
     * Return disabled modules array.
     *
     * @return array
     */
    protected function getDisabledModules(): array
    {
        return $this->getConfigValue('aDisabledModules');
    }

    /**
     * Return config value.
     *
     * @param string $configName
     *
     * @return array
     */
    protected function getConfigValue($configName): array
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();
        $configKey = $config->getConfigParam('sConfigKey');

        $select = "SELECT DECODE( `oxvarvalue` , " . $db->quote($configKey) . " ) AS `oxvarvalue` " .
                   "FROM `oxconfig` WHERE `oxvarname` = " . $db->quote($configName) . " AND `oxshopid` = " . $db->quote($this->getShopId());

        return unserialize($db->getOne($select));
    }

    /**
     * Check if module is active.
     *
     * @return  bool
     */
    public function isActive(): bool
    {
        $moduleId = $this->getExtensionId();
        $moduleIsActive = false;

        $modules = $this->getExtendedClasses();

        if (is_array($modules)) {
            // Check if module was ever installed.
            $moduleExists = false;
            foreach ($modules as $extendPath) {
                if (false !== strpos($extendPath, '/' . $moduleId . '/')) {
                    $moduleExists = true;
                    break;
                }
            }

            // If module exists, check if it is not disabled.
            if ($moduleExists) {
                $disabledModules = $this->getDisabledModules();
                if (!(is_array($disabledModules) && in_array($moduleId, $disabledModules))) {
                    $moduleIsActive = true;
                }
            }
        }

        return $moduleIsActive;
    }
}
