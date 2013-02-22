<?php
/**
 * Copyright Zikula Foundation 2012 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version.
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

class SystemPlugin_Tcpdf_Plugin extends Zikula_AbstractPlugin
{
    /**
     * Get plugin meta data.
     *
     * @return array Meta data.
     */
    protected function getMeta()
    {
        return array(
            'displayname' => $this->__('TCPDF'),
            'description' => $this->__('Provides TCPDF pdf generating library'),
            'version'     => '1.0.0'
        );
    }

    /**
     * Checks plugin version and performs install/upgrade routine when needed.
     */
    public function preInitialize()
    {
        $version = $this->getVar('version', false);
        if (!$version) {
            $this->install();
        } elseif ($version !==  $this->getMetaVersion()) {
            $this->upgrade($version);
        }
    }

    /**
     * Initialise.
     *
     * Runs at plugin init time.
     *
     * @return void
     */
    public function initialize()
    {
        $classfile = DataUtil::formatForOS('plugins/Tcpdf/lib/vendor/tcpdf/tcpdf.php');
        require_once($classfile);
        
        $lang = ZLanguage::getInstance();
        $langcode = $lang->getLanguageCodeLegacy();
        
        if($langcode == 'deu')
            $langcode = 'ger';

        $langfile = DataUtil::formatForOS("plugins/Tcpdf/lib/vendor/tcpdf/config/lang/{$langcode}.php");
        if (!file_exists($langfile)) {
            $langfile = DataUtil::formatForOS('plugins/Tcpdf/lib/vendor/tcpdf/config/lang/eng.php');
        }
        require_once($langfile);
    }

    public function createPdf($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa)
    {
        return new TCPDF($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    /**
     * Performs install routine.
     *
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * Performs upgrade routine.
     *
     * @param string $oldVersion
     *
     * @return bool
     */
    public function upgrade($oldVersion)
    {
        return true;
    }

    /**
     * Convenience Module SetVar.
     *
     * @param string $key   Key.
     * @param mixed  $value Value, default empty.
     *
     * @return object This.
     */
    public function setVar($key, $value='')
    {
        ModUtil::setVar($this->getServiceId(), $key, $value);

        return $this;
    }

    /**
     * Convenience Module SetVars.
     *
     * @param array $vars Array of key => value.
     *
     * @return object This.
     */
    public function setVars(array $vars)
    {
        ModUtil::setVars($this->getServiceId(), $vars);

        return $this;
    }

    /**
     * Convenience Module GetVar.
     *
     * @param string  $key     Key.
     * @param boolean $default Default, false if not found.
     *
     * @return mixed
     */
    public function getVar($key, $default=false)
    {
        return ModUtil::getVar($this->getServiceId(), $key, $default);
    }

    /**
     * Convenience Module GetVars for all keys in this module.
     *
     * @return mixed
     */
    public function getVars()
    {
        return ModUtil::getVar($this->getServiceId());
    }

    /**
     * Convenience Module DelVar.
     *
     * @param string $key Key.
     *
     * @return object This.
     */
    public function delVar($key)
    {
        ModUtil::delVar($this->getServiceId(), $key);

        return $this;
    }

    /**
     * Convenience Module DelVar for all keys for this module.
     *
     * @return object This.
     */
    public function delVars()
    {
        ModUtil::delVar($this->getServiceId());

        return $this;
    }
}