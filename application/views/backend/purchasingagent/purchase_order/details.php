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

    // 2. Articles commandés (Support Custom Names)
    $this->db->select('purchase_order_items.*, inventory.name as inventory_name, inventory.sku, inventory.unit');
    $this->db->from('purchase_order_items');
    $this->db->join('inventory', 'inventory.id = purchase_order_items.inventory_id', 'left');
    $this->db->where('purchase_order_items.purchase_order_id', $po_id);
    $items = $this->db->get()->result_array();

    // 3. Documents du Workflow
    $docs = $this->db->select('purchase_order_docs.*, users.name as uploader_name, users.role as uploader_role')
                     ->join('users', 'users.id = purchase_order_docs.uploaded_by')
                     ->get_where('purchase_order_docs', ['purchase_order_id' => $po_id])->result_array();

    // Mapping mis à jour avec l'étape 7
    $doc_map = [
        2 => 'site_signed_doc',
        3 => 'procurement_signed_doc',
        4 => 'gm_signed_doc',
        5 => 'invoice_doc',
        6 => 'payment_doc',
        7 => 'archived_log' 
    ];
?>

<div class="row">
    <!-- SECTION 1 : INFORMATIONS GÉNÉRALES -->
    <div class="col-12 mb-3">
        <div class="card border shadow-none">
            <div class="card-body">
                <h5 class="header-title text-primary mb-2"><i class="mdi mdi-information-outline"></i> <?php echo get_phrase('po_general_information'); ?></h5>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong><?php echo get_phrase('po_code'); ?> :</strong> <span class="badge badge-dark-lighten"><?php echo $po['code']; ?></span></p>
                        <p class="mb-1"><strong><?php echo get_phrase('project'); ?> :</strong> <?php echo $po['project_name']; ?></p>
                        <p class="mb-1"><strong><?php echo get_phrase('site'); ?> :</strong> <?php echo $po['site_name']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong><?php echo get_phrase('payment_method'); ?> :</strong> <?php echo !empty($po['payment_method']) ? $po['payment_method'] : 'N/A'; ?></p>
                        <p class="mb-1"><strong><?php echo get_phrase('total_amount'); ?> :</strong> <span class="text-success fw-bold"><?php echo number_format($po['total_amount'], 2); ?> MRU</span></p>
                    </div>
                </div>
            </div>
        </div>
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
                    if($step_num > 1) {
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
                                if($step_num == 1) {
                                    echo $po['requester_name'].' ('.ucfirst($po['requester_role']).') | '.date('d M Y, H:i', strtotime($po['created_at'])); 
                                } elseif($step_doc) {
                                    // Affiche maintenant la date réelle d'archivage (Step 7) ou de signature
                                    echo $step_doc['uploader_name'].' ('.ucfirst($step_doc['uploader_role']).') | '.date('d M Y, H:i', strtotime($step_doc['created_at']));
                                } else {
                                    echo get_phrase('system_validated');
                                }
                            ?>
                        </small>
                        <?php if($step_doc && $step_doc['file_path'] != 'N/A'): ?>
                            <br><a href="<?php echo base_url($step_doc['file_path']); ?>?v=<?php echo time(); ?>" target="_blank" class="btn btn-link btn-sm p-0 text-info"><i class="mdi mdi-download"></i> <?php echo get_phrase('view_document'); ?></a>
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
                                <th class="text-end"><?php echo get_phrase('unit_price'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $i): ?>
                            <tr>
                                <td><small><?php echo !empty($i['sku']) ? $i['sku'] : '<span class="text-muted">N/A</span>'; ?></small></td>
                                <td>
                                    <?php 
                                        if(!empty($i['inventory_id'])) { echo $i['inventory_name']; } 
                                        else { echo '<strong>' . $i['custom_item_name'] . '</strong> <span class="badge badge-info-lighten">' . get_phrase('custom') . '</span>'; }
                                    ?>
                                </td>
                                <td class="text-center"><strong><?php echo (int)$i['quantity']; ?></strong> <?php echo $i['unit']; ?></td>
                                <td class="text-end"><?php echo number_format($i['unit_price'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- SECTION 4 : DOCUMENTS & PIÈCES JOINTES -->
<div class="col-12">
    <div class="card border shadow-none">
        <div class="card-body">
            <h5 class="header-title text-danger mb-3"><i class="mdi mdi-folder-image"></i> <?php echo get_phrase('all_attached_files'); ?></h5>
            <div class="row">
                <?php 
                $displayed_paths = []; 
                
                // 1. On trie les documents par ID DESC (le plus récent en premier)
                // Cela garantit que pour le PDF commun, on tombe sur le GM ou Procurement avant le Storekeeper
                usort($docs, function($a, $b) {
                    return $b['id'] - $a['id'];
                });

                foreach($docs as $d): 
                    // SKIP : On ignore l'étape 7 (Archivage) et les logs sans fichiers
                    if ($d['doc_type'] == 'archived_log' || $d['file_path'] == 'N/A') continue;
                    
                    // DÉDUPLICATION : Si le chemin du fichier (ex: PO_15_Final.pdf) a déjà été traité, 
                    // on l'ignore. Comme on a trié par ID DESC, le premier qu'on croise est le DERNIER signataire.
                    if (in_array($d['file_path'], $displayed_paths)) continue;
                    $displayed_paths[] = $d['file_path'];

                    $ext = strtolower(pathinfo($d['file_name'], PATHINFO_EXTENSION));
                    $is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                ?>
                <div class="col-12 mb-4 border-bottom pb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge badge-dark">
                            <?php 
                                // Libellé propre selon le type
                                if(strpos($d['doc_type'], 'signed_doc') !== false || $d['doc_type'] == 'step1_request') {
                                    echo get_phrase('official_purchase_order_pdf'); 
                                } elseif($d['doc_type'] == 'invoice_doc') {
                                    echo get_phrase('supplier_invoice');
                                } elseif($d['doc_type'] == 'payment_doc') {
                                    echo get_phrase('payment_proof');
                                } else {
                                    echo strtoupper(str_replace('_', ' ', $d['doc_type'])); 
                                }
                            ?>
                        </span>
                        
                        <!-- ICI : Affichera bien le GM ou le dernier signataire réel -->
                        <small class="text-muted">
                            <strong><?php echo get_phrase('latest_update_by'); ?>:</strong> 
                            <?php echo $d['uploader_name']; ?> (<?php echo ucfirst($d['uploader_role']); ?>)
                        </small>
                    </div>
                    
                    <?php if($is_image): ?>
                        <div class="text-center bg-light p-2 rounded">
                            <a href="<?php echo base_url($d['file_path']); ?>?v=<?php echo time(); ?>" target="_blank">
                                <img src="<?php echo base_url($d['file_path']); ?>?v=<?php echo time(); ?>" class="img-fluid rounded border shadow-sm" style="max-height: 500px;">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 bg-light rounded border">
                            <i class="mdi mdi-file-pdf text-danger" style="font-size: 60px;"></i>
                            <p class="fw-bold mb-0"><?php echo $d['file_name']; ?></p>
                            <small class="text-success fw-bold">
                                <i class="mdi mdi-check-decagram"></i> <?php echo get_phrase('certified_version_with_all_signatures'); ?>
                            </small>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row mt-2">
                        <div class="col-12">
                            <a href="<?php echo base_url($d['file_path']); ?>?v=<?php echo time(); ?>" download class="btn btn-secondary btn-sm w-100">
                                <i class="mdi mdi-download"></i> <?php echo get_phrase('download_this_document'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php 
                // Vérification si aucun fichier physique n'est présent
                $has_physical_file = false;
                foreach($docs as $doc) { if($doc['file_path'] != 'N/A') { $has_physical_file = true; break; } }
                
                if(!$has_physical_file): ?>
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