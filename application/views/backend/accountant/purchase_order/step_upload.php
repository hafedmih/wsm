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

<form method="POST" class="d-block ajaxForm" action="<?php echo site_url($this->session->userdata('user_type').'/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
    <input type="hidden" name="status" value="<?php echo $next_status; ?>">
    <input type="hidden" name="doc_type" value="<?php echo $config['type']; ?>">

    <div class="form-group mb-3">
        <label><?php echo get_phrase($config['label']); ?> *</label>
        <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf" required>
    </div>

    <button class="btn btn-primary w-100" type="submit"><?php echo get_phrase('upload_and_confirm'); ?></button>
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