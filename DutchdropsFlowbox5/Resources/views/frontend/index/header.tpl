{extends file="parent:frontend/index/header.tpl"}

{* Block for tracking codes which are required to include in the `head` section of the document *}
{block name="frontend_index_header_javascript_tracking" append}
{include file="frontend/_includes/flowbox/snippet.tpl"}
{/block}