<?php
$entity = 'institution'; // Changed from category
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
                
                // RTL Logic for Arabic Name
                $dir = ($field == 'name_ar') ? 'dir="rtl"' : 'dir="ltr"';
                
                // Placeholder suggestions
                $placeholder = '';
                if ($field == 'website') $placeholder = 'https://...';
            ?>

            <input type="<?= $type; ?>"
                   name="<?= $field; ?>" 
                   id="<?= $field; ?>"
                   class="form-control" 
                   <?= $dir; ?>
                   placeholder="<?= $placeholder; ?>"
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
        // Using showAll as requested in your snippet
        ajaxSubmit(e, form, showAll); 
    });
});
</script>