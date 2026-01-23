<?php
$entity = 'categorie'; // change to 'donor'
$role   = 'donor'; // change to 'donor'
$school_id = school_id();
?>
<div class="card">
  <div class="card-body py-2">
    <h4 class="page-title">
      <i class="mdi mdi-account"></i> <?= get_phrase($entity.'s'); ?>
    </h4>

    <button class="btn btn-outline-primary float-end"
      onclick="rightModal('<?= site_url("modal/popup/category/create") ?>',
      '<?= get_phrase("create_category") ?>')">
      <i class="mdi mdi-plus"></i> <?= get_phrase("add_category"); ?>
    </button>
  </div>
</div>

<div class="card">
  <div class="card-body entity_content">
    <?php include 'list.php'; ?>
  </div>
</div>

<script>
var showAll = function () {
    $.get("<?= route("category/list"); ?>", function(res){
        $('.entity_content').html(res);
        initDataTable('basic-datatable');
    });
}
</script>
