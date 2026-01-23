<!-- Title and Back Button -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body py-2">
                <h4 class="page-title d-inline-block">
                    <i class="mdi mdi-currency-usd title_icon"></i> <?php echo get_phrase('project_funding'); ?>
                </h4>
                <!-- Back to Projects List -->
                <a href="<?php echo route('project'); ?>" class="btn btn-outline-secondary btn-rounded alignToTitle float-end mt-1 me-1"> 
                    <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back_to_projects'); ?>
                </a>
            </div> 
        </div> 
    </div>
</div>

<!-- Content Area where list.php will be loaded -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body funding_content">
                <?php include APPPATH . 'views/backend/empty.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // This is the function the Modal calls after success!
    var showAllData = function () {
        // We get the Project ID passed from the controller ($id)
        var project_id = '<?php echo $id; ?>'; 
        var url = '<?php echo route('funding/list/'); ?>' + project_id;

        // Show loading state
        $('.funding_content').html('<div class="text-center p-5"><span class="spinner-border"></span></div>');

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.funding_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }

    // Load the list immediately when page opens
    $(document).ready(function() {
        showAllData();
    });
</script>