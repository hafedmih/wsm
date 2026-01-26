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
    <h5><?php echo get_phrase('order_items'); ?></h5>
    <div id="item_list">
        <div class="row item_row mb-2">
            <div class="col-md-8">
                <select name="inventory_id[]" class="form-control" required>
                    <option value=""><?php echo get_phrase('select_product'); ?></option>
                    <?php $items = $this->db->get('inventory')->result_array(); 
                          foreach($items as $i): ?>
                        <option value="<?php echo $i['id']; ?>"><?php echo $i['name']; ?> (<?php echo $i['sku']; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="quantity[]" class="form-control" placeholder="Qty" min="1" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-success btn-sm" onclick="appendItem()">+</button>
            </div>
        </div>
    </div>

    <button class="btn btn-primary w-100 mt-3" type="submit"><?php echo get_phrase('submit_purchase_order'); ?></button>
</form>

<script>
$(document).ready(function() { $('select.select2').select2({ dropdownParent: '#right-modal' }); });

function appendItem() {
    var html = $('.item_row:first').clone();
    html.find('input').val('');
    html.find('button').removeClass('btn-success').addClass('btn-danger').text('-').attr('onclick', '$(this).parent().parent().remove()');
    $('#item_list').append(html);
}

$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    ajaxSubmit(e, $(this), showAllPurchaseOrders);
});
</script>