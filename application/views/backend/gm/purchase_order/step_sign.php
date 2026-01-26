<?php $po_id = $param1; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('gm/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
    <input type="hidden" name="status" value="4">
    <input type="hidden" name="doc_type" value="signed_po">
    
    <div class="alert alert-info">
        <?php echo get_phrase('instruction_sign_and_upload_the_po_document'); ?>
    </div>

    <div class="form-group mb-3">
        <label><?php echo get_phrase('upload_signed_po'); ?> (PDF/Image) *</label>
        <input type="file" name="po_document" class="form-control" accept=".pdf,image/*" required>
    </div>

    <button class="btn btn-warning w-100" type="submit"><?php echo get_phrase('confirm_signature_&_proceed'); ?></button>
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
            success_notify('<?php echo get_phrase('po_signed_successfully'); ?>');
            $('#right-modal').modal('hide');
            showAllPurchaseOrders();
        }
    });
});
</script>