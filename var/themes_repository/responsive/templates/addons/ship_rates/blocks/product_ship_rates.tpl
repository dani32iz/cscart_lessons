{if !$ship_block_id}
    {$ship_block_id = $block.block_id}
{/if}

<div id="product_ship_rates_list_{$ship_block_id}">
{if $ship_product_groups}

    {foreach from=$ship_product_groups key="group_key" item=group name="spg"}

        {foreach from=$group.shippings item="shipping"}

                {if $shipping.delivery_time}
                    {assign var="delivery_time" value="(`$shipping.delivery_time`)"}
                {else}
                    {assign var="delivery_time" value=""}
                {/if}

                {if $shipping.rate}
                    {capture assign="rate"}{include file="common/price.tpl" value=$shipping.rate}{/capture}
                    {if $shipping.inc_tax}
                        {assign var="rate" value="`$rate` ("}
                        {if $shipping.taxed_price && $shipping.taxed_price != $shipping.rate}
                            {capture assign="tax"}{include file="common/price.tpl" value=$shipping.taxed_price class="ty-nowrap"}{/capture}
                            {assign var="rate" value="`$rate` (`$tax` "}
                        {/if}
                        {assign var="inc_tax_lang" value=__('inc_tax')}
                        {assign var="rate" value="`$rate``$inc_tax_lang`)"}
                    {/if}
                {else}
                    {assign var="rate" value=__("free_shipping")}
                {/if}

                <p class="ty-shipping-options__method">
                    <label class="ty-valign">{$shipping.shipping} {$delivery_time} - {$rate nofilter}</label>
                </p>

        {/foreach}

    {/foreach}

{else}

    <script type="text/javascript">
        (function(_, $) {

            $.ceEvent('one', 'ce.commoninit', function(context) {

                var product_for_ship_rates = {
                    'product_id': {$product.product_id|doubleval},
                    'amount': 1,
                    'price': '{$product.price|doubleval}',
                    {if $product.selected_options}
                    'product_options': {
                        {foreach from=$product.selected_options item="value" key="key"}
                            {$key} : {$value},
                        {/foreach}
                    }
                    {/if}
                };

                $.ceAjax('request', fn_url('products.shipping_rates'), {
                    result_ids : 'product_ship_rates_list_{$ship_block_id}',
                    hidden: true,
                    data: {
                        'product' : product_for_ship_rates,
                        'ship_block_id' : '{$ship_block_id}',
                    },
                });

            });

        }(Tygh, Tygh.$));
    </script>

{/if}

<!--product_ship_rates_list_{$ship_block_id}--></div>
