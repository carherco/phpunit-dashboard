<?php

namespace App\Entity;

use App\Repository\TestReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestReportRepository::class)]
class TestReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $tag;

    #[ORM\Column(type: 'integer')]
    private $tests;

    #[ORM\Column(type: 'integer')]
    private $assertions;

    #[ORM\Column(type: 'integer')]
    private $errors;

    #[ORM\Column(type: 'integer')]
    private $warnings;

    #[ORM\Column(type: 'integer')]
    private $failures;

    #[ORM\Column(type: 'integer')]
    private $skipped;

    #[ORM\Column(type: 'float')]
    private $time;

    #[ORM\OneToMany(mappedBy: 'testReport', targetEntity: TestSuite::class)]
    private $testSuites;

    public function __construct()
    {
        $this->testSuites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTests(): ?int
    {
      return $this->tests;
    }

    public function setTests(int $tests): self
    {
      $this->tests = $tests;

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

    public function getErrors(): ?int
    {
      return $this->errors;
    }

    public function setErrors(int $errors): self
    {
      $this->errors = $errors;

      return $this;
    }

    public function getWarnings(): ?int
    {
      return $this->warnings;
    }

    public function setWarnings(int $warnings): self
    {
      $this->warnings = $warnings;

      return $this;
    }

    public function getFailures(): ?int
    {
      return $this->failures;
    }

    public function setFailures(int $failures): self
    {
      $this->failures = $failures;

      return $this;
    }

    public function getSkipped(): ?int
    {
      return $this->skipped;
    }

    public function setSkipped(int $skipped): self
    {
      $this->skipped = $skipped;

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

    /**
     * @return Collection<int, TestSuite>
     */
    public function getTestSuites(): Collection
    {
        return $this->testSuites;
    }

    public function addTestSuite(TestSuite $testSuite): self
    {
        if (!$this->testSuites->contains($testSuite)) {
            $this->testSuites[] = $testSuite;
            $testSuite->setTestReport($this);

            $this->setTests($testSuite->getTests());
            $this->setAssertions($testSuite->getAssertions());
            $this->setErrors($testSuite->getErrors());
            $this->setWarnings($testSuite->getWarnings());
            $this->setFailures($testSuite->getFailures());
            $this->setSkipped($testSuite->getSkipped());
            $this->setTime($testSuite->getTime());

        }

        return $this;
    }

    public function removeTestSuite(TestSuite $testSuite): self
    {
        if ($this->testSuites->removeElement($testSuite)) {
            // set the owning side to null (unless already changed)
            if ($testSuite->getTestReport() === $this) {
                $testSuite->setTestReport(null);
            }
        }

        return $this;
    }
}
