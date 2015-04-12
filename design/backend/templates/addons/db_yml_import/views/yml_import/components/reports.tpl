{if $log.log}
    <table class="table table-middle" width="100%">
    <thead>
    <tr>
        <th>{__('yml_import.log')}</th>
    </tr>
    </thead>
    <tbody >
    <tr>
        <td>
            <a href="{"yml_import.getfile?file=`$log.log`"|fn_url}"><span>{$log.log}</span></a>          
        </td>
    </tr>
    </tbody>
    </table>
{/if}
{if $log.errors}
    <table class="table table-middle" width="100%">
    <thead>
    <tr>
        <th>{__('yml_import.errors')}</th>
    </tr>
    </thead>
    <tbody >
    <tr>
        <td>
            <a href="{"yml_import.getfile?file=`$log.errors`"|fn_url}"><span>{$log.errors}</span></a>      
        </td>
    </tr>
    </tbody>
    </table>
{/if}