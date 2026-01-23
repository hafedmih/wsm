<!-- App css -->
<?php 
    $current_language = get_settings('language'); 
    // Define the suffix: if Arabic, use '-rtl', otherwise empty string
    $rtl_suffix = ($current_language == 'arabic') ? '-rtl' : '';
?>

<link href="<?php echo base_url(); ?>assets/backend/css/icons.min.css" rel="stylesheet" type="text/css" />

<!-- The -rtl suffix is added dynamically here -->
<link href="<?php echo base_url(); ?>assets/backend/css/app-modern<?php echo $rtl_suffix; ?>.min.css" rel="stylesheet" type="text/css" id="light-style" />
<link href="<?php echo base_url(); ?>assets/backend/css/app-modern-dark<?php echo $rtl_suffix; ?>.min.css" rel="stylesheet" type="text/css" id="dark-style" />

<!-- App css End-->

<!-- third party css -->
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/summernote-bs4.css" rel="stylesheet" type="text/css" />
<!-- third party css end -->

<link href="<?php echo base_url(); ?>assets/backend/css/custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/backend/css/content-placeholder.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jquery-3.6.0.min.js"></script>