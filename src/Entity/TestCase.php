<?php

namespace App\Entity;

use App\Repository\TestCaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestCaseRepository::class)]
class TestCase
{
    const Passed = 'passed';
    const Failed = 'failed';
    const SKIPPED = 'skypped';
    const ERROR = 'error';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $class;

    #[ORM\Column(type: 'string', length: 255)]
    private $classname;

    #[ORM\Column(type: 'text')]
    private $file;

    #[ORM\Column(type: 'integer')]
    private $line;

    #[ORM\Column(type: 'integer')]
    private $assertions;

    #[ORM\Column(type: 'float')]
    private $time;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'text', nullable: true)]
    private $message;

    #[ORM\ManyToOne(targetEntity: TestSuite::class, inversedBy: 'testCases')]
    #[ORM\JoinColumn(nullable: false)]
    private $testSuite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $failureType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getClassname(): ?string
    {
        return $this->classname;
    }

    public function setClassname(string $classname): self
    {
        $this->classname = $classname;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getLine(): ?int
    {
        return $this->line;
    }

    public function setLine(int $line): self
    {
        $this->line = $line;

        return $this;
    }

    public function getAssertions(): ?int
    {
        return $this->assertions;
    }

    public function setAssertions(int $assertions): self
    {
        $this->assertions = $assertions;

        return $this;
    }

    public function getTime(): ?float
    {
        return $this->time;
    }

    public function setTime(float $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getTestSuite(): ?TestSuite
    {
        return $this->testSuite;
    }

    public function setTestSuite(?TestSuite $testSuite): self
    {
        $this->testSuite = $testSuite;

        return $this;
    }

    public function getFailureType(): ?string
    {
        return $this->failureType;
    }

    public function setFailureType(?string $failureType): self
    {
        $this->failureType = $failureType;

        return $this;
    }
}
