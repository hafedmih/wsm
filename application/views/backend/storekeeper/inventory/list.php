<?php 
$site_id = (isset($param1)) ? $param1 : 1; // Par défaut Nouakchott
$this->db->select('inventory.*, stocks.quantity, stocks.min_threshold, categories.name as cat_name');
$this->db->from('inventory');
$this->db->join('stocks', 'stocks.inventory_id = inventory.id');
$this->db->join('categories', 'categories.id = inventory.category_id', 'left');
$this->db->where('stocks.site_id', $site_id);
$items = $this->db->get()->result_array();
?>

<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr>
            <th>SKU</th>
            <th><?php echo get_phrase('product'); ?></th>
            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('quantity_in_stock'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($items as $item): 
            $alert = ($item['quantity'] <= $item['min_threshold']) ? 'text-danger fw-bold' : '';
        ?>
        <tr>
            <td><?php echo $item['sku']; ?></td>
            <td><?php echo $item['name']; ?> (<?php echo $item['unit']; ?>)</td>
            <td><?php echo $item['cat_name']; ?></td>
            <td class="<?php echo $alert; ?>">
                <?php echo $item['quantity']; ?>
                <?php if($item['quantity'] <= $item['min_threshold']): ?>
                    <i class="mdi mdi-alert-circle" title="Stock Bas"></i>
                <?php endif; ?>
            </td>
            <td>
                <button class="btn btn-sm btn-outline-secondary" onclick="rightModal('<?php echo site_url('modal/popup/inventory/edit_stock/'.$item['id'].'/'.$site_id); ?>')">
                    <i class="mdi mdi-database-edit"></i> <?php echo get_phrase('adjust_stock'); ?>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>