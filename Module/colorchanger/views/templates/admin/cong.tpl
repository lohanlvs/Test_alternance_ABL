<form action="{$current}&token={$token}" method="post" class="defaultForm">
    <fieldset>
        <legend>{$module->l('Modifier les couleures')}</legend>

        <label>{$module->l('Couleur du Header')}</label>
        <div class="margin-form">
            <input type="color" name="COULEUR_HEADER" value="{$helper->fields_value.COULEUR_HEADER}">
        </div>

        <label>{$module->l('Couleur du Body')}</label>
        <div class="margin-form">
            <input type="color" name="COULEUR_BODY" value="{$helper->fields_value.COULEUR_BODY}">
        </div>

        <label>{$module->l('Couleur du Footer')}</label>
        <div class="margin-form">
            <input type="color" name="COULEUR_FOOTER" value="{$helper->fields_value.COULEUR_FOOTER}">
        </div>

        <div class="margin-form">
            <input type="submit" value="{$module->l('Save')}" name="submitColorChanger" class="button">
        </div>
    </fieldset>
</form>
