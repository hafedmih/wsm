<?php
    $v_id = $param1;
    
    // 1. Récupération des détails complets
    $this->db->select('exit_vouchers.*, 
                       projects.name as project_name, 
                       assets.asset_code, assets.name as asset_name,
                       req_user.name as requester_name, req_user.role as requester_role');
    $this->db->from('exit_vouchers');
    $this->db->join('projects', 'projects.id = exit_vouchers.project_id', 'left');
    $this->db->join('assets', 'assets.id = exit_vouchers.asset_id', 'left');
    $this->db->join('users as req_user', 'req_user.id = exit_vouchers.requested_by', 'left');
    $this->db->where('exit_vouchers.id', $v_id);
    $v = $this->db->get()->row_array();

    // 2. Articles
    $items = $this->db->select('exit_voucher_items.*, inventory.name, inventory.sku, inventory.unit')
                      ->join('inventory', 'inventory.id = exit_voucher_items.inventory_id')
                      ->get_where('exit_voucher_items', ['voucher_id' => $v_id])->result_array();

    // 3. Documents & Signatures
    $docs = $this->db->select('exit_voucher_documents.*, users.name as uploader_name, users.role as uploader_role')
                     ->join('users', 'users.id = exit_voucher_documents.uploaded_by')
                     ->get_where('exit_voucher_documents', ['voucher_id' => $v_id])->result_array();
?>

<div class="row">
    <!-- SECTION 1 : INFORMATIONS GÉNÉRALES (Full Width) -->
    <div class="col-12 mb-3">
        <div class="card border">
            <div class="card-body">
                <h5 class="header-title text-primary mb-2"><i class="mdi mdi-information-outline"></i> <?php echo get_phrase('general_information'); ?></h5>
                <div class="row">
                    <div class="col-12">
                        <p class="mb-1"><strong><?php echo get_phrase('code'); ?> :</strong> <span class="badge badge-dark-lighten"><?php echo $v['code']; ?></span></p>
                        <p class="mb-1"><strong><?php echo get_phrase('project'); ?> :</strong> <?php echo !empty($v['project_name']) ? $v['project_name'] : '<span class="text-muted">N/A</span>'; ?></p>
                        <p class="mb-1"><strong><?php echo get_phrase('asset_/_machine'); ?> :</strong> <?php echo !empty($v['asset_code']) ? $v['asset_code'].' - '.$v['asset_name'] : '<span class="text-muted">N/A</span>'; ?></p>
                        <p class="mb-0"><strong><?php echo get_phrase('motive'); ?> :</strong></p>
                        <div class="p-2 bg-light rounded text-muted">
                            <?php echo $v['motive']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2 : TRAÇABILITÉ DU WORKFLOW (Full Width) -->
    <div class="col-12 mb-3">
        <div class="card border">
            <div class="card-body">
                <h5 class="header-title text-success mb-2"><i class="mdi mdi-history"></i> <?php echo get_phrase('workflow_history'); ?></h5>
                
                <!-- Création par Magasinier -->
                <div class="timeline-item border-start ps-3 pb-3">
                    <i class="mdi mdi-circle text-primary" style="margin-left: -23px;"></i>
                    <p class="mb-0"><strong><?php echo get_phrase('request_initiated'); ?></strong></p>
                    <p class="mb-0 small text-muted">
                        <?php echo $v['requester_name']; ?> 
                        <span class="badge badge-outline-secondary"><?php echo ucfirst($v['requester_role']); ?></span> 
                        | <?php echo date('d M Y, H:i', strtotime($v['created_at'])); ?>
                    </p>
                </div>

                <!-- Approbation par Site Manager -->
                <?php 
                    $approval_doc = array_filter($docs, function($d) { return $d['doc_type'] == 'approval_doc'; });
                    $app = reset($approval_doc); 
                ?>
                <div class="timeline-item border-start ps-3">
                    <i class="mdi mdi-circle <?php echo ($v['status'] == 'approved') ? 'text-success' : 'text-warning'; ?>" style="margin-left: -23px;"></i>
                    <p class="mb-0"><strong><?php echo get_phrase('approval_status'); ?></strong></p>
                    <?php if($v['status'] == 'approved' && $app): ?>
                        <p class="mb-0 small text-muted">
                            <?php echo $app['uploader_name']; ?> 
                            <span class="badge badge-outline-success"><?php echo ucfirst($app['uploader_role']); ?></span> 
                            | <?php echo date('d M Y, H:i', strtotime($app['created_at'])); ?>
                        </p>
                    <?php else: ?>
                        <p class="mb-0 small text-warning italic"><?php echo get_phrase('awaiting_approval_from_site_manager'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3 : LISTE DES ARTICLES (Full Width) -->
    <div class="col-12 mb-3">
        <div class="card border">
            <div class="card-body">
                <h5 class="header-title mb-2"><?php echo get_phrase('exit_items_list'); ?></h5>
                <div class="table-responsive">
                    <table class="table table-sm table-centered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th><?php echo get_phrase('sku'); ?></th>
                                <th><?php echo get_phrase('product'); ?></th>
                                <th class="text-center"><?php echo get_phrase('quantity'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $i): ?>
                            <tr>
                                <td><small><?php echo $i['sku']; ?></small></td>
                                <td><?php echo $i['name']; ?></td>
                                <td class="text-center"><strong><?php echo $i['quantity']; ?></strong> <?php echo $i['unit']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4 : DOCUMENTS & PIÈCES JOINTES (Full Width - Stacked) -->
    <div class="col-12 mb-3">
        <div class="card border">
            <div class="card-body">
                <h5 class="header-title text-danger mb-3"><i class="mdi mdi-paperclip"></i> <?php echo get_phrase('justificatifs_&_evidence'); ?></h5>
                
                <?php foreach($docs as $d): 
                    $ext = strtolower(pathinfo($d['file_name'], PATHINFO_EXTENSION));
                    $is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                ?>
                    <div class="mb-4 p-2 border rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge badge-dark">
                                <?php echo ($d['doc_type'] == 'request_doc') ? get_phrase('magasinier_request') : get_phrase('site_manager_approval'); ?>
                            </span>
                            <small class="text-muted">Uploader: <?php echo $d['uploader_name']; ?></small>
                        </div>
                        
                        <?php if($is_image): ?>
                            <div class="text-center">
                                <a href="<?php echo base_url($d['file_path']); ?>" target="_blank">
                                    <img src="<?php echo base_url($d['file_path']); ?>" class="img-fluid rounded border shadow-sm" style="max-height: 400px;">
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-3 bg-light rounded">
                                <i class="mdi mdi-file-pdf text-danger" style="font-size: 48px;"></i>
                                <p><?php echo $d['file_name']; ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php echo base_url($d['file_path']); ?>" download class="btn btn-sm btn-secondary w-100 mt-2">
                            <i class="mdi mdi-download"></i> <?php echo get_phrase('download_this_document'); ?>
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php if(count($docs) == 0): ?>
                    <div class="text-center py-3 text-muted">
                        <p><i><?php echo get_phrase('no_documents_attached_to_this_voucher'); ?></i></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>