<?php $v_id = $param1; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('sitemanager/exit_voucher/approve/'.$v_id); ?>" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label><?php echo get_phrase('upload_signed_approval_document'); ?> (PDF/Image) *</label>
        <input type="file" name="approval_file" class="form-control" accept="image/*,application/pdf" required>
        <small class="text-muted"><?php echo get_phrase('mandatory_for_stock_deduction'); ?></small>
    </div>

    <button class="btn btn-success w-100" type="submit"><?php echo get_phrase('confirm_and_approve'); ?></button>
</form>

<script>
// Cette partie est CRUCIALE pour éviter la page blanche JSON
$(".ajaxForm").submit(function(e) {
    e.preventDefault(); // Empêche la redirection classique
    var form = $(this);
    
    // On utilise la fonction native d'Ekattor pour gérer l'upload et le JSON
    ajaxSubmit(e, form, showAllVouchers); 
});
</script>