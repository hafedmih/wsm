<?php
$entity = 'ministry'; // Changed from institution
$school_id = school_id();
?>

<form method="POST" class="ajaxForm" action="<?= route("$entity/create"); ?>">
    <?php
    $fields = [
        'name',
        'name_ar',
        'abbr',
        'abbr_ar',
        'email',
        'website'
    ];
    ?>

    <?php foreach ($fields as $field): ?>
        <div class="form-group mb-2">
            <label for="<?= $field; ?>"><?= get_phrase($field); ?></label>

            <?php 
                // Determine Input Type
                $type = 'text';
                if ($field == 'email') $type = 'email';
                if ($field == 'website') $type = 'text';
                
                // RTL Logic: Apply to name_ar AND abbr_ar
                $dir = (strpos($field, '_ar') !== false) ? 'dir="rtl"' : 'dir="ltr"';
                
                // Placeholder suggestions
                $placeholder = '';
                if ($field == 'website') $placeholder = 'https://...';
                if ($field == 'abbr') $placeholder = 'e.g. MEN';
                if ($field == 'abbr_ar') $placeholder = 'مثال: وزارة التعليم';
            ?>

            <input type="<?= $type; ?>"
                   name="<?= $field; ?>" 
                   id="<?= $field; ?>"
                   class="form-control" 
                   <?= $dir; ?>
                   placeholder="<?= $placeholder; ?>"
                   <?php if($field == 'name' || $field == 'name_ar') echo 'required'; ?>
                   >
        </div>
    <?php endforeach; ?>

    <div class="mt-3">
        <button class="btn btn-primary w-100"><?= get_phrase("create_$entity"); ?></button>
    </div>
</form>

<script>
$(document).ready(function () {
    $(".ajaxForm").validate();
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        // showAll refers to the refresh function in your ministry/index.php
        ajaxSubmit(e, form, showAll); 
    });
});
</script>