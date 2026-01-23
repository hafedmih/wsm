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
