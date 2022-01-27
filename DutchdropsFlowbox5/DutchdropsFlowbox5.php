<?php

namespace DutchdropsFlowbox5;

use DutchdropsFlowbox5\Bootstrap\FlowboxElementInstaller;
use Shopware\Bundle\CookieBundle\CookieCollection;
use Shopware\Bundle\CookieBundle\Structs\CookieGroupStruct;
use Shopware\Bundle\CookieBundle\Structs\CookieStruct;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

/**
 * Shopware-Plugin DutchdropsFlowbox5.
 */
class DutchdropsFlowbox5 extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'CookieCollector_Collect_Cookies' => 'addFlowboxCookie'
        ];
    }

    public function install(InstallContext $installContext)
    {
        $flowboxElementInstaller = new FlowboxElementInstaller(
            $this->getName(),
            $this->container->get('shopware.emotion_component_installer')
        );

        $flowboxElementInstaller->install();

        // Add 'free text field' on product level
        $attrCrud = $this->container->get('shopware_attribute.crud_service');
        $attrCrud->update('s_articles_attributes', 'flowbox_flow_hide', 'boolean', [
            'label'            => 'Hide Flowbox Flow for this product',
            'displayInBackend' => true
        ]);

        parent::install($installContext);
    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache([
            ActivateContext::CACHE_TAG_TEMPLATE,
            ActivateContext::CACHE_TAG_THEME,
            ActivateContext::CACHE_TAG_HTTP,
            ActivateContext::CACHE_TAG_CONFIG
        ]);
    }

    public function deactivate(DeactivateContext $deactivateContext)
    {
        $deactivateContext->scheduleClearCache([
            DeactivateContext::CACHE_TAG_TEMPLATE,
            DeactivateContext::CACHE_TAG_THEME,
            DeactivateContext::CACHE_TAG_HTTP,
            DeactivateContext::CACHE_TAG_CONFIG
        ]);
    }

    public function uninstall(UninstallContext $uninstallContext)
    {
        if ($uninstallContext->keepUserData()) {
            return;
        }

        // Remove 'free text field' on product level
        $attrCrud = $this->container->get('shopware_attribute.crud_service');
        $attrCrud->delete('s_articles_attributes', 'flowbox_flow_hide');

        // Clear only cache when switching from active state to uninstall
        if ($uninstallContext->getPlugin()->getActive()) {
            $uninstallContext->scheduleClearCache([
                UninstallContext::CACHE_TAG_TEMPLATE,
                UninstallContext::CACHE_TAG_THEME,
                UninstallContext::CACHE_TAG_HTTP,
                UninstallContext::CACHE_TAG_CONFIG
            ]);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('dutchdrops_flowbox5.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public function addFlowboxCookie()
    {
        $pluginNamespace = $this->container->get('snippets')->getNamespace('frontend/cookie_consent/cookies');

        $collection = new CookieCollection();
        $collection->add(new CookieStruct(
            'flowbox',
            '/^(_flbx|_flowbox)/',
            $pluginNamespace->get('flowbox_cookies'),
            CookieGroupStruct::STATISTICS
        ));

        return $collection;
    }
}
