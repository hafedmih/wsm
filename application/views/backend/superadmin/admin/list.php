<?php
$school_id = school_id();
$check_data = $this->db->get_where('users', array('role' => 'admin'));
if($check_data->num_rows() > 0):?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('email'); ?></th>
            <th><?php echo get_phrase('status'); ?></th> <!-- NEW COLUMN -->
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $admins = $this->db->get_where('users', array('role' => 'admin'))->result_array();
        foreach($admins as $admin){
            ?>
            <tr>
                <td><?php echo $admin['name']; ?></td>
                <td><?php echo $admin['email']; ?></td>
                
                <!-- NEW STATUS SWITCH -->
                <td>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="status_<?php echo $admin['id']; ?>" 
                               onchange="updateUserStatus(<?php echo $admin['id']; ?>)"
                               <?php echo ($admin['status'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="status_<?php echo $admin['id']; ?>">
                            <span class="badge badge-light-lighten" id="label_<?php echo $admin['id']; ?>">
                                <?php echo ($admin['status'] == 1) ? get_phrase('active') : get_phrase('inactive'); ?>
                            </span>
                        </label>
                    </div>
                </td>

                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/admin/edit/'.$admin['id']); ?>', '<?php echo get_phrase('update_admin'); ?>')"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('admin/delete/'.$admin['id']); ?>', showAllAdmins )"><?php echo get_phrase('delete'); ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<!-- AJAX SCRIPT TO UPDATE STATUS -->
<!-- AJAX SCRIPT TO UPDATE STATUS -->
<script>
function updateUserStatus(userId) {
    // 1. Get current state (checked = 1, unchecked = 0)
    var status = $('#status_' + userId).is(':checked') ? 1 : 0;
    
    // 2. Send AJAX Request
    $.ajax({
        url: '<?php echo route('admin/update_status/'); ?>' + userId + '/' + status,
        success: function(response) {
            // 3. Notification & UI Update using $.NotificationApp
            if(status == 1) {
                // Success Notification
                $.NotificationApp.send(
                    "<?php echo get_phrase('success'); ?>!", 
                    "<?php echo get_phrase('user_activated_successfully'); ?>", 
                    "top-right", 
                    "rgba(0,0,0,0.2)", 
                    "success"
                );
                $('#label_' + userId).text('<?php echo get_phrase('active'); ?>');
            } else {
                // Warning/Heads up Notification
                $.NotificationApp.send(
                    "<?php echo get_phrase('heads_up'); ?>!", 
                    "<?php echo get_phrase('user_deactivated_successfully'); ?>", 
                    "top-right", 
                    "rgba(0,0,0,0.2)", 
                    "warning"
                );
                $('#label_' + userId).text('<?php echo get_phrase('inactive'); ?>');
            }
        },
        error: function() {
            // Error Notification
            $.NotificationApp.send(
                "<?php echo get_phrase('oh_snap'); ?>!", 
                "<?php echo get_phrase('error_updating_status'); ?>", 
                "top-right", 
                "rgba(0,0,0,0.2)", 
                "error"
            );
        }
    });
}
</script>