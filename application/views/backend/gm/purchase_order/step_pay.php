<?php $po_id = $param1; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('gm/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
    <input type="hidden" name="status" value="6">
    <input type="hidden" name="doc_type" value="payment_proof">
    
    <div class="form-group mb-2">
        <label><?php echo get_phrase('payment_method'); ?></label>
        <select name="payment_method" class="form-control">
            <option value="Bankly">Bankly</option>
            <option value="Sedad">Sedad</option>
            <option value="Virement">Virement Bank</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label><?php echo get_phrase('upload_payment_screenshot'); ?> *</label>
        <input type="file" name="po_document" class="form-control" accept="image/*" required>
    </div>

    <button class="btn btn-success w-100" type="submit"><?php echo get_phrase('confirm_payment'); ?></button>
</form>

<script>
$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false, processData: false,
        success: function(response) {
            success_notify('<?php echo get_phrase('payment_confirmed'); ?>');
            $('#right-modal').modal('hide');
            showAllPurchaseOrders();
        }
    });
});
</script>