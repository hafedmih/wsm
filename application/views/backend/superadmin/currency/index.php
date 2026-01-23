<?php
$entity = 'currencies'; // change to 'donor'
$role   = 'donor'; // change to 'donor'
$school_id = school_id();
?>
<div class="card">
  <div class="card-body py-2">
    <h4 class="page-title">
      <i class="mdi mdi-account"></i> <?= get_phrase($entity.'s'); ?>
    </h4>

    <button class="btn btn-outline-primary float-end"
      onclick="rightModal('<?= site_url("modal/popup/currency/create") ?>',
      '<?= get_phrase("create_currency") ?>')">
      <i class="mdi mdi-plus"></i> <?= get_phrase("add_currency"); ?>
    </button>
  </div>
</div>

<div class="card">
  <div class="card-body entity_content">
    <?php include 'list.php'; ?>
  </div>
</div>

<script>
function showAll() {
    $.ajax({
        url: '<?= route('currency/list'); ?>',
        success: function(response) {
            $('.institution_content').html(response);
            // Initialize DataTable ONLY after the HTML is placed
            $('#basic-datatable').DataTable(); 
        }
    });
}
</script>
