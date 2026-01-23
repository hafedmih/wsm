<?php
$entity = 'donor'; // change to 'donor'
$role   = 'donor'; // change to 'donor'
$school_id = school_id();
?>
<?php
$user = $this->db->get_where('users',['id'=>$param1])->row_array();
?>

<form method="POST" class="ajaxForm" action="<?= route("$entity/update/$param1"); ?>">

<?php foreach ($user as $key=>$value): if($key=='password') continue; ?>
    <div class="form-group mb-1">
        <label><?= get_phrase($key); ?></label>

        <?php if ($key=='address'): ?>
            <textarea name="<?= $key ?>" class="form-control"><?= $value ?></textarea>
        <?php else: ?>
            <input name="<?= $key ?>" value="<?= $value ?>" class="form-control">
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<button class="btn btn-primary w-100"><?= get_phrase("update_$entity"); ?></button>
</form>

<script>
$(".ajaxForm").validate();
$(".ajaxForm").submit(function(e){
    ajaxSubmit(e, $(this), showAll);
});
</script>
