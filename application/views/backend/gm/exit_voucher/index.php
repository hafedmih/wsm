<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title d-inline-block">
          <i class="mdi mdi-check-decagram title_icon"></i> <?php echo get_phrase('vouchers_pending_approval'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body voucher_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
var showAllVouchers = function () {
    // On récupère le filtre depuis un champ caché ou l'URL
    var status = $('#status_filter_input').val(); 
    var url = '<?php echo site_url('gm/exit_voucher/list/'); ?>' + status;

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.voucher_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

$(document).ready(function() {
    showAllVouchers();
});
</script>

<!-- Champ caché pour stocker le statut initial (all ou pending) -->
<input type="hidden" id="status_filter_input" value="<?php echo (isset($status_filter)) ? $status_filter : 'all'; ?>">