<?php
$entity = 'ministry'; 
$school_id = school_id();
?>
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title d-inline-block">
          <i class="mdi mdi-bank title_icon"></i> <?= get_phrase($entity.'s'); ?>
        </h4>

        
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body ministry_content">
                <?php include 'list.php'; ?>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>
// Standard function to refresh the list via AJAX
var showAll = function () {
    var url = "<?= route("$entity/list"); ?>";
    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.ministry_content').html(response);
            // Re-initialize DataTable after content load
            initDataTable('basic-datatable'); 
        }
    });
}
</script>