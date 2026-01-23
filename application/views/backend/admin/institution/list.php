<?php
$entity = 'institution'; // Route name in controller
$table  = 'donors';      // Database table name
$school_id = school_id();

$visible_fields = [
    'id',
    'name',
    'name_ar',
    'website'
];
?>

<?php
// Fetch all data from the donors table
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
                        <?= isset($user[$field]) ? $user[$field] : '-'; ?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>

            
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: include APPPATH.'views/backend/empty.php'; endif; ?>
