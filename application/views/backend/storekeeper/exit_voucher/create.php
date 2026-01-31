<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('storekeeper/exit_voucher/create'); ?>">
    <div class="row">
        <div class="col-md-6 mb-2">
            <label>Project *</label>
            <select name="project_id" class="form-control select2" data-toggle="select2" required>
                <option value="">Select Project</option>
                <?php $projects = $this->db->get_where('projects', ['status'=>'open'])->result_array(); foreach($projects as $p): ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-2">
            <label>Asset / Machine (Optional)</label>
            <select name="asset_id" class="form-control select2" data-toggle="select2">
                <option value="">General Use</option>
                <?php $assets = $this->db->get('assets')->result_array(); foreach($assets as $a): ?>
                    <option value="<?php echo $a['id']; ?>"><?php echo $a['asset_code']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group mb-2">
        <label>Motive *</label>
        <textarea name="motive" class="form-control" rows="2" required placeholder="Describe why these items are needed..."></textarea>
    </div>

    <hr>
    <h5>Items List</h5>
    <div id="item_list">
        <div class="row item_row mb-1">
            <div class="col-md-7">
                <select name="inventory_id[]" class="form-control" required>
                    <option value="">Select Product</option>
                    <?php $items = $this->db->get('inventory')->result_array(); foreach($items as $i): ?>
                        <option value="<?php echo $i['id']; ?>"><?php echo $i['name']; ?> (<?php echo $i['sku']; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="quantity[]" class="form-control" placeholder="Qty" step="0.01" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success" onclick="appendItem()">+</button>
            </div>
        </div>
    </div>

   

    <button class="btn btn-primary w-100" type="submit">Generate Exit Voucher</button>
</form>

<script>
function appendItem() {
    var html = $('.item_row:first').clone();
    html.find('input').val('');
    html.find('button').removeClass('btn-success').addClass('btn-danger').text('-').attr('onclick', '$(this).parent().parent().remove()');
    $('#item_list').append(html);
}

$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var data = JSON.parse(response);
            if(data.status) {
                success_notify(data.notification);
                $('#right-modal').modal('hide');
                showAllVouchers(); 
            } else {
                error_notify(data.notification);
            }
        }
    });
});
</script>