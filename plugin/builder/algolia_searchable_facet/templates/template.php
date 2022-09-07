<?php
$el = $this->el('div', [ 'class' => ['searchableRefinements']]);

$search = $this->el('input', [
    'class' => ['uk-input', 'refinementSearch'],
    '@input' => 'searchForFacets('. $node->filters .', $event.currentTarget.value); dropdown = true',
    'placeholder' => $props['placeholder'] ?? ''
]);

?>


<?= $el($props, $attrs); ?>
    <ul class="uk-flex uk-subnav">

        <li v-for="filter in filters"><a @click="toggleFilter(filter.attribute, filter.value)">{{ filter.value }}</a></li>

        <li><?= $search($props, $attrs); ?></li>
    </ul>


    <div class="uk-dropdown uk-open"
         v-show="searchableFacets.length && dropdown"
    >
        <ul class="uk-list">
            <li v-for="facet in searchableFacets" >
                <a @click="toggleFilter(facet.facet, facet.value); dropdown = false">{{ renameAttributes(facet.facet, <?= $node->facet_names ?>) }}: {{ facet.value }}</a>
            </li>
        </ul>
    </div>

    <ais-configure
        v-bind="{filters: getFormattedFilters('<?php echo $node->other_filters; ?>')}"
    />
<?= $el->end(); ?>
