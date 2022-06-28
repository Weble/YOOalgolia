<?php

use Joomla\CMS\Factory;
use function YOOtheme\trans;

$el = $this->el('div', [
    'v-cloak' => true
]);

// Table
$table = $this->el('table', [
    'class' => 'uk-table uk-table-divider',
]);

?>

<?= $el($props, $attrs); ?>


<ais-hits class="algolia-hits-table">
    <div slot-scope="{ items }">
        <div v-for="(type_items, type) in groupBy(items, 'tipologia', 'names')">
            <div class="product-type-name">{{ type }}</div>
            <?= $table($props) ?>
            <thead>
            <tr>
                <?php foreach ($children as $child) : ?>
                    <th><?= $child->props['title'] ?></th>
                <?php endforeach ?>
                <th class="link-column"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in type_items">
                <?php foreach ($children as $child) : ?>
                    <td>{{item['<?= $child->props['value'] ?>']}}</td>
                <?php endforeach ?>
                <td class="link-column"><a class="uk-button uk-button-small uk-button-primary el-link" :href="item.url['<?= JFactory::getLanguage()->getTag() ?>'].default">Dettagli <span uk-icon="chevron-right"></span></a></td>
            </tr>
            </tbody>
            <?= $table->end(); ?>
        </div>
    </div>
</ais-hits>
<?= $el->end(); ?>
