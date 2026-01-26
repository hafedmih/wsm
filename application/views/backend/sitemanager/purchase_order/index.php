<!-- TITRE ET BOUTON AJOUTER -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title d-inline-block">
          <i class="mdi mdi-cart-plus title_icon"></i> <?php echo get_phrase('purchase_orders_workflow'); ?>
        </h4>
        
        <!-- Seul le Storekeeper peut créer un nouveau PO -->
        <?php if($this->session->userdata('user_type') == 'storekeeper'): ?>
        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle float-end mt-1" onclick="rightModal('<?php echo site_url('modal/popup/purchase_order/create'); ?>', '<?php echo get_phrase('create_new_po'); ?>')"> 
            <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_purchase_order'); ?>
        </button>
        <?php endif; ?>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<!-- LISTE DES BONS DE COMMANDE -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body po_content">
        <!-- Chargement initial -->
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
/**
 * Rafraîchissement AJAX de la liste
 */
var showAllPurchaseOrders = function () {
  var url = '<?php echo site_url($this->session->userdata('user_type').'/purchase_order/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.po_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>