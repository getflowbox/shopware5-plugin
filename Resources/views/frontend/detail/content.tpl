{extends file="parent:frontend/detail/content.tpl"}

{* Crossselling tab panel *}
{block name="frontend_detail_index_tabs_cross_selling"}
    {assign var="flowboxPdpPosition" value="{config name="DutchdropsFlowbox5::flowbox_pdp_position"}"}
    {assign var="flowboxPdpDynamic" value="{config name="DutchdropsFlowbox5::flowbox_pdp_dynamic"}"}

    {if $flowboxPdpPosition != "before"}
        {$smarty.block.parent}
    {/if}

    {assign var="flowboxPdpActive" value="{config name="DutchdropsFlowbox5::flowbox_pdp_active"}"}
    {assign var="flowboxPdpIdentifier" value="{config name="DutchdropsFlowbox5::flowbox_product_identifier"}"}

    {if $flowboxPdpActive == "yes" && !$sArticle.attributes.flowbox_flow_hide}
        <div class="product-flowbox-container{if $flowboxPdpPosition == "before"} product-flowbox-container_before{else} product-flowbox-container_after{/if}">
            {action
            module=widgets
            controller=flowbox
            action=detail
            wArticleId=$sArticle.articleID
            wArticleOrdernumber=$sArticle.ordernumber
            wArticleEan=$sArticle.ean
            flowboxPdpDynamic=$flowboxPdpDynamic
            flowboxPdpIdentifier=$flowboxPdpIdentifier}
        </div>
    {/if}

    {if $flowboxPdpPosition != "after"}
        {$smarty.block.parent}
    {/if}
{/block}