<?php 
    $po_id = $param1; 
    $next_status = $param2; 
    
    // Titres dynamiques selon l'étape
    $titles = [
        2 => ['label' => 'Site Manager Signature', 'type' => 'site_signed_doc'],
        3 => ['label' => 'Procurement Verification Scan', 'type' => 'procurement_signed_doc'],
        4 => ['label' => 'GM Final Signature', 'type' => 'gm_signed_doc'],
        5 => ['label' => 'Supplier Invoice Upload', 'type' => 'invoice_doc'],
        6 => ['label' => 'Payment Proof (Bankly/Sedad)', 'type' => 'payment_doc']
    ];
    $config = $titles[$next_status];
?>
<?php include 'details.php'; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url($this->session->userdata('user_type').'/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
    <input type="hidden" name="status" value="<?php echo $next_status; ?>">
    <input type="hidden" name="doc_type" value="<?php echo $config['type']; ?>">

    <!-- ÉTAPE 5 : CHAMPS SUPPLÉMENTAIRES POUR L'AGENT D'ACHAT -->
    <?php if($next_status == 5): ?>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label><?php echo get_phrase('supplier_name'); ?> *</label>
                <input type="text" name="supplier_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-2">
                <label><?php echo get_phrase('supplier_phone'); ?></label>
                <input type="text" name="supplier_phone" class="form-control">
            </div>
        </div>
    <h5 class="mt-3"><?php echo get_phrase('accepted_payment_methods_by_supplier'); ?></h5>
    <div class="row px-2">
        <?php 
            $all_methods = $this->db->get_where('payment_methods', ['status' => 1])->result_array();
            foreach($all_methods as $m): 
        ?>
        <div class="col-md-4 mb-1">
            <div class="form-check">
                <input type="checkbox" name="suggested_methods[]" value="<?php echo $m['name']; ?>" class="form-check-input" id="meth_<?php echo $m['id']; ?>">
                <label class="form-check-label" for="meth_<?php echo $m['id']; ?>"><?php echo $m['name']; ?></label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
        <h5 class="mt-3"><?php echo get_phrase('update_item_prices'); ?></h5>
        <div class="table-responsive">
            <table class="table table-sm">
                <?php 
                $items = $this->db->select('purchase_order_items.*, inventory.name')
                                  ->join('inventory', 'inventory.id = purchase_order_items.inventory_id')
                                  ->get_where('purchase_order_items', ['purchase_order_id' => $po_id])->result_array();
                foreach($items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?> (x<?php echo $item['quantity']; ?>)</td>
                    <td>
                        <input type="hidden" name="item_ids[]" value="<?php echo $item['id']; ?>">
                        <input type="number" step="0.01" name="unit_prices[]" class="form-control" placeholder="Prix Unitaire" required>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="form-group mb-3">
        <label><?php echo get_phrase($config['label']); ?> *</label>
        <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf" required>
    </div>

    <button class="btn btn-primary w-100" type="submit"><?php echo get_phrase('confirm_and_upload'); ?></button>
</form>

<script>
$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        contentType: false, processData: false,
        success: function(response) {
            var data = JSON.parse(response);
            if(data.status) {
                success_notify(data.notification);
                $('#right-modal').modal('hide');
                showAllPurchaseOrders();
            } else {
                error_notify(data.notification);
            }
        }
    });
});
</script>