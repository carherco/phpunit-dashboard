<?php

namespace App\Controller;

use App\Entity\TestReport;
use App\Form\ReportType;
use App\Service\JunitXMLReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadReportController extends AbstractController
{
    #[Route('/upload/report', name: 'app_upload_report')]
    public function upload(Request $request, JunitXMLReader $reader, EntityManagerInterface $em)
    {
        $reportForm = new TestReport();
        $reportForm->setDate(new \DateTimeImmutable());

        $form = $this->createForm(ReportType::class, $reportForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $reportFile */
            $reportFile = $form->get('file')->getData();
            $fileContent = $reportFile->getContent();

            $report = $reader->parse($fileContent);
            $report->setTag($reportForm->getTag());
            $report->setDate($reportForm->getDate());

            $em->persist($report);
            $em->flush();

            return $this->redirectToRoute('report_list');
        }

        return $this->render('upload_report/index.html.twig', ['form' => $form->createView()]);
    }
}
