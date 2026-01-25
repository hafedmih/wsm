<div class="row">
    <div class="col-12">
        <h4 class="mb-3"><?php echo get_phrase('active_projects_status'); ?></h4>
    </div>
</div>

<div class="row">
    <?php 
    if (count($active_projects) > 0):
        foreach($active_projects as $project): 
            // --- LOGIQUE DE COULEUR ---
            $today = new DateTime(date('Y-m-d'));
            $deadline = new DateTime($project['deadline']);
            $interval = $today->diff($deadline);
            $days_left = $interval->format('%r%a'); // %r affiche le signe "-" si dépassé

            $card_color = "bg-success"; // Vert par défaut (> 14 jours)
            $text_color = "text-white";

            if ($days_left <= 0) {
                $card_color = "bg-danger"; // Rouge (Retard ou aujourd'hui)
            } elseif ($days_left <= 7) {
                $card_color = "bg-warning"; // Orange/Jaune (Urgent < 7 jours)
                $text_color = "text-dark";
            } elseif ($days_left <= 14) {
                $card_color = "bg-info"; // Bleu (Approche < 14 jours)
            }
            ?>
            
            <div class="col-md-6 col-xl-3">
                <div class="card <?php echo $card_color; ?> <?php echo $text_color; ?> shadow-sm">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-briefcase-check widget-icon"></i>
                        </div>
                        <h5 class="fw-normal mt-0" title="<?php echo get_phrase('project_name'); ?>">
                            <?php echo $project['name']; ?>
                        </h5>
                        <h3 class="mt-3 mb-3"><?php echo $project['progress_percent']; ?>%</h3>
                        
                        <p class="mb-0">
                            <span class="me-2">
                                <i class="mdi mdi-calendar-clock"></i> 
                                <?php 
                                if($days_left < 0) echo get_phrase('overdue_by').' '.abs($days_left).' '.get_phrase('days');
                                elseif($days_left == 0) echo get_phrase('due_today');
                                else echo $days_left.' '.get_phrase('days_remaining');
                                ?>
                            </span>
                        </p>
                        <div class="progress progress-sm mt-2" style="background-color: rgba(255,255,255,0.2); height: 5px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: <?php echo $project['progress_percent']; ?>%"></div>
                        </div>
                        <small class="mt-1 d-block">Deadline: <?php echo date('d M Y', strtotime($project['deadline'])); ?></small>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <p><?php echo get_phrase('no_active_projects'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>