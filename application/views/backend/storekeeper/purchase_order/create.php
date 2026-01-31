<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('storekeeper/purchase_order/create'); ?>">
    <div class="row">
        <div class="col-md-12 form-group mb-2">
            <label><?php echo get_phrase('project'); ?> *</label>
            <select name="project_id" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_project'); ?></option>
                <?php $projects = $this->db->get_where('projects', ['status' => 'open'])->result_array(); 
                      foreach($projects as $p): ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <hr>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5><?php echo get_phrase('order_items'); ?></h5>
        <button type="button" class="btn btn-outline-success btn-sm" onclick="appendItem()">
            <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_item'); ?>
        </button>
    </div>

    <div id="item_list">
        <!-- Ligne d'article -->
        <div class="row item_row mb-3 border-bottom pb-3">
            <!-- COLONNE PRODUIT (Largeur augmentée pour le texte) -->
            <div class="col-7 pr-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="small fw-bold label-mode mb-0"><?php echo get_phrase('product'); ?></label>
                    <a href="javascript:void(0);" class="small text-primary fw-bold" onclick="toggleMode(this)" style="font-size: 10px;">
                        <i class="mdi mdi-swap-horizontal"></i> <?php echo get_phrase('manual_name'); ?>
                    </a>
                </div>

                <!-- Mode Inventaire -->
                <div class="inventory-mode">
                    <select name="inventory_id[]" class="form-control select2-inventory" required>
                        <option value=""><?php echo get_phrase('select_item'); ?></option>
                        <?php $items = $this->db->get('inventory')->result_array(); 
                              foreach($items as $i): ?>
                            <option value="<?php echo $i['id']; ?>"><?php echo $i['name']; ?> (<?php echo $i['sku']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Mode Manuel (Caché) -->
                <div class="custom-mode d-none">
                    <input type="text" name="custom_item_name[]" class="form-control" placeholder="<?php echo get_phrase('item_name'); ?>">
                </div>
            </div>

            <!-- COLONNE QUANTITÉ (Largeur fixée pour visibilité) -->
            <div class="col-4 px-1">
                <label class="small fw-bold mb-1"><?php echo get_phrase('qty'); ?></label>
                <input type="number" name="quantity[]" class="form-control" placeholder="0" min="1" required style="width: 100%;">
            </div>

            <!-- COLONNE SUPPRIMER -->
            <div class="col-1 pl-0 text-center">
                <label class="small d-block mb-1">&nbsp;</label>
                <button type="button" class="btn btn-outline-danger btn-sm border-0 p-0" onclick="removeItem(this)" style="margin-top: 5px;">
                    <i class="mdi mdi-close-circle font-18"></i>
                </button>
            </div>
        </div>
    </div>

    <button class="btn btn-primary btn-lg w-100 mt-3 shadow" type="submit">
        <i class="mdi mdi-check-circle"></i> <?php echo get_phrase('submit_purchase_order'); ?>
    </button>
</form>

<script>
$(document).ready(function() { 
    initSelect2();
});

function initSelect2() {
    $('.select2-inventory').select2({ 
        dropdownParent: $('#right-modal'),
        width: '100%'
    });
}

function toggleMode(btn) {
    var row = $(btn).closest('.item_row');
    var invMode = row.find('.inventory-mode');
    var cusMode = row.find('.custom-mode');
    var label = row.find('.label-mode');

    if (invMode.hasClass('d-none')) {
        invMode.removeClass('d-none');
        cusMode.addClass('d-none').find('input').val('');
        invMode.find('select').attr('required', 'required');
        label.text("<?php echo get_phrase('product'); ?>");
        $(btn).html('<i class="mdi mdi-swap-horizontal"></i> <?php echo get_phrase('manual_name'); ?>');
    } else {
        invMode.addClass('d-none').find('select').val('').trigger('change');
        invMode.find('select').removeAttr('required');
        cusMode.removeClass('d-none').find('input').attr('required', 'required');
        label.text("<?php echo get_phrase('custom_item'); ?>");
        $(btn).html('<i class="mdi mdi-swap-horizontal"></i> <?php echo get_phrase('from_inventory'); ?>');
    }
}

function appendItem() {
    var $firstRow = $('.item_row:first');
    var $newRow = $firstRow.clone();
    
    // Reset valeurs
    $newRow.find('input').val('').removeAttr('required');
    $newRow.find('select').val('').trigger('change').attr('required', 'required');
    
    // Reset affichage vers mode inventaire
    $newRow.find('.inventory-mode').removeClass('d-none');
    $newRow.find('.custom-mode').addClass('d-none');
    $newRow.find('.label-mode').text("<?php echo get_phrase('product'); ?>");
    $newRow.find('a').html('<i class="mdi mdi-swap-horizontal"></i> <?php echo get_phrase('manual_name'); ?>');

    $newRow.find('.select2-container').remove();
    $('#item_list').append($newRow);
    initSelect2();
}

function removeItem(btn) {
    if ($('.item_row').length > 1) {
        $(btn).closest('.item_row').remove();
    } else {
        error_notify("<?php echo get_phrase('at_least_one_item_required'); ?>");
    }
}

$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    ajaxSubmit(e, $(this), showAllPurchaseOrders);
});
</script>