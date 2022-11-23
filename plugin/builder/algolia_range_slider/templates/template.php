<?php
$el = $this->el('div', []);
?>

<?= $el($props, $attrs); ?>
    <ais-range-input
            attribute="<?php echo $props['attribute']; ?>"
            :min="<?php echo $props['min']; ?>"
            :max="<?php echo $props['max']; ?>"
            :precision="<?php echo $props['precision']; ?>"
    >
        <template v-slot="{ currentRefinement, range, refine }">

            <vue-slider
                    :min="range.min"
                    :max="range.max"
                    :lazy="true"
                    :value="toValue(currentRefinement, range)"
                    @change="refine({ min: $event[0], max: $event[1] })"
            />

        </template>
    </ais-range-input>
<?= $el->end(); ?>