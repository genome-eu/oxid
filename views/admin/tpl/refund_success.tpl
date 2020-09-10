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
<h4>[{oxmultilang ident="ORDER_REFUND_SUCCESS"}]</h4>

[{oxscript}]

<script type="text/javascript" src="[{$oViewConf->getModuleUrl('genome','out/admin/src/js/genome_order.js')}]"></script>
<script type="text/javascript">
    window.onload = function () {
        top.oxid.admin.updateList('[{$sOxid}]')
    };
</script>