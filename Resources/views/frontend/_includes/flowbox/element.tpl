{if $fbTabMenuTags}
<div class="flowbox-tags" data-flowboxKey="{$flowboxKey}">
    {foreach from=$fbTabMenuTags item=tabMenuTag name="tabMenuTagLoop"}
        <button data-tag="{$tabMenuTag}" class="btn flowbox-tag{if $smarty.foreach.tabMenuTagLoop.first} is--active{/if}">{$tabMenuTag}</button>
    {/foreach}    
</div>
{/if}
<div id="js-flowbox-flow-{$fbId}"></div>

<script>    
    {literal}window.flowbox('init', {/literal}{$fbConf|json_encode}{literal});{/literal}
</script>
