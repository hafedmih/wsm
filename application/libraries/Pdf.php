<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
	public function __construct()
	{
		 parent::__construct();
	} 
        public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = 'portrait') {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output(); // Retourne le contenu binaire du PDF
    }
}
}

?>