<!-- Titre de la page et Bouton Ajouter -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title d-inline-block">
          <i class="mdi mdi-tools title_icon"></i> <?php echo get_phrase('assets_&_machines'); ?>
        </h4>
        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle float-end mt-1" onclick="rightModal('<?php echo site_url('modal/popup/asset/create'); ?>', '<?php echo get_phrase('add_new_asset'); ?>')"> 
            <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_asset'); ?>
        </button>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<!-- Filtre par Site (Nouakchott / Tasiast) -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                        <label for="site_id"><?php echo get_phrase('filter_by_site'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="site_id" id="site_id" onchange="showAllAssets()">
                            <option value="all"><?php echo get_phrase('all_sites'); ?></option>
                            <option value="1">Nouakchott</option>
                            <option value="2">Tasiast</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Zone d'affichage de la liste (chargée via AJAX) -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body asset_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
/**
 * Fonction pour charger la liste des assets via AJAX
 * Permet de filtrer par site sans recharger la page
 */
var showAllAssets = function () {
  var site_id = $('#site_id').val();
  // On passe le site_id à l'URL du controller
  var url = '<?php echo site_url('gm/asset/list/'); ?>' + site_id;

  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      // On remplace le contenu de la div par la réponse du serveur
      $('.asset_content').html(response);
      // Ré-initialisation de la DataTable après le chargement AJAX
      initDataTable('basic-datatable');
    }
  });
}
</script>