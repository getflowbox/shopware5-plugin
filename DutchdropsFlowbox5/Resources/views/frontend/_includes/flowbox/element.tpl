{if $fbTabMenuTags}
<div class="flowbox-tags" data-flowboxKey="{$flowboxKey}">
    {foreach from=$fbTabMenuTags key=key item=tabMenuTag name="tabMenuTagLoop"}
        <button data-tag="{if array_key_exists($key, $fbTags)}{$fbTags[$key]}{else}{$tabMenuTag}{/if}" class="btn flowbox-tag{if $smarty.foreach.tabMenuTagLoop.first} is--active{/if}">{$tabMenuTag}</button>
    {/foreach}
</div>
{/if}
<div class="flowbox-widget-container" data-flowboxKey="{$flowboxKey}">
  <div id="js-flowbox-flow-{$fbId}"></div>
</div>

<script>
    {literal}window.flowbox('init', {/literal}{$fbConf|json_encode}{literal});{/literal}
</script>
