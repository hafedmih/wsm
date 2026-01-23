<?php $project_id = $param1; ?>

<form method="POST" class="d-block ajaxForm" action="<?= route('project/document_create/'.$project_id); ?>" enctype="multipart/form-data">
    <div class="form-group mb-2">
        <label for="title"><?= get_phrase('document_title'); ?></label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="form-group mb-2">
        <label for="document_file"><?= get_phrase('select_file'); ?></label>
        <div class="custom-file-upload">
            <input type="file" class="form-control" id="document_file" name="document_file" required>
            <small class="text-muted"><?= get_phrase('allowed_types'); ?>: PDF, Excel, Word, Images</small>
        </div>
    </div>

    <div class="form-group mt-3">
        <button class="btn btn-primary w-100" type="submit"><?= get_phrase('upload_document'); ?></button>
    </div>
</form>

<script>
    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, function(){
            location.reload(); // Reload page to see the new file
        });
    });
</script>