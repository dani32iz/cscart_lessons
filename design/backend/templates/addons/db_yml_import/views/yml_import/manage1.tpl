{** banners section **}

{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="banners_form" class=" cm-hide-inputs" enctype="multipart/form-data">
<input type="hidden" name="fake" value="1" />

{if $banners}
<table class="table table-middle">
<thead>
<tr>
    <th width="1%" class="left">
        {include file="common/check_items.tpl" class="cm-no-hide-input"}</th>
    <th>{__("banner")}</th>
    <th>{__("type")}</th>
    <th width="6%">&nbsp;</th>
    <th width="10%" class="right">{__("status")}</th>
</tr>
</thead>
{foreach from=$banners item=banner}
<tr class="cm-row-status-{$banner.status|lower}">
    {assign var="allow_save" value=$banner|fn_allow_save_object:"banners"}

    {if $allow_save}
        {assign var="no_hide_input" value="cm-no-hide-input"}
    {else}
        {assign var="no_hide_input" value=""}
    {/if}

    <td class="left">
        <input type="checkbox" name="banner_ids[]" value="{$banner.banner_id}" class="cm-item {$no_hide_input}" /></td>
    <td class="{$no_hide_input}">
        <a class="row-status" href="{"banners.update?banner_id=`$banner.banner_id`"|fn_url}">{$banner.banner}</a>
        {include file="views/companies/components/company_name.tpl" object=$banner}
    </td>
    <td class="nowrap row-status {$no_hide_input}">{if $banner.type == "G"}{__("graphic_banner")}{else}{__("text_banner")}{/if}</td>
    <td>
        {capture name="tools_list"}
            <li>{btn type="list" text=__("edit") href="banners.update?banner_id=`$banner.banner_id`"}</li>
        {if $allow_save}
            <li>{btn type="list" class="cm-confirm" text=__("delete") href="banners.delete?banner_id=`$banner.banner_id`"}</li>
        {/if}
        {/capture}
        <div class="hidden-tools">
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
    <td class="right">
        {include file="common/select_popup.tpl" id=$banner.banner_id status=$banner.status hidden=true object_id_name="banner_id" table="banners" popup_additional_class="`$no_hide_input` dropleft"}
    </td>
</tr>
{/foreach}
</table>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{capture name="buttons"}
    {capture name="tools_list"}
        {if $addons.statistics.status == "A"}
            <li>{btn type="list" text=__("banners_statistics") href="statistics.banners"}</li>
             {if $banners}
                <li class="divider"></li>
            {/if}
        {/if}
        {if $banners}
            <li>{btn type="delete_selected" dispatch="dispatch[banners.m_delete]" form="banners_form"}</li>
        {/if}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}
{/capture}
{capture name="adv_buttons"}
    {include file="common/tools.tpl" tool_href="banners.add" prefix="top" hide_tools="true" title=__("add_banner") icon="icon-plus"}
{/capture}

</form>

{/capture}
{include file="common/mainbox.tpl" title=__("banners") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons adv_buttons=$smarty.capture.adv_buttons select_languages=true}

{** ad section **}