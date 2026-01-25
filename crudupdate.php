superadmin/donor
index.php
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title d-inline-block">
          <i class="mdi mdi-account-circle title_icon"></i> <?php echo get_phrase('donors'); ?>
        </h4>
        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle float-end mt-1" onclick="rightModal('<?php echo site_url('modal/popup/donor/create'); ?>', '<?php echo get_phrase('create_donor'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_donor'); ?></button>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body parent_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>


<script>
var showAllParents = function () {
  var url = '<?php echo route('donor/list'); ?>';

  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.parent_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>

===========
list.php
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
============
create.php
<form method="POST" class="d-block ajaxForm" action="<?php echo route('donor/create'); ?>">
    <div class="form-row">
        <div class="form-group mb-1">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_name'); ?></small>
        </div>
        
        
        
        <div class="form-group mb-1">
            <label for="name_ar"><?php echo get_phrase('name_ar'); ?></label>
            <input type="text" class="form-control" id="name_ar" name = "name_ar" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_name_ar'); ?></small>
        </div>
        <div class="form-group mb-1">
            <label for="contact_person"><?php echo get_phrase('contact_person'); ?></label>
            <input type="text" class="form-control" id="contact_person" name = "contact_person" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_contact_person'); ?></small>
        </div>
        <div class="form-group mb-1">
            <label for="website"><?php echo get_phrase('website'); ?></label>
            <input type="text" class="form-control" id="website" name = "website" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_website'); ?></small>
        </div>

        <div class="form-group mb-1">
            <label for="email"><?php echo get_phrase('email'); ?></label>
            <input type="email" class="form-control" id="email" name = "email" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_email'); ?></small>
        </div>

        <div class="form-group mb-1">
            <label for="password"><?php echo get_phrase('password'); ?></label>
            <input type="password" class="form-control" id="password" name = "password" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_password'); ?></small>
        </div>

        <div class="form-group mb-1">
            <label for="phone"><?php echo get_phrase('phone'); ?></label>
            <input type="text" class="form-control" id="phone" name = "phone" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_phone_number'); ?></small>
        </div>

        
       
        <div class="form-group mb-1">
            <label for="address"><?php echo get_phrase('address'); ?></label>
            <textarea class="form-control" id="address" name = "address" rows="5" required></textarea>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_address'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_donor'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
    $('select.select2:not(.normal)').each(function () { $(this).select2({ dropdownParent: '#right-modal' }); }); //initSelect2(['#gender', '#blood_group']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllParents);
});
</script>

===============
edit.php
<?php
// 1. We need to fetch data from BOTH 'users' and 'donors' tables
$this->db->select('users.*, donors.name_ar, donors.contact_person');
$this->db->from('users');
$this->db->join('donors', 'donors.user_id = users.id', 'left'); // Link them via ID
$this->db->where('users.id', $param1);
$users = $this->db->get()->result_array();

foreach($users as $user){
    ?>
    <form method="POST" class="d-block ajaxForm" action="<?php echo route('donor/update/'.$param1); ?>">
        <div class="form-row">
            
            <!-- English Name -->
            <div class="form-group mb-1">
                <label for="name"><?php echo get_phrase('name'); ?> (English)</label>
                <input type="text" value="<?php echo $user['name']; ?>" class="form-control" id="name" name="name" required>
                <small class="form-text text-muted"><?php echo get_phrase('provide_name'); ?></small>
            </div>

            <!-- Arabic Name (New) -->
            <div class="form-group mb-1">
                <label for="name_ar"><?php echo get_phrase('name_ar'); ?> (Arabic)</label>
                <input type="text" value="<?php echo $user['name_ar']; ?>" class="form-control" id="name_ar" name="name_ar" dir="rtl">
                <small class="form-text text-muted"><?php echo get_phrase('provide_arabic_name'); ?></small>
            </div>

            <!-- Contact Person (New) -->
            <div class="form-group mb-1">
                <label for="contact_person"><?php echo get_phrase('contact_person'); ?></label>
                <input type="text" value="<?php echo $user['contact_person']; ?>" class="form-control" id="contact_person" name="contact_person">
                <small class="form-text text-muted"><?php echo get_phrase('provide_contact_person_name'); ?></small>
            </div>

            <div class="form-group mb-1">
                <label for="email"><?php echo get_phrase('email'); ?></label>
                <input type="email" value="<?php echo $user['email']; ?>" class="form-control" id="email" name="email" required>
                <small class="form-text text-muted"><?php echo get_phrase('provide_email'); ?></small>
            </div>

            <div class="form-group mb-1">
                <label for="phone"><?php echo get_phrase('phone'); ?></label>
                <input type="text" value="<?php echo $user['phone']; ?>" class="form-control" id="phone" name="phone" required>
                <small class="form-text text-muted"><?php echo get_phrase('provide_phone_number'); ?></small>
            </div>

            <div class="form-group mb-1">
                <label for="address"><?php echo get_phrase('address'); ?></label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $user['address']; ?></textarea>
                <small class="form-text text-muted"><?php echo get_phrase('provide_address'); ?></small>
            </div>

            <div class="form-group col-md-12">
                <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_donor'); ?></button>
            </div>
        </div>
    </form>
<?php } ?>

<script>
$(document).ready(function () {
    $('select.select2:not(.normal)').each(function () { $(this).select2({ dropdownParent: '#right-modal' }); });
});
$(".ajaxForm").validate({}); 
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    // Ensure 'showAllData' matches the function name in your index.php
    ajaxSubmit(e, form, showAllParents); 
});
</script>
===========
controller superadmin.php
public function donor($param1 = '', $param2 = '',$param3=''){

    if($param1 == 'create'){
      $response = $this->user_model->donor_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->donor_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->donor_delete($param2);
      echo $response;
    }
      if($param1 == 'approve'){
        $user_id = $param2;
        
        // 1. Update User Status to 1 (Active)
        $this->db->where('id', $user_id);
        $this->db->update('users', array('status' => 1));

        // 2. Fetch User Data to send email
        $user = $this->db->get_where('users', array('id' => $user_id))->row_array();

        if(!empty($user)) {
            $this->load->model('email_model');
            // Call the new function (defined below)
            
            $this->email_model->account_approved_email($user['email'], $user['name']);
        }
        $new_count = $this->db->where('status', 0)
                          ->where_in('role', array('donor', 'admin'))
                          ->count_all_results('users');

        echo json_encode(array(
        'status' => true,
        'notification' => get_phrase('account_approved_successfully'),
        'new_count' => $new_count // Include this in the response
    ));
       // redirect(site_url('superadmin/online_admission'), 'refresh');
    }
    if ($param1 == 'pending_list') {
        $this->load->view('backend/superadmin/online_admission/list');
        return; // <--- CRITICAL: YOU MUST STOP EXECUTION HERE
    }
     if($param1 == 'update_status'){
        $user_id = $param2;
        $status  = $param3;

        $this->db->where('id', $user_id);
        $this->db->update('users', array('status' => $status));
        
        echo '1'; // Success
        return; // Stop execution
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/donor/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'donor';
      $page_data['page_title'] = 'donor';
      $this->load->view('backend/index', $page_data);
    }
  }
  