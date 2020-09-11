<div class="help">
    {ts}<strong>Example for Replace Domain Name:</strong><br/>
      Current Value : https://www.oldexample.org   , New Value : https://www.newexample.org<br/> OR<br/>
      Current Value : https://old.example.org , New Value : https://new.example.org<br/><br/>

      <strong>Example for Replace Extension Path:</strong><br/>
      Current Value : sites/default/files/civicrm/ext/uk.co.vedaconsulting.mosaico , New Value :
      sites/default/civicrm/extensions/uk.co.vedaconsulting.mosaico,<br/>
      make sure new extension directory path exists.
    {/ts}
</div>

{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}

<div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
