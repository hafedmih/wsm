<?php
// ------------------------------------------------------------------------
// CONFIGURATION
// ------------------------------------------------------------------------
$entity = 'project'; 
$table  = 'projects'; 

// 1. Define ALL fields (Synced with Create form)
$fields_to_update = [
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

// 2. Fetch the existing data for this project
$row_data = $this->db->get_where($table, ['id' => $param1])->row_array();

// 3. Fetch dropdown data
$categories = $this->db->get_where('categories', ['status' => 1])->result_array();
$currencies = $this->db->get_where('currencies', ['paypal_supported' => '1'])->result_array();
// ------------------------------------------------------------------------
?>

<form method="POST" class="d-block ajaxForm" action="<?= route("$entity/update/$param1"); ?>">

    <?php foreach ($fields_to_update as $field): 
        // Get existing value
        $value = isset($row_data[$field]) ? $row_data[$field] : '';
        
        // Determine Input Type Logic
        $input_type = 'text';
        if(strpos($field, 'date') !== false) $input_type = 'date';
        if(strpos($field, 'budget') !== false) $input_type = 'number';
        
        // RTL Logic for Arabic fields
        $is_rtl_field = (strpos($field, '_ar') !== false) ? 'dir="rtl"' : '';
    ?>

    <div class="form-group mb-1">
        <label for="<?= $field ?>"><?= get_phrase($field); ?></label>

        <!-- SCENARIO 1: Category Dropdown (Pre-selected) -->
        <?php if($field == 'category_id'): ?>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value=""><?= get_phrase('select_category'); ?></option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id']; ?>" <?= ($value == $cat['id']) ? 'selected' : ''; ?>>
                        <?= $cat['name']; ?> 
                        <?php if(!empty($cat['name_ar'])) echo ' - ' . $cat['name_ar']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

        <!-- SCENARIO 2: Currency Dropdown (Pre-selected) -->
        <?php elseif($field == 'currency'): ?>
            <select name="currency" id="currency" class="form-control" required>
                <?php foreach($currencies as $curr): ?>
                    <option value="<?= $curr['code']; ?>" <?= ($value == $curr['code']) ? 'selected' : ''; ?>>
                        <?= $curr['code']; ?> - <?= $curr['name']; ?> (<?= $curr['symbol']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

        <!-- SCENARIO 3: Textareas (RTL support) -->
        <?php elseif ($field == 'description' || $field == 'description_ar'): ?>
            <textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="4" <?= $is_rtl_field ?>><?= $value ?></textarea>

        <!-- SCENARIO 4: Standard Inputs (Date, Number, Text) -->
        <?php else: ?>
            <input type="<?= $input_type; ?>" 
                   class="form-control" 
                   id="<?= $field ?>" 
                   name="<?= $field ?>" 
                   value="<?= $value ?>" 
                   <?= $is_rtl_field ?> 
                   <?= ($field == 'budget') ? 'step="0.01"' : ''; ?> >
        <?php endif; ?>
        
    </div>

    <?php endforeach; ?>

    <div class="form-group mt-3">
        <button class="btn btn-primary w-100"><?= get_phrase("update_$entity"); ?></button>
    </div>

</form>

<script>
$(document).ready(function () {
    $(".ajaxForm").validate(); 
    $(".ajaxForm").submit(function(e){
        var form = $(this);
        // Using showAllData to match your Create form's success callback
        ajaxSubmit(e, form, showAllData); 
    });
});
</script>