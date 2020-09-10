[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
[{oxscript include="js/libs/jquery.min.js"}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="oxidCopy" value="[{$oxid}]">
    <input type="hidden" name="cl" value="delivery_main">
    <input type="hidden" name="language" value="[{$actlang}]">
</form>
<br/>
[{if $oViewConf->isOrderRefunded($oxid)}]
<h4>[{oxmultilang ident="ORDER_ALREADY_REFUNDED"}]</h4>
[{elseif !$oViewConf->isOrderCompleted($oxid)}]
<h4>[{oxmultilang ident="ORDER_NOT_YET_COMPLETED"}]</h4>
[{else}]
<form name="refund-form" id="refund-form" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="genomerefund_genome">
    <input type="hidden" name="fnc" value="refund">
    <input type="submit" value="[{oxmultilang ident="ORDER_REFUND_BUTTON"}]" />
</form>
[{/if}]
   
[{oxscript}]

<script type="text/javascript" src="[{$oViewConf->getModuleUrl('ggenome','out/admin/src/js/genome_order.js')}]"></script>
<script type="text/javascript">
    window.onload = function () {
        top.oxid.admin.updateList('[{$sOxid}]')
    };
</script>