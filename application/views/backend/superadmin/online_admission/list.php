<?php
$this->db->select('users.*, donors.abbr as donor_abbr, ministries.abbr as ministry_abbr');
$this->db->from('users');
$this->db->join('donors', 'users.school_id = donors.id AND users.role = "donor"', 'left');
$this->db->join('ministries', 'users.school_id = ministries.id AND users.role = "admin"', 'left');
$this->db->where('users.status', 0);
$this->db->where_in('users.role', array('donor', 'admin'));

$pending_users = $this->db->get()->result_array(); // This returns an array
?>

<?php if(count($pending_users) > 0): // Use count() for arrays ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
  <thead>
    <tr style="background-color: #313a46; color: #ababab;">
      <th><?php echo get_phrase('name'); ?></th>
      <th><?php echo get_phrase('email'); ?></th>
      <th><?php echo get_phrase('institution'); ?></th>
      <th><?php echo get_phrase('department_title'); ?></th>
       
      <th><?php echo get_phrase('options'); ?></th>
     
    </tr>
  </thead>
  <tbody>
    <?php foreach($pending_users as $donor): // Removed ->result_array() here as it is already an array ?>
      <tr>
        <td>
          <span class="fw-bold"><?php echo $donor['name']; ?></span>
          <br>
          <small class="text-muted"><i class="mdi mdi-clock-outline"></i> <?php echo get_phrase('pending_approval'); ?></small>
        </td>
        <td><?php echo $donor['email']; ?></td>
       <td>
    <?php if($donor['role'] == 'donor'): // Fixed: changed $user to $donor ?>
        <span class="badge badge-info-lighten"><?php echo !empty($donor['donor_abbr']) ? $donor['donor_abbr'] : '-'; ?> (<?php echo get_phrase('donor'); ?>)</span>
    <?php elseif($donor['role'] == 'admin'): // Fixed: changed $user to $donor ?>
        <span class="badge badge-secondary-lighten"><?php echo !empty($donor['ministry_abbr']) ? $donor['ministry_abbr'] : '-'; ?> (<?php echo get_phrase('admin'); ?>)</span>
    <?php endif; ?>
</td>
<td><?php echo $donor['address']; ?></td>
       
        
        
        <td>
          <div class="dropdown text-center">
            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
            <div class="dropdown-menu dropdown-menu-end">
              
              <!-- APPROVE ACTION -->
              <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('donor/approve/'.$donor['id']); ?>', showAllData)">
                 <i class="mdi mdi-check-circle me-1 text-success"></i> <?php echo get_phrase('approve_account'); ?>
              </a>

              <!-- REJECT / DELETE ACTION -->
              <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmModal('<?php echo route('donor/delete/'.$donor['id']); ?>', showAllData)">
                <i class="mdi mdi-delete me-1 text-danger"></i> <?php echo get_phrase('reject_request'); ?>
              </a>

            </div>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>