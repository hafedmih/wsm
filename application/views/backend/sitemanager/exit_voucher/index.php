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
    // On détermine l'URL selon le rôle connecté
    var url = '<?php echo site_url($this->session->userdata('user_type').'/exit_voucher/list'); ?>';
    
    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            // 1. On remplace le contenu
            $('.voucher_content').html(response);
            
            // 2. IMPORTANT: On réinitialise la DataTable pour que la recherche et pagination refonctionnent
            if ($.fn.DataTable.isDataTable('#basic-datatable')) {
                $('#basic-datatable').DataTable().destroy();
            }
            initDataTable('basic-datatable'); 
        }
    });
}
</script>