{block name="widgets_flowbox_emotion"}
    {assign var="flowboxEmotionLanguage" value="{config name="DutchdropsFlowbox5::flowbox_flow_language"}"}
    {assign var="flowboxKey" value="{$wData.flowbox_flow_key}"}

    {if $wData.flowbox_flow_locale}
        {assign var="flowboxLocale" value=$wData.flowbox_flow_locale}
    {else}
        {assign var="flowboxLocale" value=$flowboxEmotionLanguage}
    {/if}

    {$flowboxConf = [
    "container" => "#js-flowbox-flow-{$wId}",
    "key" => $wData.flowbox_flow_key,
    "locale" => $flowboxLocale,
    "allowCookies" => $allowFlowboxCookie
    ]}

    {if $wData.flowbox_tags}
        {assign var="flowboxTags" value="\n"|explode:$wData.flowbox_tags}
        {$flowboxConf['tags'] = $flowboxTags}
        {$flowboxConf['tagsOperator'] = $wData.flowbox_tags_operator}
    {/if}

    {if $wData.flowbox_tabmenu_tags}
        {assign var="flowboxTabMenuTags" value="\n"|explode:$wData.flowbox_tabmenu_tags}
    {/if}

    {include file="frontend/_includes/flowbox/element.tpl" fbKey=$flowboxKey fbId=$wId fbConf=$flowboxConf fbTabMenuTags=$flowboxTabMenuTags}
{/block}