<?php
    $project_details = $this->db->get_where('projects', array('id' => $param1))->result_array();
    foreach($project_details as $project):
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('project/update/'.$param1); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <!-- Nom du Projet -->
        <div class="form-group mb-2">
            <label for="name"><?php echo get_phrase('project_name'); ?></label>
            <input type="text" value="<?php echo $project['name']; ?>" class="form-control" id="name" name="name" required>
        </div>

        <!-- Montant du Devis (Confidentiel) -->
        <div class="form-group mb-2">
            <label for="quotation_amount"><?php echo get_phrase('quotation_amount'); ?> (MRU)</label>
            <input type="number" value="<?php echo $project['quotation_amount']; ?>" class="form-control" id="quotation_amount" name="quotation_amount" required>
        </div>

        <div class="row">
            <!-- Avancement (%) -->
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="progress_percent"><?php echo get_phrase('progress'); ?> (%)</label>
                    <input type="number" value="<?php echo $project['progress_percent']; ?>" class="form-control" name="progress_percent" min="0" max="100" required>
                </div>
            </div>
            <!-- Statut -->
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="status"><?php echo get_phrase('status'); ?></label>
                    <select name="status" class="form-control select2" data-toggle="select2">
                        <option value="open" <?php if($project['status'] == 'open') echo 'selected'; ?>><?php echo get_phrase('open'); ?></option>
                        <option value="completed" <?php if($project['status'] == 'completed') echo 'selected'; ?>><?php echo get_phrase('completed'); ?></option>
                        <option value="cancelled" <?php if($project['status'] == 'cancelled') echo 'selected'; ?>><?php echo get_phrase('cancelled'); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Fichier Contrat -->
        <div class="form-group mb-3">
            <label for="contract_file"><?php echo get_phrase('update_contract_file'); ?> (PDF)</label>
            <input type="file" class="form-control" id="contract_file" name="contract_file" accept=".pdf">
            <?php if($project['contract_file']): ?>
                <small class="text-success"><?php echo get_phrase('current_file_exists'); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_project'); ?></button>
        </div>
    </div>
</form>
<?php endforeach; ?>

<script>
$(document).ready(function () {
    $('select.select2').each(function () { 
        $(this).select2({ dropdownParent: '#right-modal' }); 
    });
});

$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllProjects);
});
</script>