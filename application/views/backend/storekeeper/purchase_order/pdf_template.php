<html>
<head>
    <style>
        body { font-family: 'Helvetica'; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .info-table { width: 100%; margin-top: 20px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.items th, table.items td { border: 1px solid #ccc; padding: 8px; }
        .signature-section { margin-top: 40px; width: 100%; }
        .sig-box { width: 24%; display: inline-block; text-align: center; vertical-align: top; font-size: 9px; }
        .sig-img { width: 70px; height: auto; display: block; margin: 2px auto; }
    </style>
</head>
<body>
    <div class="header">
        <h2>WORLD SERVICE - MAURITANIE</h2>
        <h3 style="margin:0;">BON DE COMMANDE #<?php echo $po['code']; ?></h3>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Projet :</strong> <?php 
                $project = $this->db->get_where('projects', ['id' => $po['project_id']])->row_array();
                echo isset($project['name']) ? $project['name'] : 'N/A'; 
            ?></td>
            <td style="text-align: right;"><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($po['created_at'])); ?></td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr style="background: #f2f2f2;">
                <th>Description</th>
                <th style="width: 80px; text-align: center;">Quantité</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $items = $this->db->get_where('purchase_order_items', ['purchase_order_id' => $po_id])->result_array();
            foreach($items as $item): ?>
            <tr>
                <td>
                    <?php 
                        if(!empty($item['inventory_id'])) {
                            $inv = $this->db->get_where('inventory', ['id' => $item['inventory_id']])->row_array();
                            echo isset($inv['name']) ? $inv['name'] : 'Item inconnu';
                        } else {
                            echo $item['custom_item_name'];
                        }
                    ?>
                </td>
                <td style="text-align: center;"><?php echo (int)$item['quantity']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="signature-section">
        <!-- 1. Magasinier (Émetteur) -->
        <div class="sig-box">
            <p><strong>Émis par :</strong></p>
            <?php 
                $u1 = $this->db->get_where('users', ['id' => $po['requested_by']])->row_array();
                if(isset($u1['signature']) && !empty($u1['signature'])): ?>
                <img src="uploads/signatures/<?php echo $u1['signature']; ?>" class="sig-img">
            <?php endif; ?>
            <p><?php echo isset($u1['name']) ? $u1['name'] : ''; ?></p>
        </div>

        <!-- 2. Site Manager -->
        <div class="sig-box">
            <?php if($po['status'] >= 2): ?>
                <p><strong>Site Manager :</strong></p>
                <?php 
                $doc2 = $this->db->get_where('purchase_order_docs', ['purchase_order_id' => $po_id, 'doc_type' => 'site_signed_doc'])->row_array();
                // Si on ne trouve pas encore le doc en base, on utilise l'utilisateur actuel (celui qui signe)
                $u2 = ($doc2) ? $this->db->get_where('users', ['id' => $doc2['uploaded_by']])->row_array() : $user;
                
                if(isset($u2['signature']) && !empty($u2['signature'])): ?>
                    <img src="uploads/signatures/<?php echo $u2['signature']; ?>" class="sig-img">
                <?php endif; ?>
                <p><?php echo isset($u2['name']) ? $u2['name'] : ''; ?></p>
            <?php endif; ?>
        </div>

        <!-- 3. Procurement -->
        <div class="sig-box">
            <?php if($po['status'] >= 3): ?>
                <p><strong>Procurement :</strong></p>
                <?php 
                $doc3 = $this->db->get_where('purchase_order_docs', ['purchase_order_id' => $po_id, 'doc_type' => 'procurement_signed_doc'])->row_array();
                $u3 = ($doc3) ? $this->db->get_where('users', ['id' => $doc3['uploaded_by']])->row_array() : $user;
                
                if(isset($u3['signature']) && !empty($u3['signature'])): ?>
                    <img src="uploads/signatures/<?php echo $u3['signature']; ?>" class="sig-img">
                <?php endif; ?>
                <p><?php echo isset($u3['name']) ? $u3['name'] : ''; ?></p>
            <?php endif; ?>
        </div>

        <!-- 4. General Manager -->
        <div class="sig-box">
            <?php if($po['status'] >= 4): ?>
                <p><strong>Directeur (GM) :</strong></p>
                <?php 
                $doc4 = $this->db->get_where('purchase_order_docs', ['purchase_order_id' => $po_id, 'doc_type' => 'gm_signed_doc'])->row_array();
                $u4 = ($doc4) ? $this->db->get_where('users', ['id' => $doc4['uploaded_by']])->row_array() : $user;
                
                if(isset($u4['signature']) && !empty($u4['signature'])): ?>
                    <img src="uploads/signatures/<?php echo $u4['signature']; ?>" class="sig-img">
                <?php endif; ?>
                <p><?php echo isset($u4['name']) ? $u4['name'] : ''; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>