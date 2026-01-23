<?php
$entity = 'ministry';    // Route name in controller
$table  = 'ministries';  // Database table name
$school_id = school_id();

// Added abbr_ar as it is specific to your ministry table requirements
$visible_fields = [
    'id',
    'name',
    'name_ar',
    'abbr',
    'abbr_ar'
];
?>

<?php
// Fetch all data from the ministries table
$check_data = $this->db->get($table);

if ($check_data->num_rows() > 0):
    $users = $check_data->result_array();
?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background:#313a46;color:#ababab;">
            <?php foreach ($visible_fields as $field): ?>
                <th><?= get_phrase($field); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <?php foreach ($visible_fields as $field): ?>
                <td>
                    <?php if($field == 'website' && !empty($user[$field])): ?>
                        <a href="<?= $user[$field]; ?>" target="_blank" class="text-info">
                            <i class="mdi mdi-link-variant"></i> <?= $user[$field]; ?>
                        </a>
                    <?php elseif($field == 'email'): ?>
                        <a href="mailto:<?= $user[$field]; ?>"><?= $user[$field]; ?></a>
                    <?php else: ?>
                        <!-- Standard text display -->
                        <?= isset($user[$field]) ? $user[$field] : '-'; ?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>

          
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: include APPPATH.'views/backend/empty.php'; endif; ?>