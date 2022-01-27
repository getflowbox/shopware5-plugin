{block name="widgets_flowbox_detail"}
    {assign var="flowboxPdpLanguage" value="{config name="DutchdropsFlowbox5::flowbox_flow_language"}"}
    {assign var="flowboxPdpKey" value="{config name="DutchdropsFlowbox5::flowbox_pdp_flow_key"}"}

    {$flowboxPdpConf = [
    "container" => "#js-flowbox-flow-{$wArticleId}",
    "key" => "{$flowboxPdpKey}",
    "locale" => "{$flowboxPdpLanguage}",
    "allowCookies" => {$allowFlowboxCookie}
    ]}

    {if $flowboxPdpDynamic == "yes"}
        {if $flowboxPdpIdentifier == "Sku" }
            {$flowboxPdpConf["productId"] = "{$wArticleOrdernumber}"}
        {elseif $flowboxPdpIdentifier == "Ean" }
            {$flowboxPdpConf["productId"] = "{$wArticleEan}"}
        {else}
            {$flowboxPdpConf["productId"] = "{$wArticleId}"}
        {/if}
    {/if}

    {include file="frontend/_includes/flowbox/element.tpl" fbId="{$wArticleId}" fbConf=$flowboxPdpConf flowboxKey=$flowboxPdpKey}
{/block}
