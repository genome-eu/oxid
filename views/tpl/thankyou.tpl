[{assign var="processing" value=$oView->checkOrderProcessing()}]

[{if $processing == true}]
<strong>[{oxmultilang ident="GENOME_PAYMENT_PROCESSING"}]</strong>
[{else}]
<strong>[{oxmultilang ident="GENOME_PAYMENT_DECLINED"}]</strong>
[{/if}]
<br/><br/>