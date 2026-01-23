<form method="POST" class="d-block ajaxForm" action="<?php echo route('event_calendar/create'); ?>">
  <div class="form-row">
    <!-- Event Title -->
    <div class="form-group mb-1">
      <label for="title"><?php echo get_phrase('event_title'); ?></label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <!-- Project Selection (Stored in school_id) -->
    <div class="form-group mb-1">
      <label for="project_id"><?php echo get_phrase('project'); ?> (<?php echo get_phrase('optional'); ?>)</label>
      <select class="form-control select2" data-toggle="select2" name="project_id" id="project_id">
          <option value=""><?php echo get_phrase('none'); ?></option>
          <?php 
          $projects = $this->db->get_where('projects', ['status' => 'active'])->result_array();
          foreach($projects as $project): ?>
            <option value="<?php echo $project['id']; ?>"><?php echo $project['title']; ?></option>
          <?php endforeach; ?>
      </select>
    </div>

    <!-- Dates -->
    <div class="row">
        <div class="col-6">
            <div class="form-group mb-1">
              <label for="starting_date"><?php echo get_phrase('event_starting_date'); ?></label>
              <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control" id="starting_date" name="starting_date" data-provide="datepicker" required>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mb-1">
              <label for="ending_date"><?php echo get_phrase('event_ending_date'); ?></label>
              <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control" id="ending_date" name="ending_date" data-provide="datepicker" required>
            </div>
        </div>
    </div>

    <!-- Location (New) -->
    <div class="form-group mb-1">
      <label for="location"><?php echo get_phrase('location'); ?> (<?php echo get_phrase('optional'); ?>)</label>
      <input type="text" class="form-control" id="location" name="location">
    </div>

    <!-- Link (New) -->
    <div class="form-group mb-1">
      <label for="link"><?php echo get_phrase('meeting_link'); ?> (<?php echo get_phrase('optional'); ?>)</label>
      <input type="url" class="form-control" id="link" name="link" placeholder="https://...">
    </div>

    <div class="form-group mt-2 col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save_event'); ?></button>
    </div>
  </div>
</form>

<script>
$(document).ready(function() {
  
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllEvents);
});
</script>
