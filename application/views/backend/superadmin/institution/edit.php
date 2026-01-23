<?php
$entity = 'institution'; 
$table  = 'donors'; // Fetching from donors table
$school_id = school_id();

// Fetch the existing institution data
$row_data = $this->db->get_where($table, ['id' => $param1])->row_array();

/*
|--------------------------------------------------------------------------
| Fields allowed to edit
|--------------------------------------------------------------------------
*/
$fields = [
    'name',
    'name_ar',
    'abbr',
        'abbr_ar',
    'email',
    'website'
];
?>

<form method="POST" class="ajaxForm" action="<?= route("$entity/update/$param1"); ?>">

<?php foreach ($fields as $field): 
    $value = $row_data[$field] ?? '';
    
    // Determine Input Type
    $type = 'text';
    if ($field == 'email') $type = 'email';
    if ($field == 'website') $type = 'text';
    
    // RTL Logic for Arabic Name
    $dir = ($field == 'name_ar') ? 'dir="rtl"' : 'dir="ltr"';
?>
    <div class="form-group mb-2">
        <label for="<?= $field; ?>"><?= get_phrase($field); ?></label>

        <input type="<?= $type; ?>"
               name="<?= $field; ?>"
               id="<?= $field; ?>"
               value="<?= $value ?>"
               class="form-control"
               <?= $dir; ?>
               >
    </div>
<?php endforeach; ?>

    <div class="mt-3">
        <button class="btn btn-primary w-100">
            <?= get_phrase("update_$entity"); ?>
        </button>
    </div>
</form>

<script>
$(document).ready(function () {
    $(".ajaxForm").validate();
    $(".ajaxForm").submit(function(e){
        var form = $(this);
        // Ensure showAll matches the refresh function on your list page
        ajaxSubmit(e, form, showAll);
    });
});
</script>