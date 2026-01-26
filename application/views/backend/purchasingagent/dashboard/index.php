<div class="row">
    <div class="col-12">
        <h4 class="page-title"><?php echo get_phrase('my_tasks'); ?></h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-4">
        <?php 
            $count = $pending_po_count; 
            $card_class = ($count > 0) ? 'bg-warning-lighten border-warning' : 'bg-light border';
            $text_class = ($count > 0) ? 'text-warning' : 'text-muted';
        ?>
        <div class="card <?php echo $card_class; ?> shadow-none">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="<?php echo $text_class; ?> mt-0" title="<?php echo get_phrase('pending_purchase_orders'); ?>">
                            <?php echo get_phrase('purchase_orders'); ?>
                        </h5>
                        <h3 class="my-2"><?php echo $count; ?></h3>
                        <p class="mb-0 small">
                            <?php echo get_phrase('awaiting_your_action'); ?>
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <i class="mdi mdi-cart-pending <?php echo $text_class; ?>" style="font-size: 48px;"></i>
                    </div>
                </div>
                
                <?php if($count > 0): ?>
                    <hr>
                    <a href="<?php echo site_url($this->session->userdata('user_type').'/purchase_order?step=4'); ?>" class="btn btn-warning btn-sm w-100">
                        <?php echo ($count == 1) ? get_phrase('process_this_task') : get_phrase('view_all_tasks'); ?> 
                        <i class="mdi mdi-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Vous pouvez ajouter d'autres cartes ici (ex: Stock bas, Maintenance) -->
</div>

<?php if($count == 1): ?>
<script>
    // Optionnel : Notification automatique si une seule tâche
    $(document).ready(function() {
        $.NotificationApp.send("<?php echo get_phrase('task_reminder'); ?>", "<?php echo get_phrase('you_have_one_purchase_order_waiting_for_you'); ?>", "top-right", "rgba(0,0,0,0.2)", "info");
    });
</script>
<?php endif; ?>