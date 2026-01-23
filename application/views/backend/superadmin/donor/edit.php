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