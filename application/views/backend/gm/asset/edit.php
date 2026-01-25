<?php
    $asset_details = $this->db->get_where('assets', array('id' => $param1))->result_array();
    foreach($asset_details as $asset):
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('asset/update/'.$param1); ?>">
    <div class="form-row">
        <!-- Code (Lecture seule généralement) -->
        <div class="form-group mb-2">
            <label for="asset_code"><?php echo get_phrase('asset_code'); ?></label>
            <input type="text" value="<?php echo $asset['asset_code']; ?>" class="form-control" disabled>
        </div>

        <!-- Nom de la machine -->
        <div class="form-group mb-2">
            <label for="name"><?php echo get_phrase('asset_name'); ?></label>
            <input type="text" value="<?php echo $asset['name']; ?>" class="form-control" id="name" name="name" required>
        </div>

        <!-- Site -->
        <div class="form-group mb-2">
            <label for="site_id"><?php echo get_phrase('site'); ?></label>
            <select name="site_id" id="site_id" class="form-control select2" data-toggle="select2" required>
                <option value="1" <?php if($asset['site_id'] == 1) echo 'selected'; ?>>Nouakchott</option>
                <option value="2" <?php if($asset['site_id'] == 2) echo 'selected'; ?>>Tasiast</option>
            </select>
        </div>

        <!-- Dates de calibrage -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="last_calibration"><?php echo get_phrase('last_calibration'); ?></label>
                    <input type="date" value="<?php echo $asset['last_calibration']; ?>" class="form-control" name="last_calibration" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="next_calibration"><?php echo get_phrase('next_calibration'); ?></label>
                    <input type="date" value="<?php echo $asset['next_calibration']; ?>" class="form-control" name="next_calibration" required>
                </div>
            </div>
        </div>

        <!-- Statut -->
        <div class="form-group mb-3">
            <label for="status"><?php echo get_phrase('status'); ?></label>
            <select name="status" id="status" class="form-control select2" data-toggle="select2">
                <option value="operational" <?php if($asset['status'] == 'operational') echo 'selected'; ?>><?php echo get_phrase('operational'); ?></option>
                <option value="maintenance" <?php if($asset['status'] == 'maintenance') echo 'selected'; ?>><?php echo get_phrase('under_maintenance'); ?></option>
                <option value="broken" <?php if($asset['status'] == 'broken') echo 'selected'; ?>><?php echo get_phrase('broken'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_asset'); ?></button>
        </div>
    </div>
</form>
<?php endforeach; ?>

<script>
$(document).ready(function () {
    $('select.select2').each(function () { 
        $(this).select2({ dropdownParent: '#right-modal' }); 
    });
});

$(".ajaxForm").validate({});
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllAssets);
});
</script>
<?php ?>