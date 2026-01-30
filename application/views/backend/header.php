<?php
$this->load->database();
$user_id = $this->session->userdata('user_id');

// Notifications Logic
$this->db->select('notice_id, user_id');
$this->db->where('user_id', $user_id);
$notification_data = $this->db->get('notifications')->result_array();
$notice_ids = array_column($notification_data, 'notice_id');

$notices = [];
if (!empty($notice_ids)) {
    $this->db->where_in('id', $notice_ids);
    $this->db->order_by('id', 'DESC');
    $notices = $this->db->get('noticeboard')->result();
}

$current_language = get_settings('language');
$is_rtl = ($current_language == 'arabic');
// 2-letter display for space saving on mobile
$display_lang = $is_rtl ? 'AR' : 'EN'; 
?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<style>
    .signature-component { border: 1px solid #ccc; width: 100%; height: 200px; background: #fff; }
    canvas { width: 100%; height: 100%; }
</style>
<style>
    /* 1. TOPBAR HEIGHT & LAYOUT */
    
    .navbar-custom {
        height: 75px !important;
        /*background-color: #00A95C !important;*/
        padding: 0 !important;
        overflow: visible !important; /* Prevents profile photo clipping */
    }

    .custom-header-container {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        height: 75px !important;
        width: 100%;
        /* Responsive Padding: 80px for desktop, 15px for mobile */
        padding: 0 80px !important; 
    }

    .topbar-left-side {
        display: flex;
        align-items: center;
    }

    .topbar-right-side {
        display: flex !important;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        height: 100%;
    }

    /* 2. LOGO FIX */
    .topnav-logo {
        display: flex;
        align-items: center;
        height: 75px;
    }
    .topnav-logo img {
        max-height: 80px !important;
        width: auto;
    }

    /* 3. PROFILE PHOTO FIX */
    .nav-user {
        background: transparent !important;
        border: none !important;
        padding: 0 10px !important;
        display: flex !important;
        align-items: center !important;
        height: 75px !important;
        line-height: normal !important;
    }

    .account-user-avatar img {
        width: 42px !important;
        height: 42px !important;
        min-width: 42px;
        min-height: 42px;
        border-radius: 50% !important;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.8);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* 4. LANGUAGE & ICONS */
    .lang-code-text {
        font-weight: 700;
        font-size: 14px;
        margin: 0 5px;
        color: #000 !important;
    }
    .noti-icon {
        color: #fff !important;
        font-size: 22px;
    }

    /* 5. MOBILE MENU BUTTON (Hamburger) */
    .button-menu-mobile {
        border: none;
        color: #fff;
        display: inline-block;
        font-size: 24px;
        height: 75px;
        line-height: 75px;
        width: 45px;
        background-color: transparent;
        cursor: pointer;
        order: <?php echo $is_rtl ? '2' : '0'; ?>;
    }

    /* 6. MOBILE OVERRIDES - THE FIX */
    @media (max-width: 767px) {
        .custom-header-container {
            padding: 0 60px !important; /* Fixed the "hidden" issue by reducing padding */
        }
        .account-user-name, .account-position { 
            display: none !important; 
        }
        .nav-user {
            padding: 0 5px !important;
        }
        .topnav-logo img {
            max-height: 35px !important; /* Smaller logo for mobile */
        }
        .lang-code-text {
            font-size: 12px;
        }
        .app-search h4 {
        font-size: 16px; /* Smaller font for mobile abbreviation */
        margin-left: 10px;
        margin-right: 10px;
    }
    }

    .delete-notice { display: none; }
    .notify-item:hover .delete-notice { display: inline-block; }
    
/* Fix mobile padding so items don't hide */
@media (max-width: 767px) {
    .custom-header-container { padding: 0 50px !important; }
    .desktop-title { display: none !important; }
    .mobile-title { display: inline-block !important; font-size: 14px; }
}

/* Desktop behavior */
@media (min-width: 768px) {
    .desktop-title { display: inline-block !important; }
    .mobile-title { display: none !important; }
}

.platform-title-box {
    flex-grow: 1;
    text-align: center;
}
.platform-title-box h4 { margin: 0; color: #000; font-weight: 700; }
</style>

<!-- Topbar Start -->
<div class="navbar-custom topnav-navbar" style="direction: <?php echo $is_rtl ? 'rtl' : 'ltr'; ?>;">
    <div class="container-fluid custom-header-container">

        <!-- LEFT SIDE: Hamburger + Logo -->
        <div class="topbar-left-side" style="order: 0;">
            <button class="button-menu-mobile disable-btn">
                <i class="mdi mdi-menu"></i>
            </button>
            
            <a href="<?php echo site_url($this->session->userdata('role')); ?>" class="topnav-logo">
                <span class="topnav-logo-lg">
                    <img src="<?php echo $this->settings_model->get_logo_light(); ?>" width="80" alt="logo">
                </span>
                <span class="topnav-logo-sm">
                    <img src="<?php echo $this->settings_model->get_logo_light('small'); ?>" alt="logo">
                </span>
            </a>
        </div>

        <!-- RIGHT SIDE: Language, Notifications, Profile -->
        <ul class="topbar-right-side" style="order: 1;">
            
            <!-- LANGUAGE SWITCHER -->
            <?php if (in_array($this->session->userdata('user_type'), ['superadmin', 'donor', 'admin'])): ?>
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" onclick="getLanguageList()">
                    <i class="mdi mdi-translate noti-icon"></i>
                    <span class="lang-code-text"><?php echo $display_lang; ?></span>
                </a>
                <div class="dropdown-menu <?php echo $is_rtl ? 'dropdown-menu-start' : 'dropdown-menu-end'; ?> dropdown-menu-animated dropdown-lg">
                    <div class="slimscroll" id="language-list" style="min-height: 150px;"></div>
                </div>
            </li>
            <?php endif; ?>

            <!-- NOTIFICATIONS -->
            <?php if ($this->session->userdata('user_type') != 'superadmin1'): ?>
            <?php
                $unread_count = $this->db->where(['user_id' => $user_id, 'status' => 'unread'])->count_all_results('notifications');
            ?>
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none position-relative" data-bs-toggle="dropdown" href="#" role="button" onclick="markAsRead(<?php echo $user_id; ?>)">
                    <i class="mdi mdi-bell-outline noti-icon"></i>
                    <?php if ($unread_count > 0): ?>
                        <span class="position-absolute badge rounded-pill bg-danger" style="top: 20px; right: 2px; font-size: 10px;">
                            <?php echo $unread_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
                <div class="dropdown-menu <?php echo $is_rtl ? 'dropdown-menu-start' : 'dropdown-menu-end'; ?> dropdown-menu-animated profile-dropdown" style="min-width: 280px;">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo get_phrase('Notification'); ?>!</h6>
                    </div>
                    <?php if (!empty($notices)): ?>
                        <?php foreach ($notices as $notice): ?>
                            <div class="dropdown-item notify-item d-flex align-items-start" id="notice-<?php echo $notice->id; ?>">
                                <div class="w-100">
                                    <a href="<?php echo site_url('home/notice_details/'.$notice->id);?>" class="font-weight-bold d-block">
                                        <?php echo (strlen($notice->notice_title) > 25) ? substr($notice->notice_title, 0, 25) . '...' : $notice->notice_title; ?>
                                    </a>
                                </div>
                                <button class="btn btn-sm text-danger delete-notice" data-notice-id="<?php echo $notice->id; ?>">
                                    <i class="mdi mdi-close"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted p-2"><?php echo get_phrase('no_notices_available'); ?></p>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>

            <!-- USER PROFILE -->
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button">
                    <span class="account-user-avatar">
                        <img src="<?php echo $this->user_model->get_user_image($user_id); ?>" alt="user">
                    </span>
                </a>
                <div class="dropdown-menu <?php echo $is_rtl ? 'dropdown-menu-start' : 'dropdown-menu-end'; ?> dropdown-menu-animated profile-dropdown">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo get_phrase('welcome'); ?>!</h6>
                    </div>
                    <a href="<?php echo route('profile'); ?>" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span><?php echo get_phrase('my_account'); ?></span>
                    </a>
                    <a href="<?php echo site_url('login/logout'); ?>" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span><?php echo get_phrase('logout'); ?></span>
                    </a>
                </div>
            </li>
        </ul>
        <div class="platform-title-box">
    <!-- Desktop Title -->
    <h4 class="desktop-title">
        <?php echo get_phrase('sign_in'); ?>
    </h4>

    <!-- Mobile Abbreviation -->
    <h4 class="mobile-title">
        <?php 
            $short_name = get_phrase('short_name'); 
            echo !empty($short_name) ? $short_name : 'PLAT'; 
        ?>
    </h4>
</div>
</div>
    </div>
</div>

<script type="text/javascript">
function getLanguageList() {
    $.ajax({
        url: "<?php echo route('language/dropdown'); ?>",
        success: function(response){ $('#language-list').html(response); }
    });
}
function markAsRead(user_id) {
    $.ajax({
        url: "<?php echo site_url('home/mark_as_read'); ?>",
        type: "POST",
        data: { user_id: user_id },
        success: function(response) { $(".badge.bg-danger").fadeOut(); }
    });
}
$(document).on('click', '.delete-notice', function(e) {
    e.stopPropagation(); e.preventDefault();
    var noticeId = $(this).data('notice-id');
    $.ajax({
        url: "<?php echo base_url('home/delete_notification'); ?>",
        type: "POST",
        data: { notice_id: noticeId },
        success: function(response) {
            if (response == "success") { $("#notice-" + noticeId).remove(); }
        }
    });
});
</script>