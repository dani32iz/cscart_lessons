{if $cities_qroups}

    {foreach from=$cities_qroups item=cities}
        <div class="ty-column{$addons.city.columns_count}">
            {foreach from=$cities item=city}
                {$city.city}<br/>
            {/foreach}
        </div>
    {/foreach}


{else}
    <p class="ty-no-items">{__("no_data")}</p>
{/if}

{capture name="mainbox_title"}{__("city.list.title")}{/capture}