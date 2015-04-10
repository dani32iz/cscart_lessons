<th width="5%" class="nowrap">
    <a class="cm-ajax" href="{"`$c_url`&sort_by=my_setting&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>
        {__("my_setting")}
        {if $search.sort_by == "my_setting"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}
    </a>
</th>