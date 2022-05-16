<?php

namespace App\Command;

use App\Service\JunitXMLReader;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:upload-report',
    description: 'Add a short description for your command',
)]
class UploadReportCommand extends Command
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('reportFileName', InputArgument::REQUIRED, 'Report File Name')
            ->addOption('tag', null, InputOption::VALUE_REQUIRED, 'Tag')
            ->addOption('datetime', 'd', InputOption::VALUE_OPTIONAL, 'Fecha y hora del reporte. Si no se indica, cogerá la hora actual.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $reportFileName = $input->getArgument('reportFileName');
        $tag = $input->getOption('tag');
        $date = $input->getOption('datetime');

        if(is_null($date)) {
            $date = new DateTimeImmutable();
        }

        $xml = file_get_contents($reportFileName);
        $reader = new JunitXMLReader();
        $report = $reader->parse($xml);
        $report->setTag($tag);
        $report->setDate($date);

        $this->em->persist($report);
        $this->em->flush();


        return Command::SUCCESS;
    }
}
