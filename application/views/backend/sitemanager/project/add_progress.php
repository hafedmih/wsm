<?php $p_id = $param1; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('sitemanager/project/add_progress/'.$p_id); ?>">
    <div class="form-group mb-2">
        <label><?php echo get_phrase('progress_title'); ?> (Ex: Coulage dalle effectué)</label>
        <input type="text" name="title" class="form-control" placeholder="Entrez le motif ou le titre" required>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label><?php echo get_phrase('new_percentage'); ?> (%)</label>
                <input type="number" name="percentage" class="form-control" min="0" max="100" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label><?php echo get_phrase('date'); ?></label>
                <input type="date" name="date_reported" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <button class="btn btn-primary w-100" type="submit"><?php echo get_phrase('update_project_now'); ?></button>
    </div>
</form>

<script>
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllProjects); // Rafraîchit la liste derrière la modal
});
</script>