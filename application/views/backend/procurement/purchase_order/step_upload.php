<?php 
    $po_id = $param1; 
    $next_status = $param2; 
    $user_id = $this->session->userdata('user_id');
    $user_role = $this->session->userdata('user_type');

    // Récupération sécurisée des données de l'utilisateur actuel
    $user_data = $this->db->get_where('users', array('id' => $user_id))->row_array();
    
    // Titres dynamiques selon l'étape
    $titles = [
        2 => ['label' => 'Site Manager Approval', 'type' => 'site_signed_doc'],
        3 => ['label' => 'Procurement Verification Scan', 'type' => 'procurement_signed_doc'],
        4 => ['label' => 'GM Final Signature', 'type' => 'gm_signed_doc'],
        5 => ['label' => 'Supplier Invoice Upload', 'type' => 'invoice_doc'],
        6 => ['label' => 'Payment Proof (Bankly/Sedad)', 'type' => 'payment_doc']
    ];
    
    $config = isset($titles[$next_status]) ? $titles[$next_status] : ['label' => 'Upload Document', 'type' => 'other'];
?>

<!-- On affiche les détails du PO en haut pour que l'utilisateur vérifie avant de signer -->
<?php include 'details.php'; ?>

<div class="card mt-3 border-primary border">
    <div class="card-body">
        <form method="POST" class="d-block ajaxForm" action="<?php echo site_url($user_role.'/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
            <input type="hidden" name="status" value="<?php echo $next_status; ?>">
            <input type="hidden" name="doc_type" value="<?php echo $config['type']; ?>">

            <h5 class="text-primary mb-3">
                <i class="mdi mdi-pen"></i> <?php echo get_phrase($config['label']); ?>
            </h5>
            
            <!-- LOGIQUE DE SIGNATURE NUMÉRIQUE (Étapes 2, 3 et 4) -->
            <?php if(in_array($next_status, [2, 3, 4])): ?>
                <div class="alert alert-light border mb-3 text-center bg-white">
                    <p class="mb-2 text-muted"><strong><?php echo get_phrase('your_digital_signature'); ?></strong></p>
                    
                    <?php if(!empty($user_data['signature']) && file_exists('uploads/signatures/'.$user_data['signature'])): ?>
                        <div class="p-2 d-inline-block border mb-2 shadow-sm">
                            <img src="<?php echo base_url('uploads/signatures/'.$user_data['signature']); ?>" style="max-height: 100px; width: 100px;">
                        </div>
                        <p class="text-success small mb-0">
                            <i class="mdi mdi-check-decagram"></i> 
                            <strong><?php echo $user_data['name']; ?></strong><br>
                            <?php echo get_phrase('this_signature_will_be_added_to_the_pdf_document'); ?>
                        </p>
                    <?php else: ?>
                        <div class="text-danger p-2">
                            <i class="mdi mdi-alert-octagon"></i> <?php echo get_phrase('no_signature_found_in_your_profile'); ?>.<br>
                            <a href="<?php echo site_url('profile'); ?>" class="btn btn-sm btn-link text-primary fw-bold">
                                <?php echo get_phrase('click_here_to_draw_your_signature'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Document additionnel (optionnel pour signature numérique) -->
<!--                <div class="form-group mb-3">
                    <label><?php echo get_phrase('attach_extra_scan_/_document_optional'); ?></label>
                    <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf">
                </div>-->

            <?php else: ?>
                <!-- ÉTAPES 5 & 6 : DOCUMENTS OBLIGATOIRES (FACTURE / PAIEMENT) -->
                <div class="form-group mb-3">
                    <label><?php echo get_phrase('upload_required_document'); ?> *</label>
                    <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf" required>
                </div>
            <?php endif; ?>

            <!-- Bouton de validation -->
            <button class="btn btn-primary w-100" type="submit" 
                <?php echo (in_array($next_status, [2,3,4]) && empty($user_data['signature'])) ? 'disabled' : ''; ?>>
                <i class="mdi mdi-check-circle"></i> <?php echo get_phrase('confirm_&_sign_po'); ?>
            </button>
        </form>
    </div>
</div>

<script>
// Soumission AJAX Ekattor
$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        contentType: false, 
        processData: false,
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