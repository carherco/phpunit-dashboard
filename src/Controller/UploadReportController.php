<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadReportController extends AbstractController
{
    #[Route('/upload/report', name: 'app_upload_report')]
    public function index(): Response
    {
        return $this->render('upload_report/index.html.twig', [
            'controller_name' => 'UploadReportController',
        ]);
    }
}
