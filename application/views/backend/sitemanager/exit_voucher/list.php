<?php
    // FORCE la définition de la variable au début du fichier
    $user_role = $this->session->userdata('user_type'); 
    $site_id   = $this->session->userdata('site_id');
    
    // Récupération du filtre de statut passé par le contrôleur
    $status_to_show = (isset($selected_status)) ? $selected_status : 'all';

    $this->db->select('exit_vouchers.*, projects.name as project_name, users.name as creator_name');
    $this->db->from('exit_vouchers');
    $this->db->join('projects', 'projects.id = exit_vouchers.project_id', 'left');
    $this->db->join('users', 'users.id = exit_vouchers.requested_by', 'left');
    $this->db->where('exit_vouchers.site_id', $site_id);

    if ($status_to_show == 'pending') {
        $this->db->where('exit_vouchers.status', 'pending');
    }

    $this->db->order_by('exit_vouchers.id', 'DESC');
    $vouchers = $this->db->get()->result_array();
?>

<!-- Le reste de votre code de tableau (Line 73 utilisera maintenant $user_role sans erreur) -->

<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr>
            <th><?php echo get_phrase('code'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('project_/_asset'); ?></th>
            <th><?php echo get_phrase('items'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($vouchers as $v): 
            // Compter les articles
            $item_count = $this->db->get_where('exit_voucher_items', array('voucher_id' => $v['id']))->num_rows();
            $has_docs = $this->db->get_where('exit_voucher_documents', array('voucher_id' => $v['id']))->num_rows();
        ?>
            <tr>
                <td>
                    <strong><?php echo $v['code']; ?></strong>
                    <?php if($has_docs > 0): ?>
                        <i class="mdi mdi-attachment text-primary"></i>
                    <?php endif; ?>
                </td>
                <td><?php echo date('d M Y', strtotime($v['created_at'])); ?></td>
                <td>
                    <!-- Gestion du cas où le projet est vide -->
                    <i class="mdi mdi-briefcase-outline"></i> 
                    <?php echo !empty($v['project_name']) ? $v['project_name'] : '<span class="text-muted">'.get_phrase('no_project').'</span>'; ?>
                    <br>
                    <!-- Gestion du cas où l'asset est vide -->
                    <i class="mdi mdi-engine-outline"></i> 
                    <?php echo !empty($v['asset_name']) ? $v['asset_name'] : '<span class="text-muted">'.get_phrase('no_asset').'</span>'; ?>
                </td>
                <td>
                    <span class="badge badge-info-lighten"><?php echo $item_count; ?> <?php echo get_phrase('items'); ?></span>
                </td>
                <td>
                    <?php if ($v['status'] == 'approved'): ?>
                        <span class="badge badge-success-lighten"><?php echo get_phrase('approved'); ?></span>
                    <?php else: ?>
                        <span class="badge badge-warning-lighten"><?php echo get_phrase('pending'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/exit_voucher/details/'.$v['id'])?>', '<?php echo get_phrase('voucher_details'); ?>');">
                                <i class="mdi mdi-information-outline"></i> <?php echo get_phrase('details'); ?>
                            </a>

                            <?php if($user_role == 'sitemanager' && $v['status'] == 'pending'): ?>
                                <a href="javascript:void(0);" class="dropdown-item text-success" onclick="rightModal('<?php echo site_url('modal/popup/exit_voucher/approve_voucher/'.$v['id'])?>', '<?php echo get_phrase('approve'); ?>');">
                                    <i class="mdi mdi-check"></i> <?php echo get_phrase('approve_&_sign'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>