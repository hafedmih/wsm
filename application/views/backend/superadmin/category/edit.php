<?php
$entity = 'donor';   // or category
$school_id = school_id();

$user = $this->db->get_where('categories', ['id' => $param1])->row_array();

/*
|--------------------------------------------------------------------------
| Fields allowed to edit
|--------------------------------------------------------------------------
*/
$fields = [
    'name',
    'name_ar'
];
?>

<form method="POST" class="ajaxForm" action="<?= route("category/update/$param1"); ?>">

<?php foreach ($fields as $field): ?>
    <div class="form-group mb-1">
        <label><?= get_phrase($field); ?></label>

        <?php if ($field === 'description'): ?>
            <textarea name="<?= $field ?>" class="form-control"><?= $user[$field] ?? '' ?></textarea>

        <?php else: ?>
            <input type="text"
                   name="<?= $field ?>"
                   value="<?= $user[$field] ?? '' ?>"
                   class="form-control"
                   required>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

    <button class="btn btn-primary w-100">
        <?= get_phrase('update_category'); ?>
    </button>
</form>

<script>
$(".ajaxForm").validate();
$(".ajaxForm").submit(function(e){
    ajaxSubmit(e, $(this), showAll);
});
</script>
