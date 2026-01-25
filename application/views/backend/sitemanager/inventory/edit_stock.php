<?php
    // $param1 = inventory_id, $param2 = site_id
    $inventory_id = $param1;
    $site_id      = $param2;

    // Récupérer les détails du produit et son stock actuel sur ce site
    $this->db->select('inventory.name, inventory.sku, stocks.quantity, sites.name as site_name');
    $this->db->from('inventory');
    $this->db->join('stocks', 'stocks.inventory_id = inventory.id');
    $this->db->join('sites', 'sites.id = stocks.site_id');
    $this->db->where('inventory.id', $inventory_id);
    $this->db->where('stocks.site_id', $site_id);
    $inventory_details = $this->db->get()->row_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('inventory/update_stock/'.$inventory_id); ?>">
    <!-- Champ caché pour le site_id -->
    <input type="hidden" name="site_id" value="<?php echo $site_id; ?>">

    <div class="form-row">
        <!-- Informations produit (Lecture seule) -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('product'); ?></label>
            <input type="text" class="form-control" value="<?php echo $inventory_details['name']; ?> (<?php echo $inventory_details['sku']; ?>)" disabled>
        </div>

        <div class="form-group mb-2">
            <label><?php echo get_phrase('depot_site'); ?></label>
            <input type="text" class="form-control" value="<?php echo $inventory_details['site_name']; ?>" disabled>
        </div>

        <hr>

        <!-- Ajustement de la quantité -->
        <div class="form-group mb-3">
            <label for="quantity"><?php echo get_phrase('current_stock_quantity'); ?></label>
            <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="<?php echo $inventory_details['quantity']; ?>" required>
            <small class="text-muted"><?php echo get_phrase('update_the_value_after_physical_inventory'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_stock_level'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
    // Initialisation si nécessaire
});

// Soumission AJAX conforme à Ekattor
$(".ajaxForm").validate({});
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllInventory); 
});
</script>