<?php 
 include 'details.php';
    $v_id = $param1; 
    $v = $this->db->get_where('exit_vouchers', ['id' => $v_id])->row_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo site_url($this->session->userdata('user_type').'/exit_voucher/approve/'.$v_id); ?>">
    
    <div class="text-center p-3">
        <i class="mdi mdi-help-circle-outline text-primary" style="font-size: 50px;"></i>
        <h4 class="mt-2"><?php echo get_phrase('confirm_approval'); ?>?</h4>
        <p class="text-muted">
            <?php echo get_phrase('you_are_about_to_approve_voucher'); ?> <strong><?php echo $v['code']; ?></strong>.<br>
            <?php echo get_phrase('this_action_will_deduct_stock_immediately'); ?>.
        </p>
    </div>

    <div class="alert alert-info small">
        <i class="mdi mdi-information-outline"></i> 
        <?php echo get_phrase('your_digital_signature'); ?> (<strong><?php echo $this->session->userdata('user_name'); ?></strong>) 
        <?php echo get_phrase('will_be_affixed_to_the_final_document'); ?>.
    </div>

    <button class="btn btn-success w-100" type="submit">
        <i class="mdi mdi-check"></i> <?php echo get_phrase('approve_now'); ?>
    </button>
    <button class="btn btn-light w-100 mt-2" type="button" data-bs-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
</form>

<script>
$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    ajaxSubmit(e, form, showAllVouchers); 
});
</script>