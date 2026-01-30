<?php $po_id = $param1; $next_status = $param2; ?>
<form method="POST" class="ajaxForm" action="<?php echo site_url($this->session->userdata('user_type').'/purchase_order/add_signature/'.$po_id); ?>">
    <input type="hidden" name="status" value="<?php echo $next_status; ?>">
    <input type="hidden" name="signature_data" id="signature_data">

    <div class="alert alert-info">
        <?php echo get_phrase('please_sign_inside_the_box_below'); ?>
    </div>

    <div class="signature-component mb-2">
        <canvas id="signature-pad"></canvas>
    </div>
    
    <button type="button" class="btn btn-secondary btn-sm mb-3" id="clear-signature">
        <i class="mdi mdi-eraser"></i> <?php echo get_phrase('clear'); ?>
    </button>

    <button class="btn btn-primary w-100" type="submit" id="save-signature">
        <i class="mdi mdi-check"></i> <?php echo get_phrase('approve_and_sign'); ?>
    </button>
</form>

<script>
    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas);

    $('#clear-signature').on('click', function(){ signaturePad.clear(); });

    $(".ajaxForm").submit(function(e) {
        if (signaturePad.isEmpty()) {
            alert("Please provide a signature first.");
            return false;
        }
        // Convertir la signature en Base64
        $('#signature_data').val(signaturePad.toDataURL());
        
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#right-modal').modal('hide');
                showAllPurchaseOrders();
                success_notify("Signed successfully");
            }
        });
    });
</script>