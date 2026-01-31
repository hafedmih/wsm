<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .footer { margin-top: 30px; width: 100%; }
        .sig-img { max-height: 60px; max-width: 150px; margin-bottom: 5px; }
        .sig-box { height: 80px; vertical-align: bottom; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>WORLD SERVICE - BON DE SORTIE (<?php echo ($v['status'] == 'approved') ? 'FINAL' : 'DEMANDE'; ?>)</h2>
        <p>Code: <strong><?php echo $v['code']; ?></strong> | Date: <?php echo date('d/m/Y H:i', strtotime($v['created_at'])); ?></p>
    </div>

    <!-- Info Projet/Site (Identique) -->
    <table style="width: 100%; margin-top: 15px;">
        <tr>
            <td><strong>Site:</strong> <?php echo $v['site_name']; ?></td>
            <td><strong>Projet:</strong> <?php echo $v['project_name']; ?></td>
        </tr>
    </table>

    <!-- Tableau des articles (Identique) -->
    <table class="table">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>SKU</th><th>Désignation</th><th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $i): ?>
            <tr><td><?php echo $i['sku']; ?></td><td><?php echo $i['name']; ?></td><td><?php echo $i['quantity']; ?> <?php echo $i['unit']; ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><strong>Motif:</strong> <?php echo $v['motive']; ?></p>

    <!-- SECTION SIGNATURES AVEC IMAGES -->
    <table class="footer">
        <tr>
            <!-- Signature Storekeeper -->
            <td class="sig-box" style="width: 50%;">
                <p><strong>Demandé par (Storekeeper)</strong></p>
                <?php 
                    // Récupération de la signature du créateur
                    $u_req = $this->db->get_where('users', ['id' => $v['requested_by']])->row_array();
                    if(!empty($u_req['signature'])): ?>
                        <img src="uploads/signatures/<?php echo $u_req['signature']; ?>" class="sig-img">
                <?php else: ?>
                    <div style="height:60px;"></div>
                <?php endif; ?>
                <div style="border-top: 1px solid #000; width: 150px; margin: 0 auto;"></div>
                <p><?php echo $u_req['name']; ?></p>
            </td>

            <!-- Signature Approbateur -->
            <td class="sig-box" style="width: 50%;">
                <p><strong>Approuvé par (Site Manager / GM)</strong></p>
                <?php if($v['status'] == 'approved'): 
                    $u_app = $this->db->get_where('users', ['id' => $v['approved_by']])->row_array();
                    if(!empty($u_app['signature'])): ?>
                        <img src="uploads/signatures/<?php echo $u_app['signature']; ?>" class="sig-img">
                    <?php else: ?>
                        <div style="height:60px; color: green; font-weight: bold; padding-top: 20px;">APPROUVÉ</div>
                    <?php endif; ?>
                    <div style="border-top: 1px solid #000; width: 150px; margin: 0 auto;"></div>
                    <p><?php echo $u_app['name']; ?> <br> <small>Le <?php echo date('d/m/Y H:i', strtotime($v['approved_at'])); ?></small></p>
                <?php else: ?>
                    <div style="height:60px;"></div>
                    <div style="border-top: 1px dashed #ccc; width: 150px; margin: 0 auto;"></div>
                    <p style="color: #999;"><i>En attente de signature</i></p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</body>
</html>