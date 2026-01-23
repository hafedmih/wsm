<?php
$entity = 'currency'; // change to 'donor'
$role   = 'category'; // change to 'donor'
$school_id = school_id();
?>
<form method="POST" class="ajaxForm" action="<?= route("$entity/create"); ?>">
    <?php
    $fields = [
        'name','code','symbol'
    ];
    ?>
    
        <?php foreach ($fields as $field): ?>
        <div class="form-group mb-1">
            <label><?= get_phrase($field); ?></label>

            

                <input type="<?= $field=='password'?'password':'text'; ?>"
                       name="<?= $field; ?>" class="form-control" required>
           
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
