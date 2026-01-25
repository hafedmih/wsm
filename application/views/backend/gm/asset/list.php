<?php 
$assets = $this->db->get('assets')->result_array(); 
?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Prochain Calibrage</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($assets as $asset): 
            // Logique d'alerte couleur
            $today = strtotime(date('Y-m-d'));
            $next_cal = strtotime($asset['next_calibration']);
            $diff = ($next_cal - $today) / (60 * 60 * 24);
            $color = ($diff <= 7) ? 'badge-danger' : 'badge-success';
        ?>
        <tr>
            <td><?php echo $asset['asset_code']; ?></td>
            <td><?php echo $asset['name']; ?></td>
            <td><span class="badge <?php echo $color; ?>"><?php echo $asset['next_calibration']; ?></span></td>
            <td><?php echo $asset['status']; ?></td>
            <td>
                <button onclick="rightModal('<?php echo site_url('modal/popup/asset/edit/'.$asset['id']); ?>')">Edit</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>