<?php $id = $props['id'] ?? 'algolia-autocomplete-' . uniqid(); ?>
<div id="<?php echo $id; ?>"></div>

<script type="text/javascript">
    window.UIkit.util.ready(function () {
        console.log(window.UIkit.algoliaAutocomplete(window.UIkit.util.$('#<?php echo $id; ?>'), <?php echo json_encode($props); ?>));
    })
</script>

