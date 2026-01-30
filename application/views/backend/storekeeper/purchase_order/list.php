<?php
    $user_type = strtolower($this->session->userdata('user_type'));
    $session_site_id = $this->session->userdata('site_id');

    // 1. Construction de la requête
    $this->db->select('purchase_orders.*, projects.name as project_name, users.name as creator_name, sites.name as site_name');
    $this->db->from('purchase_orders');
    $this->db->join('projects', 'projects.id = purchase_orders.project_id', 'left');
    $this->db->join('users', 'users.id = purchase_orders.requested_by', 'left');
    $this->db->join('sites', 'sites.id = purchase_orders.site_id', 'left');
    
    if(in_array($user_type, ['storekeeper', 'sitemanager'])) {
        if (!empty($session_site_id)) {
            $this->db->where('purchase_orders.site_id', $session_site_id);
        }
    }
    
    $this->db->order_by('purchase_orders.id', 'DESC');
    $purchase_orders = $this->db->get()->result_array();

    $steps = [
        1 => ['lbl' => 'Draft', 'class' => 'badge-secondary-lighten', 'next' => 2],
        2 => ['lbl' => 'Site Approved', 'class' => 'badge-info-lighten', 'next' => 3],
        3 => ['lbl' => 'Procurement Verified', 'class' => 'badge-primary-lighten', 'next' => 4],
        4 => ['lbl' => 'GM Signed', 'class' => 'badge-warning-lighten', 'next' => 5],
        5 => ['lbl' => 'Invoiced (Purchasing)', 'class' => 'badge-dark-lighten', 'next' => 6],
        6 => ['lbl' => 'Paid (GM)', 'class' => 'badge-success-lighten', 'next' => 7],
        7 => ['lbl' => 'Archived', 'class' => 'badge-secondary-lighten', 'next' => null]
    ];
?>

<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr>
            <th><?php echo get_phrase('po_code'); ?></th>
            <th><?php echo get_phrase('project_/_site'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th class="text-center"><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (count($purchase_orders) > 0):
            foreach($purchase_orders as $po): 
                $status = (int)$po['status'];
                $current_step = isset($steps[$status]) ? $steps[$status] : ['lbl' => 'Unknown', 'class' => 'badge-danger-lighten', 'next' => null];
        ?>
            <tr>
                <td>
                    <strong><?php echo $po['code']; ?></strong><br>
                    <small class="text-muted"><?php echo $po['creator_name']; ?></small>
                </td>
                <td>
                    <i class="mdi mdi-briefcase"></i> <?php echo !empty($po['project_name']) ? $po['project_name'] : 'N/A'; ?><br>
                    <i class="mdi mdi-map-marker"></i> <small><?php echo !empty($po['site_name']) ? $po['site_name'] : 'N/A'; ?></small>
                </td>
                <td>
                    <span class="badge <?php echo $current_step['class']; ?>">
                        <?php echo get_phrase($current_step['lbl']); ?>
                    </span>
                </td>
                <td class="text-center">
                    <!-- BOUTON DÉTAILS DIRECT (PLUS BESOIN DE CLIQUER SUR LES 3 POINTS) -->
                    <button type="button" class="btn btn-sm btn-outline-info" 
                            onclick="rightModal('<?php echo site_url('modal/popup/purchase_order/details/'.$po['id']); ?>', '<?php echo get_phrase('po_details'); ?>')"
                            title="<?php echo get_phrase('view_details'); ?>">
                        <i class="mdi mdi-information-outline"></i> <?php echo get_phrase('details'); ?>
                    </button>

                    <!-- MENU ACTIONS DYNAMIQUES (POUR LES AUTRES RÔLES / ÉTAPES) -->
                    <?php 
                        $can_action = false;
                        $next_status = $current_step['next'];

                        if($user_type == 'sitemanager' && $status == 1) $can_action = true;
                        if($user_type == 'procurement' && $status == 2) $can_action = true;
                        if($user_type == 'gm' && $status == 3) $can_action = true;
                        if($user_type == 'purchasingagent' && $status == 4) $can_action = true;
                        if($user_type == 'gm' && $status == 5) $can_action = true;
                        if(in_array($user_type, ['accountant', 'daf']) && $status == 6) $can_action = true;

                        if($can_action && $next_status):
                    ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if($next_status == 7): ?>
                                    <a class="dropdown-item text-success" href="javascript:void(0);" onclick="confirmModal('<?php echo site_url($user_type.'/purchase_order/update_status/'.$po['id'].'/7'); ?>', showAllPurchaseOrders)">
                                        <i class="mdi mdi-archive"></i> <?php echo get_phrase('archive_now'); ?>
                                    </a>
                                <?php else: ?>
                                    <a class="dropdown-item text-primary" href="javascript:void(0);" onclick="rightModal('<?php echo site_url('modal/popup/purchase_order/step_upload/'.$po['id'].'/'.$next_status); ?>', '<?php echo get_phrase('approve_with_document'); ?>')">
                                        <i class="mdi mdi-file-upload"></i> <?php echo get_phrase('upload_&_approve'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center p-5 text-muted">
                    <i class="mdi mdi-folder-open-outline d-block" style="font-size: 40px;"></i>
                    <?php echo get_phrase('no_purchase_orders_found'); ?>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>