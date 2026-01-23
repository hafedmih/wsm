<?php
// ==============================================================================================
// 1. DATA PREPARATION & LOGIC
// ==============================================================================================
$user_id = $this->session->userdata('user_id');
$role    = $this->session->userdata('role');
$lang    = get_settings('language');

// A. FETCH FUNDING LIST (JOINED WITH DONORS)
// We fetch the detailed list here to use for BOTH the calculation and the Table display
$this->db->select('project_funding.*, donors.name as donor_name, donors.name_ar as donor_name_ar');
$this->db->from('project_funding');
$this->db->join('donors', 'donors.id = project_funding.donor_id', 'left');
$this->db->where('project_funding.project_id', $project['id']);
$funding_list = $this->db->get()->result_array();

// B. CALCULATE TOTALS
$total_funded = 0;
foreach($funding_list as $f) { 
    $total_funded += $f['amount']; 
}

$percentage = 0;
if($project['budget'] > 0) {
    $percentage = ($total_funded / $project['budget']) * 100;
}
$percentage = number_format($percentage, 1);
$remaining_budget = $project['budget'] - $total_funded;

// C. FETCH DOCUMENTS
$documents = $this->db->get_where('project_documents', ['project_id' => $project['id']])->result_array();

// D. FETCH COMMENTS
$comments_tree = $this->user_model->get_comments_tree('project', $project['id']);

// E. FETCH UPCOMING MEETINGS
//$events = $this->db->order_by('starting_date', 'ASC')
//                   ->get_where('event_calendars', 3)
//                   ->result_array();
$project_ids= $project['id'];
if (!empty($project_ids)) {
    $today = date('Y-m-d');
    $this->db->where('school_id', $project_ids);
   // $this->db->where('starting_date >=', date('Y-m-d 00:00:00')); // From today onwards
    $this->db->where("STR_TO_DATE(starting_date, '%m/%d/%Y') >=", $today);
    $this->db->order_by('starting_date', 'ASC');
    $events = $this->db->get('event_calendars')->result_array();
} else {
    $events = [];
}
// F. DYNAMIC TITLES
$project_title = ($lang == 'arabic' && !empty($project['title_ar'])) ? $project['title_ar'] : $project['title'];
$project_desc  = ($lang == 'arabic' && !empty($project['description_ar'])) ? $project['description_ar'] : $project['description'];

