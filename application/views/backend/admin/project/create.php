<?php
// ------------------------------------------------------------------------
// CONFIGURATION
// ------------------------------------------------------------------------
$entity = 'project'; 
$table  = 'projects';

// 1. Get Current Language & Direction
$current_lang = get_settings('language');
$direction    = ($current_lang == 'arabic') ? 'rtl' : 'ltr';

// 2. Define fields (Added 'currency' here)
$fields = [
    'code',
    'title',
    'title_ar',
    'category_id',
    'budget',
    'start_date',
    'end_date',
    'description',
    'description_ar'
];

// 3. Fetch Categories
$categories = $this->db->get_where('categories', ['status' => 1])->result_array();

// 4. Fetch Currencies (New)
$currencies = $this->db->get_where('currencies',['paypal_supported'=>'1'])->result_array();
//print($this->db->last_query());
// ------------------------------------------------------------------------
?>

<form method="POST" class="d-block ajaxForm" action="<?= route("$entity/create"); ?>">

    <?php foreach ($fields as $field): 
        
        // Determine Input Type
        $input_type = 'text';
        if(strpos($field, 'date') !== false) $input_type = 'date';
        if(strpos($field, 'budget') !== false) $input_type = 'number';
        
        // RTL Logic for text inputs
        $is_rtl_field = (strpos($field, '_ar') !== false) ? 'dir="rtl"' : '';
    ?>

    <div class="form-group mb-1">
        <label for="<?= $field ?>"><?= get_phrase($field); ?></label>

        <!-- SCENARIO 1: Category Dropdown -->
        <?php if($field == 'category_id'): ?>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value=""><?= get_phrase('select_category'); ?></option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id']; ?>">
                        <?= $cat['name']; ?> 
                        <?php if(!empty($cat['name_ar'])) echo ' - ' . $cat['name_ar']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

        <!-- NEW SCENARIO: Currency Dropdown -->
        <?php elseif($field == 'currency'): ?>
            <select name="currency" id="currency" class="form-control" required>
                <?php foreach($currencies as $curr): ?>
                    <option value="<?= $curr['code']; ?>" <?= ($curr['code'] == 'MRU') ? 'selected' : ''; ?>>
                        <?= $curr['code']; ?> - <?= $curr['name']; ?> (<?= $curr['symbol']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

        <!-- SCENARIO 2: Textarea -->
        <?php elseif ($field == 'description' || $field == 'description_ar'): ?>
            <textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="4" <?= $is_rtl_field ?>></textarea>

        <!-- SCENARIO 3: Standard Inputs -->
        <?php else: ?>
            <input type="<?= $input_type; ?>" class="form-control" id="<?= $field ?>" name="<?= $field ?>" <?= $is_rtl_field ?> <?= ($field == 'budget') ? 'step="0.01"' : ''; ?> >
        <?php endif; ?>
        
    </div>

    <?php endforeach; ?>

    <div class="form-group mt-3">
        <button class="btn btn-primary w-100"><?= get_phrase("create_$entity"); ?></button>
    </div>
</form>

<script>
$(document).ready(function () {
    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e){
        var form = $(this);
        ajaxSubmit(e, form, showAllData);
    });
});
</script>