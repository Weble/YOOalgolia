<?php
$el = $this->el('div', $attrs);

$search = $this->el('ais-sort-by', [
    ':items' => json_encode($props['sorting_items'])
])
?>

<?= $el($props, $attrs); ?>
    <?= $search($props) ?>
        <?php if ($props['template'] === "subnav") : ?>
        <div class="uk-flex-right uk-grid-small" slot-scope="{ items, currentRefinement, refine }" uk-grid>
            <span class="sort-by-text"><?= $props['sort_by_text'] ?></span>
            <div>
                <ul class="uk-subnav">
                    <li class="el-item" v-for="item in items" :key="item.value" :value="item.value">
                        <a
                            href="#"
                            :class="{ 'uk-text-secondary': item.value === currentRefinement }"
                            @click.prevent="refine(item.value)"
                        >
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php endif ?>
    <?= $search->end() ?>
<?= $el->end(); ?>