// ==============================================================================================
// 2. STYLING
// ==============================================================================================
?>
<style>
    /* Reuse previous styles */
    .section-title { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #6c757d; border-bottom: 1px solid #eee; padding-bottom: 5px; }
    .comment-box { background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #eef2f7; margin-bottom: 15px; }
    .reply-box { margin-left: 40px; background-color: #fafbfd; border: 1px solid #e0e0e0; font-size: 0.95rem; }
    .comment-admin { border-left: 4px solid #0d6efd; }
    .comment-donor { border-left: 4px solid #00A95C; }
    .comment-ministry { border-left: 4px solid #ffc107; }
    .reply-btn { font-size: 12px; cursor: pointer; color: #00A95C; font-weight: bold; float: right; }
    .hidden-reply-form { display: none; margin-top: 15px; }
    .comments-container { max-height: 500px; overflow-y: auto; padding-right: 5px; }
    .file-icon { font-size: 1.4rem; vertical-align: middle; margin-right: 8px; }
</style>

<div class="container-fluid p-0">

    <!-- ============================================================================================== -->
    <!-- 3. HEADER CARD (Overall Summary) -->
    <!-- ============================================================================================== -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                 <?php if($project['code'] != 'pilote'): ?>
                   
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-primary">️ <?= $project_title; ?></h3>
                            <span class="badge badge-outline-secondary"><?php echo get_phrase('code'); ?>: <?= $project['code']; ?></span>
                        </div>
                        <?php if($percentage >= 100): ?>
                            <span class="badge bg-success p-2"><?php echo get_phrase('fully_funded'); ?></span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark p-2"><?php echo get_phrase('funding_in_progress'); ?></span>
                        <?php endif; ?>
                    </div>
                   

                    <hr />

                    <div class="row text-center text-md-start">
                        <div class="col-md-3">
                            <p class="mb-0 text-muted"><?php echo get_phrase('initial_budget'); ?></p>
                            <h3 class="mt-0"><?= number_format($project['budget']); ?> <small class="text-muted fs-6"><?= $project['currency'] ?></small></h3>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0 text-muted"><?php echo get_phrase('total_funded'); ?></p>
                            <h3 class="mt-0"><?= number_format($total_funded); ?> <small class="text-muted fs-6"><?= $project['currency'] ?></small></h3>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0 text-muted"><?php echo get_phrase('remaining_gap'); ?></p>
                            <h3 class="mt-0 <?php echo ($remaining_budget < 0) ? 'text-danger' : 'text-secondary'; ?>">
                                <?= number_format($remaining_budget); ?> <small class="text-muted fs-6"><?= $project['currency'] ?></small>
                            </h3>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0 text-muted"><?php echo get_phrase('progress'); ?></p>
                            <div class="progress mt-2" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percentage; ?>%"></div>
                            </div>
                            <small class="fw-bold"><?= $percentage; ?>%</small>
                        </div>
                    </div>
                </div>
                 <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============================================================================================== -->
    <!-- 4. FUNDING BREAKDOWN TABLE (New Section) -->
    <!-- ============================================================================================== -->
     <?php if($project['code'] != 'pilote'): ?>
                   
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title"><i class="mdi mdi-cash-multiple"></i> <?php echo get_phrase('funding_breakdown'); ?></h4>
                        <!-- Add Funding Button -->
                        <button type="button" class="btn btn-primary btn-sm" onclick="rightModal('<?php echo site_url('modal/popup/funding/create/'.$project['id']); ?>', '<?php echo get_phrase('add_funding'); ?>')">
                            <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_funding'); ?>
                        </button>
                    </div>

                    <?php if (count($funding_list) > 0): ?>
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th><?php echo get_phrase('donor'); ?></th>
                                        <th><?php echo get_phrase('amount'); ?></th>
                                        <th><?php echo get_phrase('percentage'); ?></th>
                                        <th><?php echo get_phrase('type'); ?></th>
                                        <th><?php echo get_phrase('agreement_date'); ?></th>
                                        <th><?php echo get_phrase('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($funding_list as $row): 
                                        $donor_display_name = $row['donor_name'];
                                        if ($lang == 'arabic' && !empty($row['donor_name_ar'])) {
                                            $donor_display_name = $row['donor_name_ar'];
                                        }
                                    ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $donor_display_name; ?></td>
                                            <td><?php echo number_format($row['amount'], 2); ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2"><?php echo $row['percentage']; ?>%</span>
                                                    <div class="progress flex-grow-1" style="height: 6px; width: 50px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $row['percentage']; ?>%;"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-info-lighten"><?php echo get_phrase($row['funding_type']); ?></span></td>
                                            <td><?php echo $row['agreement_date']; ?></td>
                                            <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                                
                                <!-- Delete -->
                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('funding/delete/'.$row['id']); ?>' )">
                                    <?php echo get_phrase('delete'); ?>
                                </a>
                            </div>
                        </div>
                    </td>
                                          
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light text-center" role="alert">
                            <i class="mdi mdi-alert-circle-outline me-2"></i> <?php echo get_phrase('no_funding_records_found'); ?>. 
                            <a href="javascript:void(0);" class="fw-bold" onclick="rightModal('<?php echo site_url('modal/popup/project_funding/create/'.$project['id']); ?>', '<?php echo get_phrase('add_funding'); ?>')"><?php echo get_phrase('add_the_first_record'); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
     <?php endif; ?>

    <div class="row g-4">
        <!-- ============================================================================================== -->
        <!-- LEFT COLUMN (Documents & Comments) -->
        <!-- ============================================================================================== -->
        <div class="col-lg-8">
            <!-- DOCUMENTS -->
        <!-- DOCUMENTS SECTION -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        
        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
            <div class="section-title mb-0 border-bottom-0 p-0">📎 <?php echo get_phrase('project_documents'); ?></div>
            
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" 
                onclick="rightModal('<?php echo site_url('modal/popup/project/create_document/'.$project['id']); ?>', '<?php echo get_phrase('upload_document'); ?>')">
                <i class="mdi mdi-upload"></i> <?php echo get_phrase('upload'); ?>
            </button>
        </div>
        
        <!-- Documents List -->
        <?php if(count($documents) > 0): ?>
            <div class="list-group list-group-flush">
                <?php foreach($documents as $doc): 
                    // 1. FETCH AUTHOR DETAILS
                    $uploader_id = $doc['uploaded_by'];
                    $user = $this->db->get_where('users', array('id' => $uploader_id))->row_array();
                    
                    // Always show Name (Address)
                    $author_name = $user['name'];
                    $job_title = !empty($user['address']) ? " (".$user['address'].")" : "";
                    
                    $tag = "";
                    $badge_color = "secondary"; // Default

                    if ($user['role'] == 'superadmin') {
                        $tag = "SA";
                        $badge_color = "dark";
                    } 
                    elseif ($user['role'] == 'admin') {
                        $ministry = $this->db->get_where('ministries', array('id' => $user['school_id']))->row_array();
                        $tag = !empty($ministry['abbr']) ? $ministry['abbr'] : "Admin";
                        $badge_color = "success";
                    } 
                    elseif ($user['role'] == 'donor') {
                        $donor = $this->db->get_where('donors', array('id' => $user['school_id']))->row_array();
                        $tag = !empty($donor['abbr']) ? $donor['abbr'] : "Donor";
                        $badge_color = "info";
                    }

                    // 2. FILE ICON LOGIC
                    $ext = strtolower(pathinfo($doc['file_name'], PATHINFO_EXTENSION));
                    $icon = 'mdi-file-outline';
                    $color_class = 'text-secondary';
                    if($ext == 'pdf') { $icon = 'mdi-file-pdf-box'; $color_class = 'text-danger'; }
                    elseif(in_array($ext, ['xls', 'xlsx', 'csv'])) { $icon = 'mdi-file-excel-box'; $color_class = 'text-success'; }
                    elseif(in_array($ext, ['doc', 'docx'])) { $icon = 'mdi-file-word-box'; $color_class = 'text-primary'; }
                    elseif(in_array($ext, ['jpg', 'jpeg', 'png'])) { $icon = 'mdi-file-image'; $color_class = 'text-warning'; }
                ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center overflow-hidden">
                            <!-- File Icon -->
                            <i class="mdi <?= $icon; ?> <?= $color_class; ?> fs-3 me-2"></i>
                            
                            <div>
                                <!-- File Title -->
                                <span class="fw-bold d-block text-truncate" style="max-width: 300px;" title="<?= $doc['title']; ?>">
                                    <?= $doc['title']; ?>
                                </span>
                                
                                <!-- Author Detail Line -->
                                <small class="text-muted d-block" style="font-size: 11px;">
                                    <i class="mdi mdi-account-circle-outline"></i> 
                                    <span class="fw-medium text-dark"><?= $author_name; ?></span><?= $job_title; ?>
                                    
                                    <?php if($tag): ?>
                                        <span class="badge badge-<?= $badge_color ?>-lighten text-<?= $badge_color ?> ms-1" style="font-size: 9px; padding: 1px 4px;">
                                            <?= $tag; ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <span class="ms-1 text-uppercase">• <?= $ext; ?></span>
                                </small>
                            </div>
                        </div>
                        
                        <!-- Download Button -->
                        <a href="<?= base_url('uploads/project_documents/'.$project['id'].'/'.$doc['file_name']); ?>" class="btn btn-light btn-sm ms-2" download target="_blank">
                            <i class="mdi mdi-download"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center p-4 bg-light rounded" style="border: 2px dashed #e0e0e0;">
                <i class="mdi mdi-folder-open-outline fs-1 text-muted"></i>
                <p class="text-muted mb-0"><?php echo get_phrase('no_documents_uploaded_yet'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
            <!-- COMMENTS -->
    <div class="card shadow-sm">
    <div class="card-body">
        <div class="section-title">💬 <?php echo get_phrase('discussion_forum'); ?></div>
        
        <!-- Target container for AJAX refresh -->
        <div id="comments_section_content" class="comments-container">
            <?php include 'comment_list.php'; ?>
        </div>

        <hr>
        <h5 class="mb-2"><?php echo get_phrase('leave_a_comment'); ?></h5>
        <form class="comment-ajax-form" action="<?= route('project/add_comment/project/'.$project['id']); ?>" method="POST">
            <input type="hidden" name="parent_id" value="0">
            <textarea name="message" class="form-control mb-2" rows="3" required></textarea>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4"><?php echo get_phrase('post_comment'); ?></button>
            </div>
        </form>
    </div>
</div>
        </div>

        <!-- ============================================================================================== -->
        <!-- RIGHT COLUMN (Meetings & Description) -->
        <!-- ============================================================================================== -->
        <div class="col-lg-4">
            <!-- MEETINGS -->
           <div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="section-title mb-3">📅 <?php echo get_phrase('upcoming_meetings'); ?></div>
        <?php if(count($events) > 0): ?>
            <ul class="list-unstyled">
                <?php foreach($events as $event): ?>
                    <li class="mb-3 border-bottom pb-2">
                        <div class="d-flex align-items-start">
                            <!-- Date Box -->
                            <div class="me-2 text-center bg-light p-2 rounded" style="min-width: 55px;">
                                <span class="d-block fw-bold text-primary" style="font-size: 1.1rem;">
                                    <?= date('d', strtotime($event['starting_date'])); ?>
                                </span>
                                <small class="d-block text-uppercase" style="font-size: 10px;">
                                    <?= date('M', strtotime($event['starting_date'])); ?>
                                </small>
                            </div>
                            
                            <!-- Event Details -->
                            <div class="w-100">
                                <h5 class="mt-0 mb-1 font-14"><?= $event['title']; ?></h5>
                                
                                <!-- Location -->
                                <?php if(!empty($event['location'])): ?>
                                    <small class="text-muted d-block mb-1">
                                        <i class="mdi mdi-map-marker text-danger"></i> <?= $event['location']; ?>
                                    </small>
                                <?php endif; ?>

                                <!-- Meeting Link -->
                                <?php if(!empty($event['link'])): ?>
                                    <div class="mt-1">
                                        <a href="<?= $event['link']; ?>" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11px; border-radius: 12px;">
                                            <i class="mdi mdi-video"></i> <?php echo get_phrase('join_meeting'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-3">
                <i class="mdi mdi-calendar-blank h3 text-muted"></i>
                <p class="text-muted small"><?php echo get_phrase('no_upcoming_meetings_scheduled'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

            <!-- DESCRIPTION -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="section-title">🏛️ <?php echo get_phrase('official_observations'); ?></div>
                    <p class="mb-2 fw-bold text-dark"><?php echo get_phrase('ministry_note'); ?>:</p>
                    <div class="text-muted" style="text-align: justify; font-size: 0.9rem;">
                        <?= (!empty($project_desc)) ? nl2br($project_desc) : '<span class="text-muted font-italic">'.get_phrase('no_additional_observations').'</span>'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// The refresh function similar to your showAllData
var refreshComments = function () {
    var url = "<?php echo route('project/comment_list/'.$project['id']); ?>";
    $.get(url, function(response){
        $('#comments_section_content').html(response);
    });
}

$(document).on('submit', '.comment-ajax-form, .hidden-reply-form form', function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.status) {
                //success_notify(response.message); // Your existing function
                form[0].reset();
                refreshComments(); // Re-load only the list file
            } else {
                error_notify(response.message);
            }
        }
    });
});
function toggleReplyForm(commentId) {
    $('.hidden-reply-form').slideUp();
    var form = $('#reply-form-' + commentId);
    if (form.is(':visible')) { form.slideUp(); } else { form.slideDown(); form.find('textarea').focus(); }
}
</script>