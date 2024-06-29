<?php 
    require_once "./third-party/dompdf/autoload.inc.php";
    use Dompdf\Dompdf;

    class PdfCreator{


        public function create($html){
            $dompdf = new Dompdf();
        
            $options  = $dompdf->getOptions();
            $options->setDefaultFont("Helvetica");

            $dompdf->setOptions($options);
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
    
            // Render the HTML as PDF
            $dompdf->render();
    
            // Output the generated PDF to Browser
            $dompdf->stream("reporte.pdf",['Attachment'=>0]);
            
        }


    }

?>