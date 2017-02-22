<script id="content-tpl" type="text/x-handlebars-template">
    {{#if link}}
        <div class="input">
        	<label for="title_field">Titel: </label>
        	<input id="title_field" type="text" value="{{ link.title }}"></input>
        </div>
        <div class="input">
        	<label for="link_field">Link: </label>
        	<input id="link_field" type="text" value="{{ link.link }}"></input>
        </div>
        <div class="save"><button><?php p($l->t('Save')); ?></button></div>
    {{else}}
        <div class="input">
        	<label for="title_field">Titel: </label>
        	<input id="title_field" type="text" disabled></input>
        </div>
        <div class="input">
        	<label for="link_field">Link: </label>
        	<input id="link_field" type="text" disabled></input>
        </div>
        <div class="save"><button disabled><?php p($l->t('Save')); ?></button></div>
    {{/if}}
</script>
<div id="editor"></div>