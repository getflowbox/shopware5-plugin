{extends file="parent:frontend/checkout/finish.tpl"}

{block name="frontend_index_header_javascript_data"}
    {$smarty.block.parent}

    {assign var="flowboxEnableCheckoutScript" value="{config name="DutchdropsFlowbox5::flowbox_enable_checkout_script"}"}

    {if $flowboxEnableCheckoutScript == "yes"}
        {assign var="flowboxPdpIdentifier" value="{config name="DutchdropsFlowbox5::flowbox_product_identifier"}"}
        {assign var="flowboxCheckoutIdentifier" value="{config name="DutchdropsFlowbox5::flowbox_checkout_api_key"}"}

        {foreach $sBasket.content as $key => $sBasketItem}
            {if $flowboxPdpIdentifier == "Sku" }
                {$Products[$key]["id"] = "{$sBasketItem.ordernumber}"}
            {elseif $flowboxPdpIdentifier == "Ean" }
                {$Products[$key]["id"] = "{$sBasketItem.ean}"}
            {else}
                {$Products[$key]["id"] = "{$sBasketItem.articleID}"}
            {/if}
            {$Products[$key]["quantity"] = {$sBasketItem.quantity}|intval}
        {/foreach}
        <script>
            {literal}
            !function (e, t) {
                var o = document.createElement("script");
                o.type = "text/javascript", o.readyState ? o.onreadystatechange = function () {
                    ("loaded" === o.readyState || "complete" === o.readyState) && (o.onreadystatechange = null, t())
                } : o.onload = function () {
                    t()
                }, o.src = e, document.getElementsByTagName("head")[0].appendChild(o)
            }("//connect.getflowbox.com/bzfy-checkout.js", function () {
                window.flowboxCheckout.checkout({
                    apiKey: {/literal}"{$flowboxCheckoutIdentifier}"{literal},
                    products: {/literal}{$Products|@json_encode nofilter}{literal},
                    orderId: {/literal}{$sOrderNumber}{literal}
                })
            });
            {/literal}
        </script>
    {/if}
{/block}