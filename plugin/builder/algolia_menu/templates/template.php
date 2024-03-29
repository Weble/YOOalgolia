<?php
$el = $this->el('div', []);

// Button
$button = $this->el('a', [
    '@click'    => "toggleShowMore",
    ':disabled' => "!canToggleShowMore",
    'class'     => $this->expr([
        'el-content',
        'uk-width-1-1 {@fullwidth}',
        'uk-{button_style: link-\w+}'                                              => ['button_style' => $props['button_style']],
        'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $props['button_style']],
    ], $props),

    'title' => ['{link_title}'],

]);

// Title
$title = null;
if ($props['title'] ?? null) {
    $title = $this->el($props['title_element'], [

        'class' => [
            'uk-{title_style}',
            'uk-heading-{title_decoration}',
            'uk-font-{title_font_family}',
            'uk-text-{title_color} {@!title_color: background}',
        ],

    ]);
}

$buttonAttrs = [
    'v-if="canToggleShowMore"'
];

?>

<?= $el($props, $attrs); ?>

<ais-hierarchical-menu
    :attributes='<?php echo $node->facets; ?>'
    :limit="<?= $props['limit'] ?>"

    <?php if ($props['show_more'] ?? true): ?>
        :show-more-limit="<?= $props['show_more_limit'] ?? 50; ?>"
        show-more
    <?php endif; ?>

/>

    <template
        v-slot="{
            items,
            canToggleShowMore,
            isShowingMore,
            refine,
            toggleShowMore,
            createURL,
            sendEvent
        }"
    >

        <ul class="uk-list uk-list-small facet-filters">
            <li v-for="item in items" :key="item.value">


                <label class="uk-form-label uk-flex uk-flex-row uk-flex-middle">
                    <input
                            class="uk-checkbox uk-margin-small-right"
                            type="checkbox"
                            :value="item.value"
                            :checked="item.isRefined"
                            @change="refine(item.value)"
                    />
                    <span class="uk-flex-1">{{ item.label }}</span>
                    <span class="uk-padding-small-left">{{ item.count }}</span>
                </label>

                <?= $this->render("{$__dir}/template-items", ['facets' => $node->facets_count, 'jsVariable' => 'item', 'level' => 1]) ?>

            </li>
        </ul>


        <?php if ($props['show_more'] ?? true): ?>
            <?= $button($props, $buttonAttrs) ?>
            <?php if ($props['icon']) : ?>
                <?php if ($props['icon_align'] == 'left') : ?>
                    <span v-if="isShowingMore" uk-icon="<?= $props['icon'] ?>"></span>
                    <span v-else uk-icon="<?= $props['icon_less'] ?>"></span>
                <?php endif ?>

                <span class="uk-text-middle" v-if="isShowingMore">
                      <?php echo $props['content_less'] ?>
                </span>
                <span class="uk-text-middle" v-else>
                      <?php echo $props['content_more'] ?>
                </span>

                <?php if ($props['icon_align'] == 'right') : ?>
                    <span v-if="isShowingMore" uk-icon="<?= $props['icon'] ?>"></span>
                    <span v-else uk-icon="<?= $props['icon_less'] ?>"></span>
                <?php endif ?>

            <?php else : ?>
                <span class="uk-text-middle" v-if="isShowingMore">
                      <?php echo $props['content_less'] ?>
                </span>
                <span class="uk-text-middle" v-else>
                      <?php echo $props['content_more'] ?>
                </span>
            <?php endif ?>

            <?= $button->end(); ?>
        <?php endif; ?>


    </template>

</ais-hierarchical-menu>

<?php /*
<ais-refinement-list
        attribute="<?= $node->props['facet'] ?>"
        limit="<?= $props['limit'] ?>"

    <?php if ($props['show_more'] ?? true): ?>
        :show-more-limit="<?= $props['show_more_limit'] ?? 50; ?>"
        show-more
    <?php endif; ?>
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
    >

        <?php if ($title): ?>
            <?php $titleAttrs = ['v-if' => 'items.length > 0']; ?>
            <?= $title($props, $titleAttrs) ?>
            <?php if ($props['title_color'] == 'background') : ?>
                <span class="uk-text-background"><?= $props['title'] ?></span>
            <?php elseif ($props['title_decoration'] == 'line') : ?>
                <span><?= $props['title'] ?></span>
            <?php else : ?>
                <?= $props['title'] ?>
            <?php endif ?>
            <?= $title->end() ?>
        <?php endif ?>
        <ul class="uk-list uk-list-small facet-filters">
            <li v-for="item in items" :key="item.value">
                <label class="uk-form-label uk-flex uk-flex-row uk-flex-middle">
                    <input
                            class="uk-checkbox uk-margin-small-right"
                            type="checkbox"
                            :value="item.value"
                            :checked="item.isRefined"
                            @change="refine(item.value)"
                    />
                    <span class="uk-flex-1">{{ item.label }}</span>
                    <span class="uk-padding-small-left">{{ item.count }}</span>
                </label>
            </li>
        </ul>

        <?php if ($props['show_more'] ?? true): ?>
            <?= $button($props, $buttonAttrs) ?>
            <?php if ($props['icon']) : ?>
                <?php if ($props['icon_align'] == 'left') : ?>
                    <span v-if="isShowingMore" uk-icon="<?= $props['icon'] ?>"></span>
                    <span v-else uk-icon="<?= $props['icon_less'] ?>"></span>
                <?php endif ?>

                <span class="uk-text-middle" v-if="isShowingMore">
                      <?php echo $props['content_less'] ?>
                </span>
                <span class="uk-text-middle" v-else>
                      <?php echo $props['content_more'] ?>
                </span>

                <?php if ($props['icon_align'] == 'right') : ?>
                    <span v-if="isShowingMore" uk-icon="<?= $props['icon'] ?>"></span>
                    <span v-else uk-icon="<?= $props['icon_less'] ?>"></span>
                <?php endif ?>

            <?php else : ?>
                <span class="uk-text-middle" v-if="isShowingMore">
                      <?php echo $props['content_less'] ?>
                </span>
                <span class="uk-text-middle" v-else>
                      <?php echo $props['content_more'] ?>
                </span>
            <?php endif ?>

            <?= $button->end(); ?>
        <?php endif; ?>
    </div>
</ais-refinement-list>

 */ ?>
<?= $el->end(); ?>
