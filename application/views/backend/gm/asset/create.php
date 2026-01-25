<form method="POST" class="d-block ajaxForm" action="<?php echo route('asset/create'); ?>">
    <div class="form-row">
        <!-- Code de l'équipement -->
        <div class="form-group mb-2">
            <label for="asset_code"><?php echo get_phrase('asset_code'); ?></label>
            <input type="text" class="form-control" id="asset_code" name="asset_code" placeholder="Ex: MC-NKC-001" required>
        </div>

        <!-- Nom de la machine -->
        <div class="form-group mb-2">
            <label for="name"><?php echo get_phrase('asset_name'); ?></label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Site (Nouakchott / Tasiast) -->
        <div class="form-group mb-2">
            <label for="site_id"><?php echo get_phrase('site'); ?></label>
            <select name="site_id" id="site_id" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_site'); ?></option>
                <option value="1">Nouakchott</option>
                <option value="2">Tasiast</option>
            </select>
        </div>

        <!-- Dates de calibrage -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="last_calibration"><?php echo get_phrase('last_calibration'); ?></label>
                    <input type="date" class="form-control" id="last_calibration" name="last_calibration" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="next_calibration"><?php echo get_phrase('next_calibration'); ?></label>
                    <input type="date" class="form-control" id="next_calibration" name="next_calibration" required>
                </div>
            </div>
        </div>

        <!-- Statut initial -->
        <div class="form-group mb-3">
            <label for="status"><?php echo get_phrase('status'); ?></label>
            <select name="status" id="status" class="form-control select2" data-toggle="select2">
                <option value="operational"><?php echo get_phrase('operational'); ?></option>
                <option value="maintenance"><?php echo get_phrase('under_maintenance'); ?></option>
                <option value="broken"><?php echo get_phrase('broken'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save_asset'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
    // Initialise Select2 pour la modal
    $('select.select2').each(function () { 
        $(this).select2({ dropdownParent: '#right-modal' }); 
    });
});

// Validation et soumission AJAX
$(".ajaxForm").validate({});
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllAssets); // showAllAssets doit être défini dans index.php
});
</script>