<?php
// 1. DATA PREPARATION
$user_id = $this->session->userdata('user_id');
$user_type = $this->session->userdata('user_type');
$lang    = get_settings('language'); // Check current language

// Get all projects
$projects = $this->db->where('status', 'active')
                     ->order_by("code = 'pilote'", "DESC")
                     ->get('projects')
                     ->result_array();
// Get Events (Standard functionality)
$events = $this->db->get_where('event_calendars')->result_array();

?>

<!-- CUSTOM CSS FOR PROJECT CARDS -->
<style>
    .project-card { 
        cursor: pointer; 
        transition: transform .15s ease, box-shadow .15s ease; 
        border: 1px solid #eef2f7;
        border-radius: 10px;
    }
    .project-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 8px 20px rgba(0,0,0,.08); 
    }
    .budget-text { font-size: 0.85rem; }
    .progress-sm { height: 8px; }
    
     .bg-pilote-card {
        background-color: #00A95C !important; /* Light blue background */
        /*border: 1.5px solid #727cf5 !important;  Slightly thicker primary border */
    }
    
    /* Optional: change text color for the title specifically on the pilote card */
    .bg-pilote-card .card-title {
        color: white;
        font-weight: bold;
    }
</style>

<!-- PAGE TITLE -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body py-2">
                <h4 class="page-title d-inline-block">
                    <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase($user_type.'_dashboard'); ?>
                </h4>
            </div> 
        </div> 
    </div>
</div>

<!-- TOP STATS CARDS (Standard) -->
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-lg-6">
                <div class="card widget-flat" style="border-left: 5px solid #00A95C;">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-briefcase-outline widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Projects"><?php echo get_phrase('total_projects'); ?></h5>
                        <h3 class="mt-3 mb-3"><?php echo count($projects)-1; ?></h3>
                        <p class="mb-0 text-muted">
                            <span class="text-nowrap"><?php echo get_phrase('active_development_projects'); ?></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card widget-flat" style="border-left: 5px solid #727cf5;">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-calendar widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Upcoming Events"><?php echo get_phrase('upcoming_events'); ?></h5>
                        <h3 class="mt-3 mb-3"><?php echo count($events); ?></h3>
                        <p class="mb-0 text-muted">
                            <span class="text-nowrap"><?php echo get_phrase('scheduled_meetings'); ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECTION: PROJECT FUNDING STATUS (From your HTML) -->
<div class="row">
    <div class="col-12">
        <h4 class="header-title mb-3 mt-2"><i class="mdi mdi-chart-bar"></i> <?php echo get_phrase('funding_progress'); ?></h4>
    </div>
    
    <?php foreach($projects as $row): 
        // 1. Existing Funding Calculations...
         $this->db->select_sum('amount');
        $this->db->where('project_id', $row['id']);
        $total_funded = $this->db->get('project_funding')->row()->amount;
        
        // 2. NEW: Get Donor Abbreviation + Total Percentage for this specific donor
        $this->db->select('donors.abbr, SUM(project_funding.percentage) as donor_share');
        $this->db->from('donors');
        $this->db->join('project_funding', 'donors.id = project_funding.donor_id');
        $this->db->where('project_funding.project_id', $row['id']);
        $this->db->group_by('donors.id'); // Group by donor to sum their specific shares
        $donor_tags = $this->db->get()->result_array();

        // 3. Existing Percentage/Color logic
        $percentage = ($row['budget'] > 0) ? number_format(($total_funded / $row['budget']) * 100, 1) : 0;
        
        $color_class = 'bg-danger'; 
        if($percentage > 30) $color_class = 'bg-warning';
        if($percentage > 70) $color_class = 'bg-success';

        $title = ($lang == 'arabic' && !empty($row['title_ar'])) ? $row['title_ar'] : $row['title'];
        $custom_card_class = ($row['code'] == 'pilote') ? 'bg-pilote-card' : '';
    ?>
    <div class="col-md-4">
    <div class="card project-card <?php echo $custom_card_class; ?>" onclick="location.href='<?php echo route('project/details/'.$row['id']); ?>'">
        <div class="card-body">
            <h4 class="card-title mb-2 text-truncate"><?= $title ?></h4>
            
            <?php if($row['code'] != 'pilote'): ?>
                <p class="budget-text text-muted mb-1">
                    <?php echo get_phrase('budget'); ?>: 
                    <strong><?php echo number_format($row['budget']); ?> <?php echo $row['currency']; ?></strong>
                </p>

                <!-- DONOR BADGES WITH PERCENTAGE -->
                <div class="mb-2" style="min-height: 22px; line-height: 1.8;">
                    <?php if(count($donor_tags) > 0): ?>
                        <?php foreach($donor_tags as $tag): ?>
                            <span class="badge badge-outline-primary" style="font-size: 10px; padding: 2px 6px;">
                                <?= $tag['abbr']; ?> 
                                <span class="fw-bold text-dark ml-1"><?= number_format($tag['donor_share'], 1); ?>%</span>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <small class="text-muted italic" style="font-size: 10px;"><?php echo get_phrase('no_donors_yet'); ?></small>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Pilote Card Specific Content -->
                <p class="budget-text card-title mb-3">
                    <strong><?php echo get_phrase("documents_and_general_discussions") ?></strong>
                </p>
            <?php endif; ?>

            <!-- Progress Bar -->
            <div class="progress progress-sm mb-2">
                <div class="progress-bar <?php echo $color_class; ?>" role="progressbar" style="width: <?php echo $percentage; ?>%"></div>
            </div>

            <!-- Footer Stats -->
            <div class="d-flex justify-content-between">
                <small class="text-muted"><?php echo get_phrase('total_funded'); ?>: <strong><?php echo $percentage; ?>%</strong></small>
                <small class="text-muted"><?php echo number_format($total_funded); ?> <?= $row['currency'] ?></small>
            </div>
        </div>
    </div>
</div>
 <?php endforeach; ?>
</div>

<!-- SECTION: EVENTS CALENDAR (Keeping original structure) -->
<div class="row">
   <div class="col-12 event_calendar_content">
      <?php include 'event_calendar/index.php'; ?>
   </div>
</div>
