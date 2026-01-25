<!-- Statistiques Rapides -->
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat bg-primary text-white">
            <div class="card-body">
                <h5 class="fw-normal mt-0"><?php echo get_phrase('total_active_projects'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo $total_projects; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card widget-flat bg-success text-white">
            <div class="card-body">
                <h5 class="fw-normal mt-0"><?php echo get_phrase('total_budget_open'); ?></h5>
                <h3 class="mt-3 mb-1"><?php echo number_format($total_budget, 2); ?> MRU</h3>
            </div>
        </div>
    </div>
</div>

<!-- Liste des Projets sous forme de Cartes Colorées -->
<div class="row">
    <div class="col-12 mt-4">
        <h4><?php echo get_phrase('project_deadlines_tracking'); ?></h4>
    </div>
    
    <?php 
    foreach($active_projects as $project): 
        // Logique de calcul de jours et de couleur
        $today = new DateTime(date('Y-m-d'));
        $deadline = new DateTime($project['deadline']);
        $diff = $today->diff($deadline);
        $days_left = (int)$diff->format('%r%a');

        // Détermination de la couleur
        if ($days_left < 0) {
            $card_class = "bg-danger text-white"; // Retard (Rouge)
            $label = get_phrase('overdue');
        } elseif ($days_left <= 7) {
            $card_class = "bg-warning text-dark"; // Urgent < 7j (Orange/Jaune)
            $label = get_phrase('urgent');
        } elseif ($days_left <= 15) {
            $card_class = "bg-info text-white"; // Approche < 15j (Bleu)
            $label = get_phrase('near_deadline');
        } else {
            $card_class = "bg-success text-white"; // En sécurité (Vert)
            $label = get_phrase('on_track');
        }
    ?>
    <div class="col-md-6 col-xl-4">
        <div class="card <?php echo $card_class; ?> shadow-lg">
            <div class="card-body">
                <div class="float-end">
                    <small class="badge badge-light-lighten">
                        <?php echo ($project['site_id'] == 1) ? 'Nouakchott' : 'Tasiast'; ?>
                    </small>
                </div>
                <h5 class="mt-0"><?php echo $project['name']; ?></h5>
                <p class="mb-1 small">Client: <?php echo $project['client_name']; ?></p>
                
                <div class="my-3">
                    <h2 class="mb-0"><?php echo $project['progress_percent']; ?>%</h2>
                    <div class="progress progress-sm" style="background: rgba(255,255,255,0.3); height: 6px;">
                        <div class="progress-bar bg-white" style="width: <?php echo $project['progress_percent']; ?>%"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <small><?php echo get_phrase('deadline'); ?>:</small>
                        <p class="mb-0 fw-bold"><?php echo date('d M Y', strtotime($project['deadline'])); ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <small><?php echo get_phrase('status'); ?>:</small>
                        <p class="mb-0 fw-bold"><?php echo $label; ?> (<?php echo $days_left; ?>j)</p>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="background: rgba(0,0,0,0.05); border:0;">
                <button class="btn btn-sm btn-light w-100" onclick="rightModal('<?php echo site_url('gm/project/progress_history/'.$project['id']); ?>', '<?php echo get_phrase('view_details'); ?>')">
                    <i class="mdi mdi-eye"></i> <?php echo get_phrase('details'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>