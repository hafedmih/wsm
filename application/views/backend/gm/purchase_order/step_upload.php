<?php 
    $po_id = $param1; 
    $next_status = $param2; 
    
    $titles = [
        2 => ['label' => 'Site Manager Signature', 'type' => 'site_signed_doc'],
        3 => ['label' => 'Procurement Verification Scan', 'type' => 'procurement_signed_doc'],
        4 => ['label' => 'GM Final Signature', 'type' => 'gm_signed_doc'],
        5 => ['label' => 'Supplier Invoice Upload', 'type' => 'invoice_doc'],
        6 => ['label' => 'Payment Proof (Bankly/Sedad/Bank)', 'type' => 'payment_doc']
    ];
    $config = $titles[$next_status];
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo site_url($this->session->userdata('user_type').'/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
    <input type="hidden" name="status" value="<?php echo $next_status; ?>">
    <input type="hidden" name="doc_type" value="<?php echo $config['type']; ?>">

    <!-- AJOUT : Menu déroulant des banques SI étape 6 -->
    <?php if($next_status == 6): ?>
    <div class="form-group mb-3">
        <label><?php echo get_phrase('select_payment_method'); ?> *</label>
        <select name="payment_method_name" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('choose_bank_or_app'); ?></option>
            <?php 
                $methods = $this->db->get_where('payment_methods', ['status' => 1])->result_array();
                foreach($methods as $m): 
            ?>
                <option value="<?php echo $m['name']; ?>"><?php echo $m['name']; ?></option>
            <?php endforeach; ?>
        </select>
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