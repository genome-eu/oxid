[{if $sPaymentID == "oxidgenome"}]
    <div class="well well-sm">
        <dl>
            <dt>
                <input id="payment_[{$sPaymentID}]" type="radio" name="paymentid" value="[{$sPaymentID}]"
                [{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]checked[{/if}]>
                <label for="payment_[{$sPaymentID}]"><b>[{$paymentmethod->oxpayments__oxdesc->value}]</b></label>
            </dt>
            <dd class="[{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]activePayment[{/if}]">
                [{if $paymentmethod->getPrice() && $paymentmethod->oxpayments__oxaddsum->rawValue != 0}]
                    [{if $oxcmp_basket->getPayCostNet()}]
                        [{$paymentmethod->getFNettoPrice()}] [{$currency->sign}] [{oxmultilang ident="GENOME_PLUS_VAT"}] [{$paymentmethod->getFPriceVat()}]
                    [{else}]
                        [{$paymentmethod->getFBruttoPrice()}] [{$currency->sign}]
                    [{/if}]
                [{/if}]
            </dd>
            <div>
                [{if $paymentmethod->oxpayments__oxlongdesc|trim}]
                    <div>
                        [{$paymentmethod->oxpayments__oxlongdesc->getRawValue()}]
                    </div>
                [{/if}]
            </div>
        </dl>
    </div>
[{elseif $sPaymentID != "oxidgenome"}]
    [{$smarty.block.parent}]
[{/if}]
