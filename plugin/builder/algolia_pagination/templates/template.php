<?php
$el = $this->el('div', []);
$scrollTo = $props['scroll_to'] ?? '.ais-InstantSearch';
?>

<?= $el($props, $attrs); ?>
<ais-pagination
        @page-change="() => window.UIkit.scroll(window.UIkit.util.$('body')).scrollTo(window.UIkit.util.$('<?= $scrollToClass ?>'))"
        :class-names="{
            'ais-Pagination':'pagination pagination-toolbar clearfix',
            'ais-Pagination-list': 'pagination-list',
            'ais-Pagination-link': 'uk-padding-small',
            'ais-Pagination-item--selected': 'uk-active'
        }"
></ais-pagination>
<?= $el->end(); ?>
