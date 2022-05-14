<?php

namespace App\Controller;

use App\Repository\TestReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardHomeController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard_home')]
    public function index(TestReportRepository $reportRepository): Response
    {
        //$lastReport =  $reportRepository->findLastReport();
        $lastReport =  $reportRepository->find(1);
        $output = [
            'report' => $lastReport
        ];

        return $this->render('dashboard_home/index.html.twig', $output);
    }
}
