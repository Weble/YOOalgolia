<?php
$el = $this->el('div', []);

$search = $this->el('input', [
    'class' => ['uk-input', 'refinementSearch'],
    '@input' => 'searchForItems($event.currentTarget.value)',
    'placeholder' => $props['placeholder'] ?? ''
]);

?>

<?= $el($props, $attrs); ?>
<ais-refinement-list
        attribute="<?= $props['facet'] ?>"
        limit="<?= $props['limit'] ?>"
        searchable
>
    <div
        slot-scope="{
            items,
            isShowingMore,
            isFromSearch,
            canToggleShowMore,
            refine,
            createURL,
            toggleShowMore,
            searchForItems,
            sendEvent,
        }"

        class="uk-position-relative"
    >

        <?= $search($props, $attrs); ?>

        <div class="uk-dropdown uk-open" v-if="isFromSearch">
            <ul class="uk-list">
                <li v-if="!items.length">No results.</li>
                <li v-for="item in items" :key="item.value" v-if="isFromSearch">
                    <a
                        :href="createURL(item)"
                        :style="{ fontWeight: item.isRefined ?  'bold' : '' }"
                        @click.prevent="refine(item.value)"
                    >
                        {{ item.label }}
                    </a>
                </li>
            </ul>
        </div>

    </div>
</ais-refinement-list>
<?= $el->end(); ?>
