<?php
$el = $this->el('div', []);
?>

<?= $el($props, $attrs); ?>
<ais-pagination
        @page-change="() => window.UIkit.scroll(UIkit.util.$$('.ais-Pagination-item')).scrollTo(window.UIkit.util.$('<?= $props['scroll_to'] ?? '.ais-InstantSearch' ?>'))"
        :class-names="{
            'ais-Pagination':'pagination pagination-toolbar clearfix',
            'ais-Pagination-list': 'pagination-list',
            'ais-Pagination-link': 'uk-padding-small',
            'ais-Pagination-item--selected': 'uk-active'
        }"
></ais-pagination>
<?= $el->end(); ?>
