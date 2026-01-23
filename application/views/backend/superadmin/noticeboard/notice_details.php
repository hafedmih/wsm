<?php
    // 1. Get the ID directly from the URL segment (3rd part of the URL)
    // Example: domain.com/superadmin/notice_details/5 -> the ID is 5
    $notice_id = $this->uri->segment(3);

    // 2. Execute the query inside the view
    $notice = $this->db->get_where('noticeboard', array('id' => $notice_id))->row_array();

    // 3. Check if notice exists, if not show error
    if (!$notice) {
        echo '<div class="alert alert-danger">'.get_phrase('notice_not_found').'</div>';
        return;
    }
?>

<!-- UI CONTENT -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-calendar-clock title_icon"></i> <?php echo get_phrase('notice_details'); ?>
                    <a href="<?php echo route('noticeboard'); ?>" class="btn btn-outline-primary btn-rounded align-middle float-end">
                        <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back'); ?>
                    </a>
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <!-- 1. Notice Title -->
                <h3 class="mt-0 text-primary"><?php echo $notice['notice_title']; ?></h3>
                
                <!-- 2. Date -->
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted">
                        <i class="mdi mdi-calendar-range"></i> 
                        <strong><?php echo get_phrase('date'); ?>:</strong> 
                        <?php echo date('D, d M Y', strtotime($notice['date'])); ?>
                    </span>
                </div>

                <!-- 3. Notice Content -->
                <div class="notice-content">
                    <p style="white-space: pre-line; line-height: 1.8; color: #333; font-size: 1.1rem;">
                        <?php echo $notice['notice']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>