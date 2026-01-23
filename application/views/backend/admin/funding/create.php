<?php
// 1. Get Project Details (To know the Total Budget)
$project_id = $param1;
$project    = $this->db->get_where('projects', array('id' => $project_id))->row_array();

// 2. Get All Donors
$donors     = $this->db->get('donors')->result_array();

// 3. Current Language
$lang = get_settings('language');
?>

<form method="POST" class="d-block ajaxForm" action="<?= route('funding/create/'.$project_id); ?>">
    
    <!-- Hidden Field for Budget (Used in JS) -->
    <input type="hidden" id="total_project_budget" value="<?= $project['budget']; ?>">

    <div class="form-row">
        
        <!-- 1. Select Donor (Native Select) -->
        <div class="form-group mb-2">
            <label for="donor_id"><?= get_phrase('donor'); ?></label>
            <select name="donor_id" id="donor_id" class="form-control" required>
                <option value=""><?= get_phrase('select_donor'); ?></option>
                <?php foreach($donors as $donor): ?>
                    <option value="<?= $donor['id']; ?>">
                        <?php 
                            // Show Arabic Name if language is Arabic and name_ar exists
                            if($lang == 'arabic' && !empty($donor['name_ar'])){
                                echo $donor['name_ar'];
                            } else {
                                echo $donor['name'];
                            }
                        ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- 2. Funding Type (Native Select) -->
        <div class="form-group mb-2">
            <label for="funding_type"><?= get_phrase('funding_type'); ?></label>
            <select name="funding_type" id="funding_type" class="form-control" required>
                <option value="loan"><?= get_phrase('loan'); ?> (<?= get_phrase('qard'); ?>)</option>
                <option value="grant"><?= get_phrase('grant'); ?> (<?= get_phrase('minha'); ?>)</option>
                <option value="government"><?= get_phrase('government_contribution'); ?></option>
                <option value="in_kind"><?= get_phrase('in_kind'); ?></option>
            </select>
        </div>

        <!-- 3. Amount & Percentage Calculation -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="amount"><?= get_phrase('amount'); ?> (<?= $project['currency'] ?>)</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" required placeholder="0.00">
                    <small class="text-muted"><?= get_phrase('total_budget'); ?>: <?= number_format($project['budget']); ?></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="percentage"><?= get_phrase('percentage'); ?> (%)</label>
                    <input type="number" step="0.01" class="form-control" id="percentage" name="percentage" required placeholder="0.00">
                </div>
            </div>
        </div>

        <!-- 4. Agreement Date -->
        <div class="form-group mb-2">
            <label for="agreement_date"><?= get_phrase('agreement_date'); ?></label>
            <input type="date" class="form-control" id="agreement_date" name="agreement_date" >
        </div>

        <div class="form-group mt-3">
            <button class="btn btn-primary w-100" type="submit"><?= get_phrase('save_funding'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
    // Note: Select2 initialization removed.
    
    // Form Validation
    $(".ajaxForm").validate({});

    // AJAX SUBMISSION
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, function(){
            // Reload the page to update the Budget Summary and Funding Table
            location.reload();
        });
    });

    // -------------------------------------------------------
    // AUTO CALCULATION LOGIC
    // -------------------------------------------------------
    var totalBudget = parseFloat($('#total_project_budget').val());

    // When Amount changes -> Calculate Percentage
    $('#amount').on('keyup change', function() {
        var amount = parseFloat($(this).val());
        if(totalBudget > 0 && amount > 0) {
            var percent = (amount / totalBudget) * 100;
            $('#percentage').val(percent.toFixed(2));
        }
    });

    // When Percentage changes -> Calculate Amount
    $('#percentage').on('keyup change', function() {
        var percent = parseFloat($(this).val());
        if(totalBudget > 0 && percent > 0) {
            var amount = (percent / 100) * totalBudget;
            $('#amount').val(amount.toFixed(2));
        }
    });
});
</script>