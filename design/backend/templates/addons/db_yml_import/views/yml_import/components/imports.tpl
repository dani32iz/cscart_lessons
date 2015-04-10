    {if $urls|is_array}
        {assign var="urls_ids" value=$urls|array_keys}
    {/if}

    <input type="hidden" value="{if $urls_ids}{","|implode:$urls_ids}{/if}" name="import_data[original_url_ids]">
    <table class="table table-middle" width="100%">
    <thead>
    <tr class="cm-first-sibling">
        <th width="5%">{__("id")}</th>
        <th width="50%">{__("url")}</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody class="hover" id="box_import_urls">

    {foreach from=$urls item="url" name="import"}
    {assign var="num" value=$smarty.foreach.import.iteration}
    <tr>
        <td width="5%">
            <input type="hidden" name="import_data[urls][{$num}][url_id]" value="{$url.url_id}">
            {$url.url_id}
            </td>
        <td>
            <input type="text" name="import_data[urls][{$num}][url]" value="{$url.url}" class="span6 input-hidden cm-feature-value"></td>
        <td>
            <input type="text" name="import_data[urls][{$num}][price]" value="{$url.price}" class="span2 input-hidden cm-feature-value"></td>
        <td>&nbsp;</td>
        <td class="right nowrap">
            <div class="hidden-tools">
            {include file="buttons/multiple_buttons.tpl" item_id="import_urls_`$url.url_id`" tag_level="3" only_delete="Y"}
            </div>
        </td>
    </tr>
    {/foreach}
    </tbody>

    {math equation="x + 1" assign="num" x=$num|default:0}
    {$url = array()}
    <tbody class="hover" id="box_add_urls_for_existing">
    <tr>
        <td></td>
        <td>
            <input type="text" name="import_data[urls][{$num}][url]" value="" class="span6 cm-feature-value" /></td>
        <td>
            <input type="text" name="import_data[urls][{$num}][price]" value="" class="span2 cm-feature-value" /></td>
        <td>&nbsp;</td>
        <td class="right">
            <div class="hidden-tools">
                {include file="buttons/multiple_buttons.tpl" item_id="add_urls_for_existing" tag_level=2}
            </div>
        </td>
    </tr>
    </tbody>
    </table>