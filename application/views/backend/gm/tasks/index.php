<div class="row">
    <div class="col-12">
        <div class="card bg-secondary text-white border-0 mb-4">
            <div class="card-body">
                <h4 class="mt-0"><i class="mdi mdi-format-list-checks"></i> <?php echo get_phrase('pending_approvals_center'); ?></h4>
                <p><?php echo get_phrase('please_review_the_following_items_requiring_your_immediate_action'); ?>.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- 1. POs à Signer -->
    <div class="col-md-4">
        <div class="card border-danger shadow-none border">
            <div class="card-body text-center">
                <i class="mdi mdi-pen text-danger" style="font-size: 40px;"></i>
                <h3 class="mt-2"><?php echo $to_sign; ?></h3>
                <p class="text-muted"><?php echo get_phrase('purchase_orders_to_sign'); ?></p>
                <a href="<?php echo site_url('gm/purchase_order?step=3'); ?>" class="btn btn-danger btn-sm w-100">
                    <?php echo get_phrase('go_to_signatures'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. POs à Payer -->
    <div class="col-md-4">
        <div class="card border-warning shadow-none border">
            <div class="card-body text-center">
                <i class="mdi mdi-cash-multiple text-warning" style="font-size: 40px;"></i>
                <h3 class="mt-2"><?php echo $to_pay; ?></h3>
                <p class="text-muted"><?php echo get_phrase('payments_to_process'); ?></p>
                <a href="<?php echo site_url('gm/purchase_order?step=5'); ?>" class="btn btn-warning btn-sm w-100 text-white">
                    <?php echo get_phrase('go_to_payments'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- 3. Exit Vouchers à Approuver -->
    <div class="col-md-4">
        <div class="card border-info shadow-none border">
            <div class="card-body text-center">
                <i class="mdi mdi-cart-arrow-down text-info" style="font-size: 40px;"></i>
                <h3 class="mt-2"><?php echo $pending_vouchers; ?></h3>
                <p class="text-muted"><?php echo get_phrase('vouchers_waiting_approval'); ?></p>
                <a href="<?php echo site_url('gm/exit_voucher/pending'); ?>" class="btn btn-info btn-sm w-100">
                    <?php echo get_phrase('go_to_vouchers'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12 text-center">
        <a href="<?php echo site_url('gm/dashboard'); ?>" class="btn btn-link text-muted">
            <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back_to_dashboard'); ?>
        </a>
    </div>
</div>