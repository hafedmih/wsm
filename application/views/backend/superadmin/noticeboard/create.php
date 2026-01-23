<?php
  if(isset($param1) && !empty($param1)){
    $timestamp = strtotime($param1);
  }else{
    $timestamp = strtotime(date('m/d/Y'));
  }
 ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('noticeboard/create'); ?>">
  <div class="form-row">

    <div class="form-group mb-1">
      <label for="notice_title"><?php echo get_phrase('notice_title'); ?></label>
      <input type="text" class="form-control" id="notice_title" name = "notice_title" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_title_name'); ?></small>
    </div>
    <div class="form-group mb-1">
      <label for="date"><?php echo get_phrase('date'); ?></label>
      <input type="text" value="<?php echo date('m/d/Y', $timestamp); ?>" class="form-control" id="date" name = "date" data-provide = "datepicker" required>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_date'); ?></small>
    </div>

    <div class="form-group mb-1">
      <label for="notice"><?php echo get_phrase('notice'); ?></label>
      <textarea name="notice" class="form-control" rows="8" cols="80" required></textarea>
      <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_notice_details'); ?></small>
    </div>

    <div class="form-group mb-1">
        <label for="send_to"><?php echo get_phrase('send_to'); ?></label>
        <select name="send_to" id="send_to" class="form-control select2"  onchange="is_selected_user(this)" data-toggle = "select2">
            
            <option value="users"><?php echo get_phrase('users'); ?></option>
            <option value="admin"><?php echo get_phrase('admin'); ?></option>
            <option value="student"><?php echo get_phrase('student'); ?></option>
            <option value="parent"><?php echo get_phrase('parent'); ?></option>
            <option value="teacher"><?php echo get_phrase('teacher'); ?></option>
            <option value="selected_user"><?php echo get_phrase('selected_user'); ?></option>
            
        </select>
        <small id="" class="form-text text-muted"><?php echo get_phrase('send_to'); ?></small>
    </div>

    <div class="form-group mb-1" id="select_newsletter_user" style="display: none;">
          <div class="dropdown">
              <input type="text" id="search" class="form-control" placeholder="Search users...">
              <ul class="dropdown-menu" id="user-results" style="display: none;"></ul>
          </div>
    </div>
    <input type="hidden" name="user_ids" id="selected_user_ids">


    <div class="form-group mb-1">
        <label for="show_on_website"><?php echo get_phrase('show_on_website'); ?></label>
        <select name="show_on_website" id="show_on_website" class="form-control select2" data-toggle = "select2">
            <option value="1"><?php echo get_phrase('show'); ?></option>
            <option value="0"><?php echo get_phrase('do_not_need_to_show'); ?></option>
        </select>
        <small id="" class="form-text text-muted"><?php echo get_phrase('notice_status'); ?></small>
    </div>

    <div class="form-group mb-1 d-inline-block">
      <style type="text/css">.file-upload-input{width: 260px !important;}</style>
        <label for="notice_photo"><?php echo get_phrase('upload_notice_photo'); ?></label>
        <input type="file" class="form-control" id="notice_photo" name = "notice_photo">
    </div>

    <div class="form-group  col-md-12">
      <button class="btn btn-primary" type="submit"><?php echo get_phrase('save_notice'); ?></button>
    </div>
  </div>
</form>

<script>
$(document).ready(function() {

});
$(".ajaxForm").validate({}); 
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllNotices);
});


function is_selected_user(e) {
    if ($(e).val() === 'selected_user') {
        $('#select_newsletter_user').show();
    } else {
        $('#select_newsletter_user').hide();
    }
  }


  $(document).ready(function () {
    $("#search").on("keyup", function () {
        let query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: "<?php echo base_url(); ?>Superadmin/searchUsers",
                method: "POST",
                data: { search: query },
                dataType: "json",
                success: function (response) {
                    let dropdown = $("#user-results");
                    dropdown.empty(); 
                    if (response.length > 0) {
                        response.forEach(user => {
                            let userItem = `
                                <li class="dropdown-item d-flex align-items-center user-option" 
                                    data-id="${user.id}" data-name="${user.name}">
                                    
                                    <span class="ml-2">${user.name}</span>
                                </li>`;
                            dropdown.append(userItem);
                        });
                        dropdown.show(); 
                    } else {
                        dropdown.hide();
                    }
                }
            });
        } else {
            $("#user-results").hide();
        }
    });

    $(document).on("click", ".user-option", function () {
    let selectedId = $(this).data("id");
    let selectedName = $(this).data("name");
    $("#search").val(selectedName);

    let existingIds = $("#selected_user_ids").val();
    let newIds = existingIds ? existingIds.split(',') : [];
    
    if (!newIds.includes(selectedId.toString())) {
        newIds.push(selectedId);
    }
    
    $("#selected_user_ids").val(newIds.join(',')); 
    $("#user-results").hide();
});


    $(document).on("click", ".user-option", function () {
        let selectedName = $(this).data("name");
        $("#search").val(selectedName);
        $("#user-results").hide();
    });
});


</script>
