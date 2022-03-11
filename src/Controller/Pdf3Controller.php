<?php

namespace App\Controller;

use App\Repository\StocksRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Pdf3Controller extends AbstractController
{
    /**
     * @Route("/pdf3/{id}", name="app_pdf3")
     */
    public function index($id,StocksRepository $rep): Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setIsHtml5ParserEnabled(true);



        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->getOptions()->getChroot(); // something like 'C:\\laragon\\www\\your-local-website\\vendor\\dompdf\\dompdf'



        $stocks=$rep->find($id);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('stocks/pdf.html.twig', [
            'stock' => $stocks,

        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');



        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("facture.pdf", [
            "Attachment" => true
        ]);

}
}
