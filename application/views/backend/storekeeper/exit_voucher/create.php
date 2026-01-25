<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('storekeeper/exit_voucher/create'); ?>" enctype="multipart/form-data">
    
    <!-- Section 1 : Informations Générales -->
    <div class="row">
        <!-- Sélection du Projet (Obligatoire) -->
        <div class="col-md-6 form-group mb-2">
            <label><?php echo get_phrase('project'); ?> *</label>
            <select name="project_id" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_project'); ?></option>
                <?php 
                $projects = $this->db->get_where('projects', array('status' => 'open'))->result_array(); 
                foreach($projects as $p): ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Sélection de l'Asset / Machine (Optionnel) -->
        <div class="col-md-6 form-group mb-2">
            <label><?php echo get_phrase('asset_/_machine'); ?></label>
            <select name="asset_id" class="form-control select2" data-toggle="select2">
                <option value=""><?php echo get_phrase('none_/_general_use'); ?></option>
                <?php 
                $assets = $this->db->get('assets')->result_array(); 
                foreach($assets as $a): ?>
                    <option value="<?php echo $a['id']; ?>"><?php echo $a['asset_code']; ?> - <?php echo $a['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Motif de sortie -->
    <div class="form-group mb-2">
        <label><?php echo get_phrase('motive_of_exit'); ?> *</label>
        <textarea name="motive" class="form-control" rows="2" placeholder="Ex: Maintenance préventive ou Consommation chantier..." required></textarea>
    </div>

    <hr>
    <h5><?php echo get_phrase('products_to_exit'); ?></h5>

    <!-- Section 2 : Multi-Articles Dynamiques -->
    <div id="item_list">
        <div class="row item_row mb-2">
            <div class="col-md-7">
                <select name="inventory_id[]" class="form-control" required>
                    <option value=""><?php echo get_phrase('select_product'); ?></option>
                    <?php 
                    $items = $this->db->get('inventory')->result_array(); 
                    foreach($items as $i): ?>
                        <option value="<?php echo $i['id']; ?>"><?php echo $i['name']; ?> (<?php echo $i['sku']; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="quantity[]" class="form-control" placeholder="Qty" min="0.01" step="0.01" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-sm mt-1" onclick="appendItem()"> <i class="mdi mdi-plus"></i> </button>
            </div>
        </div>
    </div>

    <!-- Section 3 : Justificatif -->
    <div class="form-group mb-3 mt-3">
        <label><?php echo get_phrase('attach_request_document'); ?> (Image/PDF)</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="request_file" class="form-control" accept="image/*,application/pdf">
            </div>
        </div>
        <small class="text-muted"><?php echo get_phrase('upload_invoice_or_signed_request'); ?></small>
    </div>

    <button class="btn btn-primary w-100" type="submit"><?php echo get_phrase('create_voucher'); ?></button>
</form>

<script>
// Initialisation de Select2 pour les champs initiaux
$(document).ready(function() {
    $('select.select2').select2({
        dropdownParent: $('#right-modal')
    });
});

function appendItem() {
    var html = $('.item_row:first').clone();
    html.find('input').val('');
    // On ne clone pas le select2 car il bug en clone, on utilise un select normal
    html.find('button').removeClass('btn-success').addClass('btn-danger').html('<i class="mdi mdi-minus"></i>').attr('onclick', '$(this).parent().parent().remove()');
    $('#item_list').append(html);
}

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
                // 1. Notification de succès
                success_notify(data.notification);
                
                // 2. Fermer la modal proprement
                $('#right-modal').modal('hide');
                
                // 3. Rafraîchir la liste automatiquement
                showAllVouchers(); 
            } else {
                error_notify(data.notification);
            }
        }
    });
});
        
</script>