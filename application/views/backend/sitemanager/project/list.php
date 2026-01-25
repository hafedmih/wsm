<?php
// Protection : si $projects n'existe pas, on va le chercher directement (sécurité)
if (!isset($projects)) {
    $current_site_id = $this->session->userdata('site_id');
    $projects = $this->db->get_where('projects', array('site_id' => $current_site_id))->result_array();
}
?>

<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr>
            <th><?php echo get_phrase('project_name'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('deadline'); ?></th>
            <th><?php echo get_phrase('progress'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (count($projects) > 0):
            foreach($projects as $project): 
                $today = time();
                $due = strtotime($project['deadline']);
                $color = ($due < $today) ? 'badge-danger' : 'badge-success';
        ?>
            <tr>
                <td><strong><?php echo $project['name']; ?></strong></td>
                <td>
    <?php if ($project['status'] == 'completed'): ?>
        <span class="badge badge-success-lighten">
            <i class="mdi mdi-check-all"></i> <?php echo get_phrase('completed'); ?>
        </span>
    <?php else: ?>
        <span class="badge badge-info-lighten"><?php echo get_phrase('in_progress'); ?></span>
    <?php endif; ?>
</td>
                <td><span class=" <?php echo $color; ?>"><?php echo $project['deadline']; ?></span></td>
                <td>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: <?php echo $project['progress_percent']; ?>%;"></div>
                    </div>
                    <small><?php echo $project['progress_percent']; ?>%</small>
                </td>
               <td>
    <!-- On vérifie si le projet n'est pas complété avant d'afficher le bouton -->
    <?php if ($project['status'] != 'completed' && $project['status'] != 'cancelled'): ?>
        
        <button type="button" class="btn btn-sm btn-outline-primary" 
            onclick="rightModal('<?php echo site_url('sitemanager/project/add_progress/'.$project['id']); ?>', '<?php echo get_phrase('update_progress'); ?>')"
            title="<?php echo get_phrase('add_progress'); ?>">
            <i class="mdi mdi-plus"></i>
        </button>

    <?php else: ?>
        
        <!-- Optionnel : Afficher un badge de verrouillage ou laisser vide -->
<!--        <span class="badge badge-secondary-lighten">
            <i class="mdi mdi-lock"></i> <?php echo get_phrase('locked'); ?>
        </span>-->

    <?php endif; ?>

    <!-- Le bouton historique reste visible pour voir ce qui a été fait -->
    <button type="button" class="btn btn-sm btn-outline-info" 
        onclick="rightModal('<?php echo site_url($this->session->userdata('user_type').'/project/progress_history/'.$project['id']); ?>', '<?php echo get_phrase('progress_log'); ?>')">
        <i class="mdi mdi-history"></i>
    </button>
</td>
            </tr>
        <?php 
            endforeach; 
        else: ?>
            <tr>
                <td colspan="4" class="text-center"><?php echo get_phrase('no_projects_assigned_to_your_site'); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>