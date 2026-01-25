<form method="POST" class="d-block ajaxForm" action="<?php echo route('project/create'); ?>" enctype="multipart/form-data">
    <div class="form-group mb-2">
        <label><?php echo get_phrase('project_name'); ?></label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group mb-2">
        <label><?php echo get_phrase('quotation_amount'); ?> (MRU)</label>
        <input type="number" name="quotation_amount" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label><?php echo get_phrase('deadline'); ?></label>
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label><?php echo get_phrase('site'); ?></label>
            <select name="site_id" class="form-control select2" data-toggle="select2">
                <option value="1">Nouakchott</option>
                <option value="2">Tasiast</option>
            </select>
        </div>
    </div>
    <div class="form-group mb-3 mt-2">
        <label><?php echo get_phrase('contract_file'); ?> (PDF)</label>
        <input type="file" name="contract_file" class="form-control" accept=".pdf">
    </div>
    <button class="btn btn-primary w-100" type="submit"><?php echo get_phrase('create_project'); ?></button>
</form>

<script>
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllProjects);
});
</script>