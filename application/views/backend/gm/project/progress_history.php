<?php
    // Utilisation de $param1 envoyé par le contrôleur
    $project_id = $param1;
    $progress_log = $this->crud_model->get_project_progress($project_id);
    $project_details = $this->db->get_where('projects', array('id' => $project_id))->row_array();
?>

<div class="row">
    <div class="col-md-12">
        <?php if (isset($project_details) && !empty($project_details)): ?>
            <div class="alert alert-info">
                <strong><?php echo get_phrase('project'); ?>:</strong> <?php echo $project_details['name']; ?> <br>
                <strong><?php echo get_phrase('total_actual_progress'); ?>:</strong> <?php echo $project_details['progress_percent']; ?>%
            </div>
            
            <div class="table-responsive">
                <table class="table table-centered table-borderless table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo get_phrase('date'); ?></th>
                            <th><?php echo get_phrase('milestone_title'); ?></th>
                            <th><?php echo get_phrase('added'); ?></th>
                            <th><?php echo get_phrase('reported_by'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($progress_log) > 0): ?>
                            <?php foreach($progress_log as $log): ?>
                            <tr>
                                <td><?php echo date('d M Y', strtotime($log['date_reported'])); ?></td>
                                <td><?php echo $log['title']; ?></td>
                                <td><span class="badge badge-success-lighten">+<?php echo $log['percentage']; ?>%</span></td>
                                <td><small><?php echo $log['user_name']; ?></small></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center"><?php echo get_phrase('no_history_found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <?php echo get_phrase('project_not_found'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>