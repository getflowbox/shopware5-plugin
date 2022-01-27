<?php

namespace DutchdropsFlowbox5\Bootstrap;

use Shopware\Components\Emotion\ComponentInstaller;

class FlowboxElementInstaller
{
    /**
     * @var ComponentInstaller
     */
    private $emotionComponentInstaller;

    /**
     * @var string
     */
    private $pluginName;

    /**
     * @param string $pluginName
     * @param ComponentInstaller $emotionComponentInstaller
     */
    public function __construct($pluginName, ComponentInstaller $emotionComponentInstaller)
    {
        $this->emotionComponentInstaller = $emotionComponentInstaller;
        $this->pluginName = $pluginName;
    }

    public function install()
    {
        $flowboxElement = $this->emotionComponentInstaller->createOrUpdate(
            $this->pluginName,
            'FlowboxElement',
            [
                'name' => 'Flowbox',
                'xtype' => 'emotion-components-flowbox',
                'template' => 'emotion_flowbox',
                'cls' => 'emotion-flowbox-element',
                'description' => 'Add a Flowbox Flow.'
            ]
        );

        $flowboxElement->createTextField([
            'name' => 'flowbox_flow_key',
            'fieldLabel' => 'Flow Key',
            'allowBlank' => false
        ]);

        $flowboxElement->createTextField([
            'name' => 'flowbox_flow_locale',
            'fieldLabel' => 'Flow Locale',
            'allowBlank' => true
        ]);

        $flowboxElement->createTextAreaField([
            'name' => 'flowbox_tags',
            'fieldLabel' => 'Tags',
            'supportText' => 'One tag per line',
            'allowBlank' => true
        ]);

        $flowboxElement->createRadioField([
            'name' => 'flowbox_tags_operator',
            'fieldLabel' => 'Tags Operator',
            'defaultValue' => 'all',
            'supportText' => "All"
        ]);

        $flowboxElement->createRadioField([
            'name' => 'flowbox_tags_operator',
            'fieldLabel' => 'Tags Operator',
            'defaultValue' => 'any',
            'supportText' => "Any",
        ]);
        
        $flowboxElement->createTextAreaField([
            'name' => 'flowbox_tabmenu_tags',
            'fieldLabel' => 'Tab Menu Tags',
            'supportText' => 'One tag per line, make sure the first one is the same as by Tags',
            'allowBlank' => true
        ]);
    }
}