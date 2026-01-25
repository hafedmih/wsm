<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr>
            <th><?php echo get_phrase('project_name'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('budget'); ?></th>
            <th><?php echo get_phrase('deadline'); ?></th>
            <th><?php echo get_phrase('progress'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $projects = $this->db->get('projects')->result_array();
        foreach($projects as $project): 
            // Calcul de la couleur de la deadline
            $today = time();
            $due_date = strtotime($project['deadline']);
            $diff = $due_date - $today;
            $days = round($diff / (60 * 60 * 24));
            $color = ($days < 0) ? 'badge-danger' : (($days <= 7) ? 'badge-warning' : 'badge-success');
        ?>
        <tr>
            <td><strong><?php echo $project['name']; ?></strong><br><small><?php echo $project['client_name']; ?></small></td>
                <td>
    <?php if ($project['status'] == 'completed'): ?>
        <span class="badge badge-success-lighten">
            <i class="mdi mdi-check-all"></i> <?php echo get_phrase('completed'); ?>
        </span>
    <?php else: ?>
        <span class="badge badge-info-lighten"><?php echo get_phrase('in_progress'); ?></span>
    <?php endif; ?>
</td>
            <td><?php echo number_format($project['quotation_amount'], 2); ?> MRU</td>
            <td><span class=" <?php echo $color; ?>"><?php echo $project['deadline']; ?></span></td>
            <td>
                <div class="progress progress-sm">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $project['progress_percent']; ?>%;"></div>
                </div>
                <small><?php echo $project['progress_percent']; ?>%</small>
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="rightModal('<?php echo site_url('modal/popup/project/edit/'.$project['id']); ?>')"><?php echo get_phrase('edit'); ?></a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="rightModal('<?php echo site_url('modal/popup/project/progress_history/'.$project['id']); ?>')"><?php echo get_phrase('progress_log'); ?></a>
                        
                            <?php if($project['contract_file']): ?>
                            <a class="dropdown-item" href="<?php echo base_url('uploads/contracts/'.$project['contract_file']); ?>" target="_blank"><?php echo get_phrase('view_contract'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>