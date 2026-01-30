<style>
    .header { text-align: center; border-bottom: 2px solid #000; }
    .footer { position: fixed; bottom: 50px; width: 100%; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
</style>

<div class="header">
    <h1>WORLD SERVICE</h1>
    <h2>PURCHASE ORDER</h2>
    <p>Code: <?php echo $this->db->get_where('purchase_orders', ['id' => $po_id])->row()->code; ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>Description</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $items = $this->db->get_where('purchase_order_items', ['purchase_order_id' => $po_id])->result_array();
        foreach($items as $item): 
            $name = ($item['inventory_id'] > 0) ? 
                    $this->db->get_where('inventory', ['id' => $item['inventory_id']])->row()->name : 
                    $item['custom_item_name'];
        ?>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $item['quantity']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="footer">
    <div style="float: right; text-align: center;">
        <p>Requested By: <?php echo $this->db->get_where('users', ['id' => $this->session->userdata('user_id')])->row()->name; ?></p>
        <?php if(!empty($signature)): ?>
            <img src="<?php echo base_url('uploads/signatures/'.$signature); ?>" width="150">
        <?php else: ?>
            <p>(Signature en attente)</p>
        <?php endif; ?>
    </div>
</div>