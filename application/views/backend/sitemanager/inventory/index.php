<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title d-inline-block">
          <i class="mdi mdi-archive title_icon"></i> <?php echo get_phrase('warehouse_inventory'); ?>
        </h4>
        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle float-end mt-1" onclick="rightModal('<?php echo site_url('modal/popup/inventory/create'); ?>', '<?php echo get_phrase('add_new_product'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_product'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <label><?php echo get_phrase('select_depot'); ?></label>
        <select class="form-control select2" data-toggle="select2" id="site_filter" onchange="showAllInventory()">
            <option value="1"><?php echo get_phrase('nouakchott_depot'); ?></option>
            <option value="2"><?php echo get_phrase('tasiast_depot'); ?></option>
        </select>
    </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body inventory_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
var showAllInventory = function () {
  var site_id = $('#site_filter').val();
  $.ajax({
    url: '<?php echo site_url('storekeeper/inventory/list/'); ?>' + site_id,
    success : function(response) {
      $('.inventory_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>