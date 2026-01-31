<div class="row">
    <div class="col-12">
        <div class="card bg-dark text-white border-0 mb-4">
            <div class="card-body">
                <h4 class="mt-0"><i class="mdi mdi-checkbox-marked-circle-outline"></i> <?php echo get_phrase('site_approvals_center'); ?></h4>
                <p><?php echo get_phrase('centralized_view_of_documents_requiring_your_signature'); ?>.</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <!-- 1. Bons de Commande (Purchase Orders) -->
    <div class="col-md-5">
        <div class="card border-primary shadow-none border">
            <div class="card-body text-center">
                <i class="mdi mdi-cart-arrow-right text-primary" style="font-size: 50px;"></i>
                <h3 class="mt-2"><?php echo $pending_pos; ?></h3>
                <h5 class="fw-normal"><?php echo get_phrase('purchase_orders_to_approve'); ?></h5>
                <p class="text-muted small"><?php echo get_phrase('pending_technical_validation'); ?></p>
                <hr>
                <a href="<?php echo site_url('sitemanager/purchase_order?step=1'); ?>" class="btn btn-primary btn-sm w-100">
                    <?php echo get_phrase('view_orders'); ?> <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Bons de Sortie (Exit Vouchers) -->
    <div class="col-md-5">
        <div class="card border-info shadow-none border">
            <div class="card-body text-center">
                <i class="mdi mdi-archive-arrow-down text-info" style="font-size: 50px;"></i>
                <h3 class="mt-2"><?php echo $pending_vouchers; ?></h3>
                <h5 class="fw-normal"><?php echo get_phrase('exit_vouchers_to_approve'); ?></h5>
                <p class="text-muted small"><?php echo get_phrase('pending_stock_deduction'); ?></p>
                <hr>
                <a href="<?php echo site_url('sitemanager/exit_voucher/pending'); ?>" class="btn btn-info btn-sm w-100">
                    <?php echo get_phrase('view_vouchers'); ?> <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <a href="<?php echo site_url('sitemanager/dashboard'); ?>" class="btn btn-link text-muted">
            <i class="mdi mdi-view-dashboard-outline"></i> <?php echo get_phrase('back_to_main_dashboard'); ?>
        </a>
    </div>
</div>