<?php
// 1. Get Project ID (Assuming param1 is passed from the controller)
$project_id = $id;

// 2. Get Project Details
$project = $this->db->get_where('projects', array('id' => $project_id))->row_array();

// 3. Get Funding List with JOIN to Donors
$this->db->select('project_funding.*, donors.name as donor_name, donors.name_ar as donor_name_ar');
$this->db->from('project_funding');
$this->db->join('donors', 'donors.id = project_funding.donor_id', 'left');
$this->db->where('project_funding.project_id', $project_id);
$funding_list = $this->db->get()->result_array();

// 4. Calculate Total Funded
$total_funded = 0;
foreach($funding_list as $fund) {
    $total_funded += $fund['amount'];
}
$remaining_budget = $project['budget'] - $total_funded;

// 5. Check Language
$current_language = get_settings('language'); // Or however you get language in your system
?>

<?php if (count($funding_list) > 0 || !empty($project)): ?>
    
    <!-- SUMMARY BOX -->
    <div class="row mb-4">
        <div class="col-md-2"></div>
        <div class="col-md-8 toll-free-box text-center text-white pb-2" style="background-color: #00A95C; border-radius: 10px;">
            <h4 class="text-white"><?php echo get_phrase('project_funding_details'); ?></h4>
            
            <div class="row text-start mt-2">
                <div class="col-md-6" style="padding-left: 30px;">
                    <strong><?php echo get_phrase('project'); ?> :</strong> <?php echo ($current_language == 'arabic' && !empty($project['title_ar'])) ? $project['title_ar'] : $project['title']; ?><br>
                    <strong><?php echo get_phrase('code'); ?> :</strong> <?php echo $project['code']; ?>
                </div>
                <div class="col-md-6">
                     <strong><?php echo get_phrase('total_budget'); ?> :</strong> <?php echo number_format($project['budget'], 2); ?> <?php echo $project['currency']; ?><br>
                     <strong><?php echo get_phrase('total_funded'); ?> :</strong> <?php echo number_format($total_funded, 2); ?> <br>
                     <strong><?php echo get_phrase('remaining'); ?> :</strong> 
                     <span class="<?php echo ($remaining_budget < 0) ? 'text-danger' : 'text-warning'; ?>">
                        <?php echo number_format($remaining_budget, 2); ?>
                     </span>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <!-- ADD BUTTON -->
    <div class="row mb-2">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-primary btn-sm" onclick="rightModal('<?php echo site_url('modal/popup/funding/create/'.$project_id); ?>', '<?php echo get_phrase('add_funding'); ?>')">
                <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_funding'); ?>
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('donor'); ?></th>
                <th><?php echo get_phrase('amount'); ?></th>
                <th><?php echo get_phrase('percentage'); ?></th>
                <th><?php echo get_phrase('type'); ?></th>
                <th><?php echo get_phrase('date'); ?></th>
                <th><?php echo get_phrase('options'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funding_list as $row): 
                // Determine Name based on Language
                $donor_display_name = $row['donor_name'];
                if ($current_language == 'arabic' && !empty($row['donor_name_ar'])) {
                    $donor_display_name = $row['donor_name_ar'];
                }
            ?>
                <tr>
                    <td><strong><?php echo $donor_display_name; ?></strong></td>
                    
                    <td><?php echo number_format($row['amount'], 2); ?></td>
                    
                    <td>
                        <div class="progress" style="height: 20px; position:relative;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $row['percentage']; ?>%;" aria-valuenow="<?php echo $row['percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <span style="position:absolute; left:0; right:0; text-align:center; color:black; line-height:20px; font-size:12px;">
                                <?php echo $row['percentage']; ?>%
                            </span>
                        </div>
                    </td>
                    
                    <td><span class="badge badge-info-lighten"><?php echo get_phrase($row['funding_type']); ?></span></td>
                    
                    <td><?php echo $row['agreement_date']; ?></td>
                    
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- Edit -->
                                <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/project_funding/edit/'.$row['id']); ?>', '<?php echo get_phrase('update_funding'); ?>');">
                                    <?php echo get_phrase('edit'); ?>
                                </a>
                                <!-- Delete -->
                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('funding/delete/'.$row['id']); ?>', showAllData )">
                                    <?php echo get_phrase('delete'); ?>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    
    <!-- Empty State but keep the Add Button -->
    <div class="text-center">
        <?php include APPPATH . 'views/backend/empty.php'; ?>
        <button type="button" class="btn btn-primary mt-3" onclick="rightModal('<?php echo site_url('modal/popup/funding/create/'.$project_id); ?>', '<?php echo get_phrase('add_funding'); ?>')">
            <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_first_funding'); ?>
        </button>
    </div>

<?php endif; ?>