<?php
$container = $this->el('div', [
    'data-algolia' => 'true',
    'v-cloak' => true
]);

$config = $node->algolia ?? [];
$attrs['id'] = $attrs['id'] ?? 'algolia-' . $node->id;
?>

<?= $container($props, $attrs) ?>
    <algolia-search
        algolia-app-id="<?php echo $config['app_id']; ?>"
        algolia-search-key="<?php echo $config['search_key']; ?>"
        algolia-index-name="<?php echo $config['index_name']; ?>"
        inline-template
    >
        <ais-instant-search
                :search-client="searchClient"
                :index-name="algoliaIndexName"
                :routing="routing">
            <div>
                <?= $builder->render($children) ?>
            </div>
        </ais-instant-search>
    </algolia-search>
<?= $container->end(); ?>
