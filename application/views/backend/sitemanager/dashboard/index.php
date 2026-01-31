<?php 
    $site_name = ($this->session->userdata('site_id') == 1) ? 'Nouakchott' : 'Tasiast';
?>

<!-- ENTÊTE DU DASHBOARD -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                <i class="mdi mdi-view-dashboard"></i> <?php echo get_phrase('site_overview'); ?> : 
                <span class="text-primary"><?php echo $site_name; ?></span>
            </h4>
        </div>
    </div>
</div>

<!-- SECTION 1 : CARTES DE STATISTIQUES ET TÂCHES -->
<div class="row">
    <!-- Carte Projets Actifs sur le site -->
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat bg-primary text-white shadow-none">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-briefcase-check widget-icon"></i>
                </div>
                <h5 class="fw-normal mt-0"><?php echo get_phrase('active_projects'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo count($active_projects); ?></h3>
                <p class="mb-0 text-white-50 small">
                    <?php echo get_phrase('currently_running_on_this_site'); ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Carte : My Tasks (Groupée) -->
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat <?php echo ($total_tasks > 0) ? 'bg-danger text-white' : 'bg-light border'; ?> shadow-none">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-bell-ring widget-icon <?php echo ($total_tasks > 0) ? 'text-white' : 'text-danger'; ?>"></i>
                </div>
                <h5 class="fw-normal mt-0"><?php echo get_phrase('my_site_tasks'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo $total_tasks; ?></h3>
                <p class="mb-0">
                    <a href="<?php echo site_url('sitemanager/my_tasks'); ?>" class="<?php echo ($total_tasks > 0) ? 'text-white' : 'text-danger'; ?> fw-bold font-13">
                        <i class="mdi mdi-arrow-right-circle"></i> <?php echo get_phrase('open_task_center'); ?>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Carte : Bons de Sortie en Attente -->
    
</div>

<!-- SECTION 2 : TRACKING VISUEL DES PROJETS -->
<div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3"><i class="mdi mdi-calendar-clock"></i> <?php echo get_phrase('project_deadlines_&_progress'); ?></h4>
    </div>
    
    <?php 
    if (count($active_projects) > 0):
        foreach($active_projects as $project): 
            // Calcul du délai
            $today = new DateTime(date('Y-m-d'));
            $deadline = new DateTime($project['deadline']);
            $diff = $today->diff($deadline);
            $days_left = (int)$diff->format('%r%a');

            // Logique de couleur de bordure et de barre
            if ($days_left < 0) {
                $border = "border-danger"; $bar = "bg-danger"; $lbl = "text-danger"; $status_txt = get_phrase('overdue');
            } elseif ($days_left <= 7) {
                $border = "border-warning"; $bar = "bg-warning"; $lbl = "text-warning"; $status_txt = get_phrase('urgent');
            } else {
                $border = "border-success"; $bar = "bg-success"; $lbl = "text-success"; $status_txt = get_phrase('on_track');
            }
    ?>
    <div class="col-md-6 col-xl-4">
        <div class="card border shadow-none <?php echo $border; ?> mb-3">
            <div class="card-body">
                <h5 class="mt-0 text-truncate"><?php echo $project['name']; ?></h5>
                <p class="text-muted small mb-2">Client: <strong><?php echo $project['client_name']; ?></strong></p>
                
                <div class="row align-items-center no-gutters">
                    <div class="col-auto">
                        <span class="fw-bold me-2"><?php echo $project['progress_percent']; ?>%</span>
                    </div>
                    <div class="col">
                        <div class="progress progress-sm">
                            <div class="progress-bar <?php echo $bar; ?>" role="progressbar" style="width: <?php echo $project['progress_percent']; ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <small class="text-muted d-block"><?php echo get_phrase('deadline'); ?></small>
                        <span class="fw-bold small"><?php echo date('d M Y', strtotime($project['deadline'])); ?></span>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted d-block"><?php echo get_phrase('status'); ?></small>
                        <span class="fw-bold small <?php echo $lbl; ?>"><?php echo $status_txt; ?> (<?php echo $days_left; ?>j)</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light p-1">
                <button class="btn btn-sm btn-link text-dark w-100" onclick="rightModal('<?php echo site_url('sitemanager/project/add_progress/'.$project['id']); ?>', '<?php echo get_phrase('update_progress'); ?>')">
                    <i class="mdi mdi-plus-circle-outline"></i> <?php echo get_phrase('update_progress'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; else: ?>
    <div class="col-12">
        <div class="alert alert-light text-center border">
            <i class="mdi mdi-folder-open-outline d-block font-24"></i>
            <?php echo get_phrase('no_active_projects_assigned_to_this_site'); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- NOTIFICATION AUTOMATIQUE -->
<?php if($total_tasks > 0): ?>
<script>
    $(document).ready(function() {
        $.NotificationApp.send(
            "<?php echo get_phrase('pending_tasks'); ?>", 
            "<?php echo get_phrase('you_have'); ?> <?php echo $total_tasks; ?> <?php echo get_phrase('items_requiring_attention_on_your_site'); ?>", 
            "top-right", 
            "rgba(0,0,0,0.2)", 
            "warning"
        );
    });
</script>
<?php endif; ?>