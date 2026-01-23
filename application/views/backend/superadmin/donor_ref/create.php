<?php
$entity = 'donor'; // change to 'donor'
$role   = 'donor'; // change to 'donor'
$school_id = school_id();
?>
<form method="POST" class="ajaxForm" action="<?= route("$entity/create"); ?>">
    <?php
    $fields = [
        'name','email','password','phone','address'
    ];
    ?>

    <?php foreach ($fields as $field): ?>
        <div class="form-group mb-1">
            <label><?= get_phrase($field); ?></label>

            <?php if ($field == 'gender'): ?>
                <select name="gender" class="form-control select2">
                    <option value=""><?= get_phrase('select_a_gender'); ?></option>
                    <option value="Male"><?= get_phrase('male'); ?></option>
                    <option value="Female"><?= get_phrase('female'); ?></option>
                </select>

            <?php elseif ($field == 'blood_group'): ?>
                <select name="blood_group" class="form-control select2">
                    <option value="">Select</option>
                    <option>A+</option><option>A-</option>
                    <option>B+</option><option>B-</option>
                    <option>O+</option><option>O-</option>
                </select>

            <?php elseif ($field == 'address'): ?>
                <textarea name="address" class="form-control" rows="4"></textarea>

            <?php else: ?>
                <input type="<?= $field=='password'?'password':'text'; ?>"
                       name="<?= $field; ?>" class="form-control" required>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <button class="btn btn-primary w-100"><?= get_phrase("create_$entity"); ?></button>
</form>

<script>
$(".ajaxForm").validate();
$(".ajaxForm").submit(function(e){
    ajaxSubmit(e, $(this), showAll);
});
</script>
