<?php 
    // Calcul des statistiques pour la carte groupée
    $to_sign = $this->db->get_where('purchase_orders', ['status' => 3])->num_rows();
    $to_pay  = $this->db->get_where('purchase_orders', ['status' => 5])->num_rows();
    $pending_vouchers = $this->db->get_where('exit_vouchers', ['status' => 'pending'])->num_rows();
    
    $total_tasks = $to_sign + $to_pay + $pending_vouchers;
?>

<!-- SECTION 1 : STATISTIQUES GLOBALES -->
<div class="row">
    <div class="col-12">
        <h4 class="page-title"><i class="mdi mdi-view-dashboard"></i> <?php echo get_phrase('manager_overview'); ?></h4>
    </div>
</div>

<div class="row">
    <!-- Statistique : Projets Actifs -->
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat bg-primary text-white">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-briefcase-check widget-icon"></i></div>
                <h5 class="fw-normal mt-0"><?php echo get_phrase('active_projects'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo $total_projects; ?></h3>
            </div>
        </div>
    </div>

    <!-- Statistique : Budget Total Ouvert -->
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat bg-success text-white">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-currency-usd widget-icon"></i></div>
                <h5 class="fw-normal mt-0"><?php echo get_phrase('total_open_budget'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo number_format($total_budget, 0); ?> <small>MRU</small></h3>
            </div>
        </div>
    </div>

    <!-- NOUVELLE CARTE GROUPÉE : MY TASKS -->
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat <?php echo ($total_tasks > 0) ? 'bg-danger text-white' : 'bg-light'; ?>">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-bell-ring widget-icon"></i></div>
                <h5 class="fw-normal mt-0 text-truncate"><?php echo get_phrase('my_pending_tasks'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo $total_tasks; ?></h3>
                <p class="mb-0">
                    <a href="<?php echo site_url('gm/my_tasks'); ?>" class="<?php echo ($total_tasks > 0) ? 'text-white' : 'text-primary'; ?> font-13 fw-bold">
                        <?php echo get_phrase('open_task_center'); ?> <i class="mdi mdi-arrow-right-circle"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 2 : TRACKING DES PROJETS (DEADLINES) -->
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="mdi mdi-calendar-clock"></i> <?php echo get_phrase('project_deadlines_tracking'); ?></h4>
            <a href="<?php echo site_url('gm/project'); ?>" class="btn btn-sm btn-link"><?php echo get_phrase('view_all_projects'); ?></a>
        </div>
    </div>
</div>

<div class="row">
    <?php 
    foreach($active_projects as $project): 
        $today = new DateTime(date('Y-m-d'));
        $deadline = new DateTime($project['deadline']);
        $diff = $today->diff($deadline);
        $days_left = (int)$diff->format('%r%a');

        if ($days_left < 0) {
            $card_class = "border-danger"; $bar_class = "bg-danger"; $label_class = "text-danger";
            $label = get_phrase('overdue');
        } elseif ($days_left <= 7) {
            $card_class = "border-warning"; $bar_class = "bg-warning"; $label_class = "text-warning";
            $label = get_phrase('urgent');
        } else {
            $card_class = "border-success"; $bar_class = "bg-success"; $label_class = "text-success";
            $label = get_phrase('on_track');
        }
    ?>
    <div class="col-md-6 col-xl-4">
        <div class="card shadow-none border <?php echo $card_class; ?>">
            <div class="card-body">
                <div class="float-end">
                    <span class="badge badge-outline-secondary"><?php echo ($project['site_id'] == 1) ? 'NKC' : 'Tasiast'; ?></span>
                </div>
                <h5 class="mt-0 text-truncate" style="max-width: 80%;"><?php echo $project['name']; ?></h5>
                <p class="text-muted font-13 mb-3">Client: <strong><?php echo $project['client_name']; ?></strong></p>
                
                <div class="row align-items-center">
                    <div class="col-auto">
                        <h3 class="m-0"><?php echo $project['progress_percent']; ?>%</h3>
                    </div>
                    <div class="col">
                        <div class="progress progress-sm">
                            <div class="progress-bar <?php echo $bar_class; ?>" style="width: <?php echo $project['progress_percent']; ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 font-13">
                    <div class="col-6">
                        <span class="text-muted"><?php echo get_phrase('deadline'); ?></span>
                        <p class="mb-0 fw-bold"><?php echo date('d M Y', strtotime($project['deadline'])); ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-muted"><?php echo get_phrase('status'); ?></span>
                        <p class="mb-0 fw-bold <?php echo $label_class; ?>"><?php echo $label; ?> (<?php echo $days_left; ?>j)</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light p-1 text-center">
                <button class="btn btn-sm btn-link text-dark w-100" onclick="rightModal('<?php echo site_url('gm/project/progress_history/'.$project['id']); ?>', '<?php echo get_phrase('view_details'); ?>')">
                    <i class="mdi mdi-history"></i> <?php echo get_phrase('progress_log'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- NOTIFICATION AUTOMATIQUE MISE À JOUR -->
<?php if($total_tasks > 0): ?>
<script>
    $(document).ready(function() {
        $.NotificationApp.send(
            "<?php echo get_phrase('pending_approvals'); ?>", 
            "<?php echo get_phrase('you_have'); ?> <?php echo $total_tasks; ?> <?php echo get_phrase('tasks_waiting_for_your_approval'); ?> (POs & Vouchers)", 
            "top-right", 
            "rgba(0,0,0,0.2)", 
            "warning"
        );
    });
</script>
<?php endif; ?>