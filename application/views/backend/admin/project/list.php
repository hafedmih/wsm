<?php
$entity = 'project'; // change to 'donor'
$role   = 'project'; // change to 'donor'
$school_id = school_id();

$visible_fields = [
    'id',
    'code',
    'title',
    'title_ar',
    'budget'
];
//code,title,title_ar,budget
?>
<?php
$check_data = $this->db->get_where('projects', 
        [
  
]
        );

if ($check_data->num_rows() > 0):
    $users = $check_data->result_array();
?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background:#313a46;color:#ababab;">
            <?php foreach ($visible_fields as $field): ?>
                <th><?= get_phrase($field); ?></th>
            <?php endforeach; ?>
                                <th><?= get_phrase('details'); ?></th>
            <th><?= get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <?php foreach ($visible_fields as $field): ?>
                <td><?= isset($user[$field]) ? $user[$field] : '-'; ?></td>
            <?php endforeach; ?>
                <td>
                        <div class="dropdown text-center">
                            
                            <a class="btn btn-primary" 
                               href="<?php echo site_url("superadmin/project/q/" . $user["id"]); ?>"
                               >
                                <i class="mdi mdi-eye"></i>
                            </a>
                            <!--</div>-->
                        </div>



                    </td>

            <td>
                <div class="dropdown text-center">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                        data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item"
                           onclick="rightModal(
                           '<?= site_url("modal/popup/$entity/edit/".$user['id']) ?>',
                           '<?= get_phrase("update_$entity") ?>')">
                           <?= get_phrase('edit'); ?>
                        </a>

                        <a class="dropdown-item"
                           onclick="confirmModal(
                           '<?= route("$entity/delete/".$user['id']) ?>',
                           showAllData)">
                           <?= get_phrase('delete'); ?>
                        </a>
                    </div>
                </div>
            </td>
            
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: include APPPATH.'views/backend/empty.php'; endif; ?>
