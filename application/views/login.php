<?php
$current_language = get_settings('language');
$text_direction = ($current_language == 'arabic') ? 'rtl' : 'ltr';
$donor_list = $this->db->get('donors')->result_array();
$ministries_list = $this->db->get('ministries')->result_array();
?>
<!DOCTYPE html>
<html dir="<?php echo $text_direction; ?>" lang="<?php echo ($current_language == 'arabic') ? 'ar' : 'en'; ?>">

<head
    <meta charset="utf-8" />
    <title><?php echo get_phrase('login'); ?> | <?php echo get_settings('system_name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
    
    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/backend/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/app.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    
    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jquery-3.6.0.min.js"></script>
    
    <style>
        .auth-fluid-form-box { max-width: 480px; width: 100%; }
        /* Custom Font for Arabic */
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        body[lang="ar"] { font-family: 'Cairo', sans-serif; }
    </style>
</head>

<body class="auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">
                    
                    <!-- =============================================================== -->
                    <!-- LOGO & LANGUAGE SWITCHER -->
                    <!-- =============================================================== -->
                    <div class="text-center mb-4">
                        <a href="<?php echo site_url(); ?>">
                            <span style="display: inline-block; line-height: 0; ">
                                <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="" style="max-width: 100%; height: auto;">
                            </span>
                        </a>
                        
                        <!-- Language Buttons -->
<!--                        <div class="mt-2">
                            <?php if($current_language == 'english'): ?>
                                <a href="<?php echo site_url('login/change_language/arabic'); ?>" class="btn btn-sm btn-outline-secondary btn-rounded" style="font-family: 'Cairo', sans-serif;">
                                    <i class="mdi mdi-web"></i> العربية
                                </a>
                            <?php else: ?>
                                <a href="<?php echo site_url('login/change_language/english'); ?>" class="btn btn-sm btn-outline-secondary btn-rounded">
                                    <i class="mdi mdi-web"></i> English
                                </a>
                            <?php endif; ?>
                        </div>-->
                    </div>

                    <!-- =============================================================== -->
                    <!-- STATIC ALERTS (Success/Error Messages) -->
                    <!-- =============================================================== -->
                    <?php if($this->session->flashdata('flash_message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 5px solid #00A95C;">
                            <i class="mdi mdi-check-circle-outline me-2"></i>
                            <strong><?php echo get_phrase('success'); ?>: </strong>
                            <?php echo $this->session->flashdata('flash_message'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($this->session->flashdata('error_message')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 5px solid #fa5c7c;">
                            <i class="mdi mdi-alert-outline me-2"></i>
                            <strong><?php echo get_phrase('error'); ?>: </strong>
                            <?php echo $this->session->flashdata('error_message'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>


                    <!-- =============================================================== -->
                    <!-- 1. LOGIN FORM BLOCK -->
                    <!-- =============================================================== -->
                    <div id="loginBlock">
                        <h4 class="mt-0 text-center"><?php echo get_phrase('sign_in'); ?></h4>
                        <p class="text-muted mb-4 text-center"><?php echo get_phrase('enter_your_email_address_and_password_to_access_account'); ?>.</p>

                        <form action="<?php echo site_url('login/validate_login'); ?>" method="post">
                            <div class="form-group mb-3">
                                <label for="emailaddress"><?php echo get_phrase('email'); ?></label>
                                <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="<?php echo get_phrase('enter_your_email'); ?>">
                            </div>
                            <div class="form-group mb-3">
                                <a href="javascript: void(0);" class="text-muted float-end" onclick="showForgot();"><small><?php echo get_phrase('forgot_your_password'); ?>?</small></a>
                                <label for="password"><?php echo get_phrase('password'); ?></label>
                                <input class="form-control" type="password" name="password" required="" id="password" placeholder="<?php echo get_phrase('enter_your_password'); ?>">
                            </div>
                            <div class="form-group mb-3 mb-0 text-center">
                                <button class="btn btn-primary btn-block w-100" type="submit"><i class="mdi mdi-login"></i> <?php echo get_phrase('log_in'); ?> </button>
                            </div>
                        </form>
                        
                        <!-- Registration Links -->
<!--                        <div class="text-center mt-4">
                            <p class="text-muted mb-1">
                                <?php echo get_phrase('want_to_become_a_partner'); ?>? 
                                <a href="javascript: void(0);" onclick="showRegisterDonor();" class="text-primary fw-bold ms-1"><?php echo get_phrase('register_as_donor'); ?></a>
                            </p>
                            <p class="text-muted">
                                <?php echo get_phrase('are_you_a_ministry_official'); ?>? 
                                <a href="javascript: void(0);" onclick="showRegisterMinistry();" class="text-secondary fw-bold ms-1"><?php echo get_phrase('register_as_ministry'); ?></a>
                            </p>
                        </div>-->
                    </div>

                    <!-- =============================================================== -->
                    <!-- 2. FORGOT PASSWORD BLOCK -->
                    <!-- =============================================================== -->
                    <div id="forgotBlock" style="display: none;">
                        <h4 class="mt-0 text-center"><?php echo get_phrase('reset_password'); ?></h4>
                        <p class="text-muted mb-4 text-center"><?php echo get_phrase('enter_your_email_to_receive_reset_link'); ?>.</p>

                        <form action="<?php echo site_url('login/retrieve_password'); ?>" method="post">
                            <div class="form-group mb-3">
                                <label for="forgotEmail"><?php echo get_phrase('email'); ?></label>
                                <input class="form-control" type="email" name="email" required="" id="forgotEmail" placeholder="<?php echo get_phrase('enter_your_email'); ?>">
                            </div>
                            <div class="form-group mb-3 mb-0 text-center">
                                <button class="btn btn-primary btn-block w-100" type="submit"><i class="mdi mdi-email-send"></i> <?php echo get_phrase('sent_password_reset_link'); ?> </button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="javascript: void(0);" onclick="showLogin();" class="text-muted"><i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back_to_login'); ?></a>
                        </div>
                    </div>

                    <!-- =============================================================== -->
                    <!-- 3. DONOR REGISTRATION BLOCK -->
                    <!-- =============================================================== -->
 <!-- =============================================================== -->
<!-- 3. DONOR REGISTRATION BLOCK (UPDATED) -->
<!-- =============================================================== -->
<div id="registerDonorBlock" style="display: none;">
    <h4 class="mt-0 text-center"><?php echo get_phrase('donor_registration'); ?></h4>
    <p class="text-muted mb-3 text-center"><?php echo get_phrase('fill_form_to_join_as_partner'); ?>.</p>

    <form action="<?php echo site_url('home/register_donor'); ?>" method="post">
        
        <!-- Name -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('full_name'); ?></label>
            <input class="form-control" type="text" name="name" required placeholder="<?php echo get_phrase('enter_your_name'); ?>">
        </div>
        
        <!-- Email -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('email'); ?></label>
            <input class="form-control" type="email" name="email" required placeholder="<?php echo get_phrase('enter_your_email'); ?>">
        </div>

        <!-- Phone -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('phone'); ?></label>
            <input class="form-control" type="text" name="phone" required placeholder="<?php echo get_phrase('enter_your_phone_number'); ?>">
        </div>

        <!-- Institution Selection (Posts as school_id) -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('institution'); ?></label>
            <select class="form-control" name="school_id" required>
                <option value=""><?php echo get_phrase('select_your_institution'); ?></option>
                <?php foreach($donor_list as $donor): ?>
                    <option value="<?php echo $donor['id']; ?>">
                        <?php 
                            echo ($current_language == 'arabic' && !empty($donor['name_ar'])) ? $donor['name_ar'] : $donor['name']; 
                        ?>
                        <?php  echo "(".$donor['abbr'].")"; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Address Field -->
         <div class="form-group mb-3">
                                <label><?php echo get_phrase('department_title'); ?></label>
                                <input class="form-control" type="text" name="address" required placeholder="<?php echo get_phrase('eg_director'); ?>">
                            </div>

        <!-- Password -->
        <div class="form-group mb-3">
            <label><?php echo get_phrase('password'); ?></label>
            <input class="form-control" type="password" name="password" required placeholder="<?php echo get_phrase('create_a_password'); ?>">
        </div>

        <div class="form-group mb-3 mb-0 text-center">
            <button class="btn btn-success btn-block w-100" type="submit">
                <i class="mdi mdi-account-plus"></i> <?php echo get_phrase('submit_application'); ?> 
            </button>
        </div>
    </form>
    
    <div class="text-center mt-3">
        <a href="javascript: void(0);" onclick="showLogin();" class="text-muted">
            <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('already_have_an_account'); ?>
        </a>
    </div>
</div>
                   <!-- =============================================================== -->
<!-- 4. MINISTRY REGISTRATION BLOCK (UPDATED) -->
<!-- =============================================================== -->
<div id="registerMinistryBlock" style="display: none;">
    <h4 class="mt-0 text-center"><?php echo get_phrase('ministry_registration'); ?></h4>
    <p class="text-muted mb-3 text-center"><?php echo get_phrase('official_ministry_account_request'); ?>.</p>

    <form action="<?php echo site_url('home/register_ministry'); ?>" method="post">
        
        <!-- Full Name -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('full_name'); ?></label>
            <input class="form-control" type="text" name="name" required placeholder="<?php echo get_phrase('enter_your_name'); ?>">
        </div>
        
        <!-- Ministry Email -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('ministry_email'); ?></label>
            <input class="form-control" type="email" name="email" required placeholder="name@gov.mr">
        </div>

        <!-- Phone -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('phone'); ?></label>
            <input class="form-control" type="text" name="phone" required placeholder="<?php echo get_phrase('phone'); ?>">
        </div>

        <!-- NEW: Ministry Selection (Posts as school_id) -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('ministry'); ?></label>
            <select class="form-control" name="school_id" required>
                <option value=""><?php echo get_phrase('select_your_ministry'); ?></option>
                <?php foreach($ministries_list as $min): ?>
                    <option value="<?php echo $min['id']; ?>">
                        <?php 
                            // Display Arabic name if current language is Arabic
                            echo ($current_language == 'arabic' && !empty($min['name_ar'])) ? $min['name_ar'] : $min['name']; 
                        ?>
                        <?php if(!empty($min['abbr'])): ?> (<?php echo $min['abbr']; ?>)<?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Department Title (Post as address) -->
        <div class="form-group mb-2">
            <label><?php echo get_phrase('department_title'); ?></label>
            <input class="form-control" type="text" name="address" required placeholder="<?php echo get_phrase('e.g._director_of_planning'); ?>">
        </div>

        <!-- Password -->
        <div class="form-group mb-3">
            <label><?php echo get_phrase('password'); ?></label>
            <input class="form-control" type="password" name="password" required placeholder="<?php echo get_phrase('create_a_password'); ?>">
        </div>

        <div class="form-group mb-3 mb-0 text-center">
            <button class="btn btn-info btn-block w-100" type="submit">
                <i class="mdi mdi-bank"></i> <?php echo get_phrase('request_account'); ?> 
            </button>
        </div>
    </form>
    
    <div class="text-center mt-3">
        <a href="javascript: void(0);" onclick="showLogin();" class="text-muted">
            <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('already_have_an_account'); ?>
        </a>
    </div>
</div>
                    <!-- VERSION FOOTER -->
                    <div class="text-center mt-4">
                        <small class="text-muted" style="font-family: monospace;">
                            v<?php echo defined('SYSTEM_VERSION') ? SYSTEM_VERSION : '1.0.0'; ?>
                        </small>
                    </div>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
    </div>

    <!-- App js -->
    <script src="<?php echo base_url(); ?>assets/backend/js/app.min.js"></script>
    
    <!-- Standard Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
    // ----------------------------------------------------
    // TOGGLE FUNCTIONS
    // ----------------------------------------------------
    function hideAll() {
        $('#loginBlock, #forgotBlock, #registerDonorBlock, #registerMinistryBlock').hide();
    }

    function showForgot(){
        hideAll();
        $('#forgotBlock').fadeIn();
    }

    function showRegisterDonor(){
        hideAll();
        $('#registerDonorBlock').fadeIn();
    }

    function showRegisterMinistry(){
        hideAll();
        $('#registerMinistryBlock').fadeIn();
    }

    function showLogin(){
        hideAll();
        $('#loginBlock').fadeIn();
    }

    // ----------------------------------------------------
    // TOASTR CONFIGURATION
    // ----------------------------------------------------
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    </script>

    <!-- ---------------------------------------------------- -->
    <!-- SERVER NOTIFICATIONS (PHP to JS) -->
    <!-- ---------------------------------------------------- -->
    <?php if ($this->session->flashdata('info_message') != ""):?>
        <script>toastr.info('<?php echo $this->session->flashdata("info_message");?>');</script>
    <?php endif;?>

    <?php if ($this->session->flashdata('error_message') != ""):?>
        <script>toastr.error('<?php echo $this->session->flashdata("error_message");?>');</script>
    <?php endif;?>

    <?php if ($this->session->flashdata('flash_message') != ""):?>
        <script>toastr.success('<?php echo $this->session->flashdata("flash_message");?>');</script>
    <?php endif;?>

</body>
</html>