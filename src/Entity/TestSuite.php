<?php

namespace App\Entity;

use App\Repository\TestSuiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestSuiteRepository::class)]
class TestSuite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

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

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childSuites')]
    private $parentSuite;

    #[ORM\OneToMany(mappedBy: 'parentSuite', targetEntity: self::class)]
    private $childSuites;

    #[ORM\OneToMany(mappedBy: 'testSuite', targetEntity: TestCase::class)]
    private $testCases;

    #[ORM\ManyToOne(targetEntity: TestReport::class, inversedBy: 'testSuites')]
    private $testReport;

    public function __construct()
    {
        $this->childSuites = new ArrayCollection();
        $this->testCases = new ArrayCollection();
    }

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

    public function getParentSuite(): ?self
    {
        return $this->parentSuite;
    }

    public function setParentSuite(?self $parentSuite): self
    {
        $this->parentSuite = $parentSuite;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildSuites(): Collection
    {
        return $this->childSuites;
    }

    public function addSuite(self $suite): self
    {
        if (!$this->childSuites->contains($suite)) {
            $this->childSuites[] = $suite;
            $suite->setParentSuite($this);
        }

        return $this;
    }

    public function removeSuite(self $suite): self
    {
        if ($this->childSuites->removeElement($suite)) {
            // set the owning side to null (unless already changed)
            if ($suite->getParentSuite() === $this) {
                $suite->setParentSuite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TestCase>
     */
    public function getTestCases(): Collection
    {
        return $this->testCases;
    }

    public function addTestCase(TestCase $testCase): self
    {
        if (!$this->testCases->contains($testCase)) {
            $this->testCases[] = $testCase;
            $testCase->setTestSuite($this);
        }

        return $this;
    }

    public function removeTestCase(TestCase $testCase): self
    {
        if ($this->testCases->removeElement($testCase)) {
            // set the owning side to null (unless already changed)
            if ($testCase->getTestSuite() === $this) {
                $testCase->setTestSuite(null);
            }
        }

        return $this;
    }

    public function getTestReport(): ?TestReport
    {
        return $this->testReport;
    }

    public function setTestReport(?TestReport $testReport): self
    {
        $this->testReport = $testReport;

        return $this;
    }
}
