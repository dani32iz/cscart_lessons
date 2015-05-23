{if $cities}
    {$cities}
{else}
    <p class="ty-no-items">{__("no_data")}</p>
{/if}

{capture name="mainbox_title"}{__("city.list.title")}{/capture}