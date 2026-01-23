<!--title-->
<div class="row d-print-none">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body py-2">
                <h4 class="page-title d-inline-block">
                    <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('online_admission'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row d-print-none">
    <div class="col-12">
        <div class="card ">
            <div class="card-body pending_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>
<script>
    var showAllData = function () {
        var url = '<?php echo route('donor/pending_list'); ?>';

        // 1. Update the Sidebar Badge Count
        // We call a small internal function to fetch the updated count
        refreshBadgeCount();

        if ($.fn.DataTable.isDataTable('#basic-datatable')) {
            $('#basic-datatable').DataTable().destroy();
        }

        $('.pending_content').html('<div class="text-center p-3"><div class="spinner-border text-primary"></div></div>');

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.pending_content').html(response);
                if (typeof initDataTable !== 'undefined') {
                    initDataTable('basic-datatable');
                } else {
                    $('#basic-datatable').DataTable();
                }
            }
        });
    }

    // New helper function to sync the sidebar badge
    function refreshBadgeCount() {
        // You can either create a new controller route just for the count 
        // OR simply hide the badge if the list becomes empty.
        // For now, let's fetch it from a simple helper if you have one, 
        // or just calculate based on table rows remaining.
        
        // Alternative: If your confirmModal/ajaxSubmit returns the JSON, 
        // the count is already in the 'response'. 
        // Since confirmModal usually handles the alert, we can just do a quick get:
        $.get('<?php echo site_url('superadmin/get_pending_registration_count'); ?>', function(count) {
            if(parseInt(count) > 0) {
                $('#pending-registration-badge').text(count).show();
            } else {
                $('#pending-registration-badge').hide();
            }
        });
    }
</script>