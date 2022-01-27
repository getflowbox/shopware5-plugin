// {namespace name="backend/emotion/flowbox"}
//{block name="emotion_components/backend/flowbox_flow"}
Ext.define('Shopware.apps.Emotion.view.components.FlowboxFlow', {

    /**
     * Extend from the base class for the emotion components
     */
    extend: 'Shopware.apps.Emotion.view.components.Base',

    /**
     * Create the alias matching the xtype you defined in your `createEmotionComponent()` method.
     * The pattern is always 'widget.' + xtype
     */
    alias: 'widget.emotion-components-flowbox',

    /**
     * Contains the translations of each input field which was created with the EmotionComponentInstaller.
     * Use the name of the field as identifier
     */
    snippets: {
        'Flowbox': {
            'description': '{s name=flowboxDescription}{/s}'
        },
        'flowbox_flow_locale': {
            'fieldLabel': '{s name=flowLocale}{/s}'
        },
        'flowbox_flow_key': {
            'fieldLabel': '{s name=flowKey}{/s}'
        },
        'flowbox_tags': {
            'fieldLabel': '{s name=flowboxTags}{/s}',
            'supportText': '{s name=flowboxTagsSupport}{/s}'
        },
        'flowbox_tags_operator': {
            'fieldLabel': '{s name=flowboxTagsOperator}{/s}'
        },
        'flowbox_tabmenu_tags': {
            'fieldLabel': '{s name=flowboxTabmenuTags}{/s}',
            'supportText': '{s name=flowboxTabmenuTagsSupport}{/s}'
        }
    }

});
//{/block}
