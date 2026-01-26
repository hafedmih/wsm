<?php
    $po_id = $param1;
    
    // 1. Informations principales du PO
    $this->db->select('purchase_orders.*, 
                       projects.name as project_name, 
                       sites.name as site_name,
                       req_user.name as requester_name, req_user.role as requester_role');
    $this->db->from('purchase_orders');
    $this->db->join('projects', 'projects.id = purchase_orders.project_id', 'left');
    $this->db->join('sites', 'sites.id = purchase_orders.site_id', 'left');
    $this->db->join('users as req_user', 'req_user.id = purchase_orders.requested_by', 'left');
    $this->db->where('purchase_orders.id', $po_id);
    $po = $this->db->get()->row_array();

    // 2. Articles commandés
    $items = $this->db->select('purchase_order_items.*, inventory.name, inventory.sku, inventory.unit')
                      ->join('inventory', 'inventory.id = purchase_order_items.inventory_id')
                      ->get_where('purchase_order_items', ['purchase_order_id' => $po_id])->result_array();

    // 3. Documents du Workflow avec infos uploader
    $docs = $this->db->select('purchase_order_docs.*, users.name as uploader_name, users.role as uploader_role')
                     ->join('users', 'users.id = purchase_order_docs.uploaded_by')
                     ->get_where('purchase_order_docs', ['purchase_order_id' => $po_id])->result_array();

    // Mapping des types de documents par étape pour la timeline
    $doc_map = [
        2 => 'site_signed_doc',
        3 => 'procurement_signed_doc',
        4 => 'gm_signed_doc',
        5 => 'invoice_doc',
        6 => 'payment_doc'
    ];
?>

<div class="row">
    <!-- SECTION 1 : INFORMATIONS GÉNÉRALES -->
    <div class="col-12 mb-3">
    <div class="card border shadow-none">
        <div class="card-body">
            <h5 class="header-title text-primary mb-3">
                <i class="mdi mdi-information-outline"></i> <?php echo get_phrase('po_general_information'); ?>
            </h5>
            
            <div class="row">
                <!-- BLOC 1 : Détails du Projet -->
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1 font-13"><?php echo get_phrase('project_details'); ?></p>
                    <p class="mb-1"><strong><?php echo get_phrase('po_code'); ?> :</strong> <span class="badge badge-dark-lighten"><?php echo $po['code']; ?></span></p>
                    <p class="mb-1"><strong><?php echo get_phrase('project'); ?> :</strong> <br><?php echo $po['project_name']; ?></p>
                    <p class="mb-1"><strong><?php echo get_phrase('site'); ?> :</strong> <br><?php echo $po['site_name']; ?></p>
                </div>

                <!-- BLOC 2 : Détails du Fournisseur -->
                <div class="col-md-4 border-end">
                    <p class="text-muted mb-1 font-13"><?php echo get_phrase('supplier_details'); ?></p>
                    <p class="mb-1"><strong><?php echo get_phrase('name'); ?> :</strong> <br><?php echo !empty($po['supplier_name']) ? $po['supplier_name'] : '---'; ?></p>
                    <p class="mb-1"><strong><?php echo get_phrase('phone'); ?> :</strong> <br><?php echo !empty($po['supplier_phone']) ? $po['supplier_phone'] : '---'; ?></p>
                    <p class="mb-0"><strong><?php echo get_phrase('accepted_methods'); ?> :</strong></p>
                    <div class="mt-1">
                        <?php 
                        if(!empty($po['suggested_payment_methods'])):
                            $tags = explode(',', $po['suggested_payment_methods']);
                            foreach($tags as $t): ?>
                                <span class="badge badge-outline-secondary"><?php echo trim($t); ?></span>
                            <?php endforeach; 
                        else:
                            echo '<small class="text-muted italic">'.get_phrase('not_specified').'</small>';
                        endif;
                        ?>
                    </div>
                </div>

                <!-- BLOC 3 : Finance & Paiement -->
                <div class="col-md-4">
                    <p class="text-muted mb-1 font-13"><?php echo get_phrase('financial_summary'); ?></p>
                    <p class="mb-2">
                        <strong><?php echo get_phrase('total_amount'); ?> :</strong> <br>
                        <span class="badge badge-success-lighten" style="font-size: 16px;">
                            <?php echo number_format($po['total_amount'], 2); ?> MRU
                        </span>
                    </p>
                    
                    <p class="mb-1"><strong><?php echo get_phrase('payment_status'); ?> :</strong><br>
                        <?php if($po['status'] >= 6): ?>
                            <span class="text-success fw-bold"><i class="mdi mdi-check-decagram"></i> <?php echo get_phrase('paid_via'); ?> : <?php echo $po['payment_method']; ?></span>
                        <?php else: ?>
                            <span class="text-warning italic"><i class="mdi mdi-clock-outline"></i> <?php echo get_phrase('payment_pending'); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div> <!-- end row -->
        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div>

    <!-- SECTION 2 : WORKFLOW HISTORY (TIMELINE) -->
    <div class="col-12 mb-3">
        <div class="card border shadow-none">
            <div class="card-body">
                <h5 class="header-title text-success mb-3"><i class="mdi mdi-vector-point"></i> <?php echo get_phrase('purchase_workflow_tracking'); ?></h5>
                
                <?php 
                $steps = [
                    1 => ['title' => 'Request Initiated', 'role' => 'Storekeeper'],
                    2 => ['title' => 'Site Approval', 'role' => 'Site Manager'],
                    3 => ['title' => 'Procurement Verification', 'role' => 'Procurement'],
                    4 => ['title' => 'GM Signature', 'role' => 'General Manager'],
                    5 => ['title' => 'Purchasing & Invoicing', 'role' => 'Purchasing Agent'],
                    6 => ['title' => 'Payment Completed', 'role' => 'General Manager'],
                    7 => ['title' => 'Archived', 'role' => 'Accountant']
                ];

                foreach($steps as $step_num => $step_info): 
                    $is_done = ($po['status'] >= $step_num);
                    $step_doc = null;
                    if($step_num > 1 && $step_num < 7) {
                        foreach($docs as $d) {
                            if($d['doc_type'] == $doc_map[$step_num]) { $step_doc = $d; break; }
                        }
                    }
                ?>
                <div class="timeline-item border-start ps-3 pb-3" style="border-left: 2px solid <?php echo $is_done ? '#0acf97' : '#e3eaef'; ?> !important;">
                    <i class="mdi mdi-circle <?php echo $is_done ? 'text-success' : 'text-muted'; ?>" style="margin-left: -23px; background: #fff;"></i>
                    <p class="mb-0 fw-bold <?php echo $is_done ? 'text-dark' : 'text-muted'; ?>"><?php echo $step_num.'. '.get_phrase($step_info['title']); ?></p>
                    
                    <?php if($is_done): ?>
                        <small class="text-muted">
                            <?php 
                                if($step_num == 1) echo $po['requester_name'].' ('.ucfirst($po['requester_role']).') | '.date('d M Y, H:i', strtotime($po['created_at'])); 
                                elseif($step_doc) echo $step_doc['uploader_name'].' ('.ucfirst($step_doc['uploader_role']).') | '.date('d M Y, H:i', strtotime($step_doc['created_at']));
                                else echo get_phrase('system_validated');
                            ?>
                        </small>
                        <?php if($step_doc): ?>
                            <br><a href="<?php echo base_url($step_doc['file_path']); ?>" target="_blank" class="btn btn-link btn-sm p-0 text-info"><i class="mdi mdi-download"></i> <?php echo get_phrase('view_document'); ?></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <small class="text-muted italic"><?php echo get_phrase('pending'); ?>...</small>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- SECTION 3 : LISTE DES ARTICLES -->
    <div class="col-12 mb-3">
        <div class="card border shadow-none">
            <div class="card-body">
                <h5 class="header-title mb-2"><?php echo get_phrase('order_items'); ?></h5>
                <div class="table-responsive">
                    <table class="table table-sm table-centered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th><?php echo get_phrase('sku'); ?></th>
                                <th><?php echo get_phrase('product'); ?></th>
                                <th class="text-center"><?php echo get_phrase('qty'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $i): ?>
                            <tr>
                                <td><small><?php echo $i['sku']; ?></small></td>
                                <td><?php echo $i['name']; ?></td>
                                <td class="text-center"><strong><?php echo (int)$i['quantity']; ?></strong> <?php echo $i['unit']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4 : DOCUMENTS & PIÈCES JOINTES (IMAGES PREVIEW) -->
    <div class="col-12">
        <div class="card border shadow-none">
            <div class="card-body">
                <h5 class="header-title text-danger mb-3"><i class="mdi mdi-folder-image"></i> <?php echo get_phrase('all_attached_files'); ?></h5>
                <div class="row">
                    <?php foreach($docs as $d): 
                        $ext = strtolower(pathinfo($d['file_name'], PATHINFO_EXTENSION));
                        $is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                    ?>
                    <div class="col-12 mb-4 border-bottom pb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge badge-dark"><?php echo strtoupper(str_replace('_', ' ', $d['doc_type'])); ?></span>
                            <small class="text-muted"><?php echo $d['uploader_name']; ?> (<?php echo ucfirst($d['uploader_role']); ?>)</small>
                        </div>
                        
                        <?php if($is_image): ?>
                            <div class="text-center bg-light p-2 rounded">
                                <a href="<?php echo base_url($d['file_path']); ?>" target="_blank">
                                    <img src="<?php echo base_url($d['file_path']); ?>" class="img-fluid rounded border shadow-sm" style="max-height: 500px;">
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 bg-light rounded">
                                <i class="mdi mdi-file-pdf text-danger" style="font-size: 60px;"></i>
                                <p class="fw-bold mb-0"><?php echo $d['file_name']; ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php echo base_url($d['file_path']); ?>" download class="btn btn-secondary btn-sm w-100 mt-2">
                            <i class="mdi mdi-download"></i> <?php echo get_phrase('download'); ?>
                        </a>
                    </div>
                    <?php endforeach; ?>

                    <?php if(count($docs) == 0): ?>
                        <div class="col-12 text-center py-3 text-muted">
                            <i class="mdi mdi-folder-open-outline d-block" style="font-size: 40px;"></i>
                            <p><?php echo get_phrase('no_documents_uploaded_yet'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>