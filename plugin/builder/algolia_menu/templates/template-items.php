<?php
$newJsVariable = 'sub' . $jsVariable;
?>

<ul v-if="<?php echo $jsVariable; ?>.data" class="uk-list uk-list small facet-filters uk-margin-left">
    <li v-for="<?php echo $newJsVariable; ?> in <?php echo $jsVariable; ?>.data" :key="<?php echo $newJsVariable; ?>.value">


        <label class="uk-form-label uk-flex uk-flex-row uk-flex-middle">
            <input
                class="uk-checkbox uk-margin-small-right"
                type="checkbox"
                :value="<?php echo $newJsVariable; ?>.value"
                :checked="<?php echo $newJsVariable; ?>.isRefined"
                @change="refine(<?php echo $newJsVariable; ?>.value)"
            />
            <span class="uk-flex-1">{{ <?php echo $newJsVariable; ?>.label }}</span>
            <span class="uk-padding-small-left">{{ <?php echo $newJsVariable; ?>.count }}</span>
        </label>

        <?php if ($level <= $facets): ?>
            <?= $this->render("{$__dir}/template-items", ['facets' => $facets, 'jsVariable' => $newJsVariable, 'level' => $level + 1]) ?>
        <?php endif; ?>
    </li>
</ul>


