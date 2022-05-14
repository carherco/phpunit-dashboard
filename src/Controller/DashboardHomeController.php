<?php

namespace App\Controller;

use App\Entity\TestCase;
use App\Repository\TestCaseRepository;
use App\Repository\TestReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardHomeController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard_home')]
    public function index(TestReportRepository $reportRepository, TestCaseRepository $testCaseRepository): Response
    {
        //$lastReport =  $reportRepository->findLastReport();
        $lastReport =  $reportRepository->find(1);
        $testCasesWithErrors = $testCaseRepository->findByStatus(TestCase::ERROR);
        $testCasesWithFailures = $testCaseRepository->findByStatus(TestCase::Failed);

        $output = [
            'report' => $lastReport,
            'testCasesWithErrorsOrFailures' => array_merge($testCasesWithErrors, $testCasesWithFailures)
        ];

        return $this->render('dashboard_home/index.html.twig', $output);
    }
}
