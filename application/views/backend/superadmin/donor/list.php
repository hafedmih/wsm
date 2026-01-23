<?php
// 1. Build the Query with JOIN on user_id
$this->db->select('users.*, donors.name_ar, donors.contact_person, donors.website');
$this->db->from('users');
$this->db->join('donors', 'donors.user_id = users.id', 'left');
$this->db->where('users.role', 'donor');

// 2. Get Results
$query_data = $this->db->get();

if($query_data->num_rows() > 0):
    $users = $query_data->result_array();
?>

<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('donor_id'); ?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('name_ar'); ?></th>
            <th><?php echo get_phrase('status'); ?></th> <!-- NEW COLUMN -->
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user){ ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                
                <!-- English Name -->
                <td><?php echo $user['name']; ?></td>

                <!-- Arabic Name -->
                <td>
                    <?php echo !empty($user['name_ar']) ? $user['name_ar'] : '-'; ?>
                </td>

                <!-- NEW STATUS SWITCH -->
                <td>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="status_<?php echo $user['id']; ?>" 
                               onchange="updateUserStatus(<?php echo $user['id']; ?>)"
                               <?php echo ($user['status'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="status_<?php echo $user['id']; ?>">
                            <span class="badge badge-light-lighten" id="label_<?php echo $user['id']; ?>">
                                <?php echo ($user['status'] == 1) ? get_phrase('active') : get_phrase('inactive'); ?>
                            </span>
                        </label>
                    </div>
                </td>

                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/donor/edit/'.$user['id'])?>', '<?php echo get_phrase('update_donor'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('donor/delete/'.$user['id']); ?>', showAllParents )"><?php echo get_phrase('delete'); ?></a>
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
<script>
function updateUserStatus(userId) {
    // 1. Get current state (checked = 1, unchecked = 0)
    var status = $('#status_' + userId).is(':checked') ? 1 : 0;
    
    // 2. Send AJAX Request
    $.ajax({
        url: '<?php echo route('donor/update_status/'); ?>' + userId + '/' + status,
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
                // Warning Notification
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