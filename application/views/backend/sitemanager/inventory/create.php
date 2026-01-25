<form method="POST" class="d-block ajaxForm" action="<?php echo route('inventory/create'); ?>">
    <div class="form-group mb-2">
        <label><?php echo get_phrase('sku_code'); ?></label>
        <input type="text" name="sku" class="form-control" placeholder="Ex: OIL-5W40-01" required>
    </div>
    <div class="form-group mb-2">
        <label><?php echo get_phrase('product_name'); ?></label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label><?php echo get_phrase('unit'); ?></label>
            <input type="text" name="unit" class="form-control" placeholder="Litre, Pc..." required>
        </div>
        <div class="col-md-6">
            <label><?php echo get_phrase('category'); ?></label>
            <select name="category_id" class="form-control select2" data-toggle="select2">
                <?php $cats = $this->db->get('categories')->result_array(); 
                      foreach($cats as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="btn btn-primary w-100 mt-3" type="submit"><?php echo get_phrase('add_product'); ?></button>
</form>

<script>
$(".ajaxForm").submit(function(e) {
    ajaxSubmit(e, $(this), showAllInventory);
});
</script>