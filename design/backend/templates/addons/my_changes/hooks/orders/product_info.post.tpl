<select name="ops[{$oi.item_id}]" class="cm-submit cm-ajax cm-skip-validation" data-ca-dispatch="dispatch[my_select.ops]">
    <option value="A" {if $oi.ops == "A"}selected="selected"{/if}>{__("ops_a")}</option>
    <option value="B" {if $oi.ops == "B"}selected="selected"{/if}>{__("ops_b")}</option>
    <option value="C" {if $oi.ops == "C"}selected="selected"{/if}>{__("ops_c")}</option>
</select>
