<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title">
          <i class="mdi mdi-briefcase title_icon"></i> <?php echo get_phrase('projects'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle float-end mt-1" onclick="rightModal('<?php echo site_url('modal/popup/project/create'); ?>', '<?php echo get_phrase('add_project'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_project'); ?></button>
        </h4>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body project_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
var showAllProjects = function () {
  $.ajax({
    url: '<?php echo site_url('gm/project/list'); ?>',
    success : function(response) {
      $('.project_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>