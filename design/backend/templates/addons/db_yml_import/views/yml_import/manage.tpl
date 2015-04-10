{assign var="allow_save" value=$banner|fn_allow_save_object:"yml_import"}


{capture name="mainbox"}

<form action="{""|fn_url}" method="post" class="form-horizontal form-edit  {if !$allow_save} cm-hide-inputs{/if}" name="yml_import_form" enctype="multipart/form-data">
<input type="hidden" class="cm-no-hide-input" name="fake" value="1" />
<input type="hidden" class="cm-no-hide-input" name="banner_id" value="{$id}" />

{capture name="tabsbox"}
<div id="content_general">

    {if "ULTIMATE"|fn_allowed_for}
        {include file="views/companies/components/company_field.tpl"
            name="banner_data[company_id]"
            id="banner_data_company_id"
            selected=$banner.company_id
        }
    {/if}
    <div class="control-group">
        <label class="control-label">{__("select_file")}:</label>
        <div class="controls">{include file="common/fileuploader.tpl" var_name="yml_file[0]"}</div>
    </div>

    {include file="addons/db_yml_import/views/yml_import/components/imports.tpl"}


</div>
{/capture}
{include file="common/tabsbox.tpl" content=$smarty.capture.tabsbox active_tab=$smarty.request.selected_section track=true}

{capture name="buttons"}
    {include file="buttons/button.tpl" but_text=__("save") but_name="dispatch[yml_import.save]" but_role="submit-link" but_target_form="yml_import_form" but_meta="cm-tab-tools"}
    {include file="buttons/button.tpl" but_text=__("import") but_name="dispatch[yml_import.import]" but_role="submit-link" but_target_form="yml_import_form" but_meta="cm-tab-tools"}
{/capture}
    
</form>

{/capture}

{notes}
    {__("yml_import.manage.notes")}
{/notes}

{include file="common/mainbox.tpl" title=__('yml_import.title') content=$smarty.capture.mainbox buttons=$smarty.capture.buttons}

