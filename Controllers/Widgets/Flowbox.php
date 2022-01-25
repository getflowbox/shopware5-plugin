<?php

use Shopware\Bundle\CookieBundle\Services\CookieHandler;
use Shopware\Bundle\CookieBundle\Structs\CookieGroupStruct;

class Shopware_Controllers_Widgets_Flowbox extends Enlight_Controller_Action
{
    public function preDispatch()
    {
        $pluginPath = $this->container->getParameter('dutchdrops_flowbox5.plugin_dir');

        $this->get('template')->addTemplateDir($pluginPath . '/Resources/views/');
    }

    public function EmotionAction()
    {
        $this->View()->setCaching(false);
        $this->View()->assign('wId', $this->Request()->getParam('wId'));
        $this->View()->assign('wData', $this->Request()->getParam('wData'));
        $this->View()->assign('allowFlowboxCookie', $this->allowFlowboxCookie());
    }

    public function DetailAction()
    {
        $this->View()->setCaching(false);
        $this->View()->assign('wArticleId', $this->Request()->getParam('wArticleId'));
        $this->View()->assign('wArticleOrdernumber', $this->Request()->getParam('wArticleOrdernumber'));
        $this->View()->assign('wArticleEan', $this->Request()->getParam('wArticleEan'));
        $this->View()->assign('flowboxPdpDynamic', $this->Request()->getParam('flowboxPdpDynamic'));
        $this->View()->assign('flowboxPdpIdentifier', $this->Request()->getParam('flowboxPdpIdentifier'));
        $this->View()->assign('allowFlowboxCookie', $this->allowFlowboxCookie());
    }

    /**
     * @return bool
     */
    private function allowFlowboxCookie()
    {
        // Starting point is to allow Flowbox cookies
        $allow = true;

        // Let's see if user has configured which cookies to allow
        if (Shopware()->Front()->Request()->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME)) {
            $cookiePreferences = json_decode(Shopware()->Front()->Request()->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME), true);
            $statisticsCookies    = array();

            if (isset($cookiePreferences['groups'][CookieGroupStruct::STATISTICS]['cookies'])) {
                $statisticsCookies = $cookiePreferences['groups'][CookieGroupStruct::STATISTICS]['cookies'];
            }

            foreach ($statisticsCookies as $statisticsCookie) {

                if ($statisticsCookie['name'] == 'flowbox' && $statisticsCookie['active']) {
                    $allow = true;
                } elseif ($statisticsCookie['name'] == 'flowbox' && !$statisticsCookie['active']) {
                    $allow = false;
                }
            }
        }

        // Check if all cookies are allowed with the 'accept all' button
        if (Shopware()->Front()->Request()->getCookie('allowCookie')) {
            $allow = true;
        }

        // Cookie declined always overrules the others
        if (Shopware()->Front()->Request()->getCookie('cookieDeclined')) {
            $allow = false;
        }

        return $allow;
    }
}
