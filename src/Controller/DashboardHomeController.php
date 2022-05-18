<?php

namespace App\Controller;

use App\Entity\TestCase;
use App\Entity\TestReport;
use App\Repository\TestCaseRepository;
use App\Repository\TestReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardHomeController extends AbstractController
{
    #[Route('/dashboard/report/list', name: 'report_list')]
    public function reportList(TestReportRepository $reportRepository): Response
    {
        $reports =  $reportRepository->findAll();

        $output = [
            'reports' => array_reverse($reports)
        ];

        return $this->render('dashboard_home/list.html.twig', $output);
    }

    #[Route('/dashboard/report/{id}', name: 'report_detail')]
    public function reportDetail(TestReport $report, TestCaseRepository $testCaseRepository): Response
    {
        $testCasesWithErrors = $testCaseRepository->findBy(['report' => $report, 'status' => TestCase::ERROR]);
        $testCasesWithFailures = $testCaseRepository->findBy(['report' => $report, 'status' => TestCase::FAILED]);

        $output = [
            'report' => $report,
            'testCasesWithErrorsOrFailures' => array_merge($testCasesWithErrors, $testCasesWithFailures)
        ];

        return $this->render('dashboard_home/detail.html.twig', $output);
    }

    #[Route('/dashboard/report/{id}/slow', name: 'report_slow')]
    public function reportSlow(TestReport $report, TestCaseRepository $testCaseRepository): Response
    {
        $slowestTests = $testCaseRepository->findBy(['report' => $report], ['time' => 'desc'], 20);

        $output = [
            'report' => $report,
            'tests' => $slowestTests
        ];

        return $this->render('dashboard_home/slow.html.twig', $output);
    }
}
