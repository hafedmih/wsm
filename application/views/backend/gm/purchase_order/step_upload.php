<?php 
    $po_id = $param1; 
    $next_status = $param2; 
    $user_id = $this->session->userdata('user_id');
    $user_role = $this->session->userdata('user_type');

    // Récupération des données du profil du GM (pour la signature)
    $user_data = $this->db->get_where('users', array('id' => $user_id))->row_array();
    
    // Configuration des titres et types de docs
    $titles = [
        2 => ['label' => 'Site Manager Approval', 'type' => 'site_signed_doc'],
        3 => ['label' => 'Procurement Verification Scan', 'type' => 'procurement_signed_doc'],
        4 => ['label' => 'GM Final Signature', 'type' => 'gm_signed_doc'],
        5 => ['label' => 'Supplier Invoice Upload', 'type' => 'invoice_doc'],
        6 => ['label' => 'Payment Proof (Bankly/Sedad/Bank)', 'type' => 'payment_doc']
    ];
    $config = $titles[$next_status];
?>

<!-- Affichage des détails complets du PO pour révision avant signature -->
<?php include 'details.php'; ?>

<div class="card mt-3 border-primary border shadow-sm">
    <div class="card-body">
        <form method="POST" class="d-block ajaxForm" action="<?php echo site_url($user_role.'/purchase_order/update_status/'.$po_id); ?>" enctype="multipart/form-data">
            <input type="hidden" name="status" value="<?php echo $next_status; ?>">
            <input type="hidden" name="doc_type" value="<?php echo $config['type']; ?>">

            <h5 class="text-primary mb-3">
                <i class="mdi mdi-ray-start-arrow"></i> <?php echo get_phrase('step'); ?> <?php echo $next_status; ?> : <?php echo get_phrase($config['label']); ?>
            </h5>

            <!-- CAS ÉTAPE 4 : SIGNATURE NUMÉRIQUE DU GM -->
            <?php if($next_status == 4): ?>
                <div class="alert alert-light border mb-3 text-center bg-white">
                    <p class="mb-2 text-muted"><strong><?php echo get_phrase('your_gm_digital_signature'); ?></strong></p>
                    
                    <?php if(!empty($user_data['signature']) && file_exists('uploads/signatures/'.$user_data['signature'])): ?>
                        <div class="p-2 d-inline-block border mb-2 shadow-sm bg-white">
                            <img src="<?php echo base_url('uploads/signatures/'.$user_data['signature']); ?>" style="max-height: 120px; width: 120px;">
                        </div>
                        <p class="text-success small mb-0 fw-bold">
                            <i class="mdi mdi-check-decagram"></i> <?php echo $user_data['name']; ?><br>
                            <?php echo get_phrase('confirm_to_append_this_signature_to_the_final_po'); ?>
                        </p>
                    <?php else: ?>
                        <div class="text-danger p-3">
                            <i class="mdi mdi-alert-octagon" style="font-size: 24px;"></i><br>
                            <?php echo get_phrase('no_signature_found_in_your_profile'); ?>.<br>
                            <a href="<?php echo site_url('profile'); ?>" class="btn btn-sm btn-link text-primary fw-bold">
                                <?php echo get_phrase('setup_your_signature_now'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
<!--                <div class="form-group mb-3">
                    <label><?php echo get_phrase('additional_scan_optional'); ?></label>
                    <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf">
                </div>-->

            <!-- CAS ÉTAPE 6 : PAIEMENT (MÉTHODE + IMAGE) -->
            <?php elseif($next_status == 6):
                $po = $this->db->get_where('purchase_orders', ['id' => $po_id])->row_array();
                $allowed_methods = explode(',', $po['suggested_payment_methods']);
            ?>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label><?php echo get_phrase('select_actual_payment_method'); ?> *</label>
                        <select name="payment_method_name" class="form-control select2" data-toggle="select2" required>
                            <option value=""><?php echo get_phrase('choose_method'); ?></option>
                            <?php foreach($allowed_methods as $method_name): ?>
                                <?php if(!empty($method_name)): ?>
                                    <option value="<?php echo trim($method_name); ?>"><?php echo trim($method_name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label><?php echo get_phrase('upload_payment_screenshot_/_receipt'); ?> *</label>
                        <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf" required>
                    </div>
                </div>

            <!-- AUTRES ÉTAPES (5 - Facture Agent d'achat) -->
            <?php else: ?>
                <div class="form-group mb-3">
                    <label><?php echo get_phrase($config['label']); ?> *</label>
                    <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf" required>
                </div>
            <?php endif; ?>

            <hr>

            <!-- BOUTON DE VALIDATION DYNAMIQUE -->
            <button class="btn btn-primary btn-lg w-100" type="submit" 
                <?php echo ($next_status == 4 && empty($user_data['signature'])) ? 'disabled' : ''; ?>>
                <?php if($next_status == 4): ?>
                    <i class="mdi mdi-pen"></i> <?php echo get_phrase('apply_digital_signature_&_approve'); ?>
                <?php elseif($next_status == 6): ?>
                    <i class="mdi mdi-cash-check"></i> <?php echo get_phrase('confirm_payment_&_notify_accounting'); ?>
                <?php else: ?>
                    <i class="mdi mdi-check"></i> <?php echo get_phrase('confirm_and_proceed'); ?>
                <?php endif; ?>
            </button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialisation de Select2 pour le menu des banques
    if (jQuery().select2) {
        $('select.select2').select2({
            dropdownParent: $('#right-modal')
        });
    }
});

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