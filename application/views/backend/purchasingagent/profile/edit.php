<?php
$profile_data = $this->user_model->get_profile_data();
?>
<div class="row justify-content-md-center">
    <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?php echo get_phrase('update_profile') ; ?></h4>
                <form method="POST" class="col-12 profileAjaxForm" action="<?php echo route('profile/update_profile') ; ?>" id = "profileAjaxForm" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="name"> <?php echo get_phrase('name') ; ?></label>
                            <div class="col-md-9">
                                <input type="text" id="name" name="name" class="form-control"  value="<?php echo $profile_data['name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="email"><?php echo get_phrase('email') ; ?></label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="form-control"  value="<?php echo $profile_data['email']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="phone"> <?php echo get_phrase('phone') ; ?></label>
                            <div class="col-md-9">
                                <input type="text" id="phone" name="phone" class="form-control"  value="<?php echo $profile_data['phone']; ?>">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="address"> <?php echo get_phrase('address') ; ?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="address" name = "address" rows="5"><?php echo $profile_data['address']; ?></textarea>
                            </div>
                        </div>
                       <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label"><?php echo get_phrase('draw_your_signature'); ?></label>
    <div class="col-md-9">
        <div class="signature-wrapper" style="border: 1px solid #e3e6f0; background-color: #f8f9fc; border-radius: 5px;">
            <!-- Zone de dessin -->
            <canvas id="signature-pad" class="signature-pad" width="400" height="200" style="width: 100%; cursor: crosshair;"></canvas>
        </div>
        
        <div class="mt-2">
            <button type="button" id="clear_signature" class="btn btn-sm btn-outline-danger">
                <i class="mdi mdi-eraser"></i> <?php echo get_phrase('clear'); ?>
            </button>
            <small class="text-muted float-end"><?php echo get_phrase('sign_inside_the_box'); ?></small>
        </div>

        <!-- Champ caché qui contiendra l'image en base64 -->
        <input type="hidden" name="signature_data" id="signature_data">

        <!-- Affichage de la signature actuelle -->
        <?php if(!empty($profile_data['signature'])): ?>
            <div class="mt-3">
                <p class="small mb-1"><?php echo get_phrase('current_signature'); ?> :</p>
                <img src="<?php echo base_url('uploads/signatures/'.$profile_data['signature']); ?>" style="max-height: 80px; border: 1px dashed #ccc;">
            </div>
        <?php endif; ?>
    </div>
</div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('profile_image'); ?></label>
                            <div class="col-md-9 custom-file-upload">
                                <div class="wrapper-image-preview" style="margin-left: -6px;">
                                    <div class="box" style="width: 250px;">
                                        <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>); background-color: #F5F5F5;"></div>
                                        <div class="upload-options">
                                            <label for="profile_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                            <input id="profile_image" style="visibility:hidden;" type="file" class="image-upload" name="profile_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateProfileInfo()"><?php echo get_phrase('update_profile') ; ?></button>
                        </div>
                    </div>
                </form>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>

    <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?php echo get_phrase('change_password') ; ?></h4>
                <form method="POST" class="col-12 changePasswordAjaxForm" action="<?php echo route('profile/update_password') ; ?>" id = "changePasswordAjaxForm" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="current_password"> <?php echo get_phrase('current_password') ; ?></label>
                            <div class="col-md-9">
                                <input type="password" id="current_password" name="current_password" class="form-control"  value="" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="new_password"> <?php echo get_phrase('new_password') ; ?></label>
                            <div class="col-md-9">
                                <input type="password" id="new_password" name="new_password" class="form-control"  value="" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="confirm_password"> <?php echo get_phrase('confirm_password') ; ?></label>
                            <div class="col-md-9">
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control"  value="" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="changePassword()"><?php echo get_phrase('change_password') ; ?></button>
                        </div>
                    </div>
                </form>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)', // Fond transparent
            penColor: 'rgb(0, 0, 0)' // Couleur noire
        });

        // Bouton pour effacer
        document.getElementById('clear_signature').addEventListener('click', function () {
            signaturePad.clear();
            document.getElementById('signature_data').value = "";
        });

        // Intercepter la soumission du profil
        $('#profileAjaxForm').submit(function() {
            if (!signaturePad.isEmpty()) {
                // Convertir le dessin en base64
                var data = signaturePad.toDataURL('image/png');
                document.getElementById('signature_data').value = data;
            }
        });
    });

    // Ajuster la taille du canvas pour le responsive
    function resizeCanvas() {
        var canvas = document.getElementById('signature-pad');
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    window.onresize = resizeCanvas;
    resizeCanvas();
</script>