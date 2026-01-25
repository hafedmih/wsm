<!-- TITRE DE LA PAGE -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body py-2">
        <h4 class="page-title">
          <i class="mdi mdi-briefcase title_icon"></i> <?php echo get_phrase('assigned_projects'); ?>
          <span class="badge badge-info-lighten">
            <?php 
                // Affiche le nom du site de l'utilisateur pour confirmation
                echo ($this->session->userdata('site_id') == 1) ? 'Nouakchott' : 'Tasiast'; 
            ?>
          </span>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<!-- SECTION DE LA LISTE -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body project_content">
        <!-- Le contenu est chargé ici par AJAX ou inclus par défaut au premier chargement -->
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT AJAX POUR RAFRAICHIR LA LISTE -->
<script>
/**
 * Cette fonction est appelée après chaque mise à jour de progression
 * pour rafraîchir le tableau sans recharger toute la page.
 */
var showAllProjects = function () {
  var url = '<?php echo site_url('sitemanager/project/list'); ?>';

  $.ajax({
    type : 'GET',
    url: url,
    beforeSend: function() {
        // Optionnel : ajouter un indicateur de chargement
        $('.project_content').css('opacity', '0.5');
    },
    success : function(response) {
      $('.project_content').html(response);
      $('.project_content').css('opacity', '1');
      // Ré-initialise la DataTable d'Ekattor
      initDataTable('basic-datatable');
    }
  });
}

/**
 * Initialisation automatique au chargement si nécessaire
 */
$(document).ready(function() {
    // Si vous utilisez select2 ou d'autres composants sur cette page
    if (jQuery().select2) {
        $('.select2').select2();
    }
});
</script>