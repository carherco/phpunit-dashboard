<?php

namespace App\Service;

use App\Entity\TestCase;
use App\Entity\TestReport;
use App\Entity\TestSuite;
use SimpleXMLElement;

class JunitXMLReader
{

  /**
   * @throws \Exception
   */
  public function parse(string $xml): TestReport
  {
    $report = new TestReport();

    $xmlTestSuites = new SimpleXMLElement($xml);

    // Root suite
    $xmlRootSuite = $xmlTestSuites->testsuite;

    $rootSuite = $this->buildTestSuiteFromXML($xmlRootSuite);

    $report->addTestSuite($rootSuite);

    // Child Suites
    $parentSuite = $rootSuite;
    $this->processChildren($parentSuite, $xmlRootSuite);

    return $report;
  }

  /**
   * @param SimpleXMLElement $xmlTestSuite
   * @return TestSuite
   */
  private function buildTestSuiteFromXML(SimpleXMLElement $xmlTestSuite): TestSuite
  {
    $testSuite = new TestSuite();
    $testSuite->setName((string)$xmlTestSuite['name']);
    $testSuite->setTests((int)$xmlTestSuite['tests']);
    $testSuite->setAssertions((int)$xmlTestSuite['assertions']);
    $testSuite->setErrors((int)$xmlTestSuite['errors']);
    $testSuite->setWarnings((int)$xmlTestSuite['warnings']);
    $testSuite->setFailures((int)$xmlTestSuite['failures']);
    $testSuite->setSkipped((int)$xmlTestSuite['skipped']);
    $testSuite->setTime((float)$xmlTestSuite['time']);
    return $testSuite;
  }

  /**
   * @param SimpleXMLElement $xmlTestCase
   * @return TestCase
   */
  private function buildTestCaseFromXML(SimpleXMLElement $xmlTestCase): TestCase
  {
    $testCase = new TestCase();
    $testCase->setName((string)$xmlTestCase['name']);
    $testCase->setClass((int)$xmlTestCase['class']);
    $testCase->setClassname((int)$xmlTestCase['classname']);
    $testCase->setFile((int)$xmlTestCase['file']);
    $testCase->setLine((int)$xmlTestCase['line']);
    $testCase->setAssertions((int)$xmlTestCase['assertions']);
    $testCase->setTime((float)$xmlTestCase['time']);

    if(isset($xmlTestCase->failure)) {
      $testCase->setStatus(TestCase::Failed);
      $testCase->setMessage((string)$xmlTestCase->failure);
    } else if(isset($xmlTestCase->skipped)) {
      $testCase->setStatus(TestCase::SKIPPED);
    } else {
      $testCase->setStatus(TestCase::Passed);
    }
    return $testCase;
  }

  /**
   * @param TestSuite $parentSuite
   * @param SimpleXMLElement $xmlRootSuite
   */
  private function processChildren(TestSuite $parentSuite, SimpleXMLElement $xmlSuite): void
  {
    foreach ($xmlSuite->children() as $xmlElement) {
      if ($xmlElement->getName() === 'testsuite') {
        $suite = $this->buildTestSuiteFromXML($xmlElement);
        $parentSuite->addSuite($suite);
        $this->processChildren($suite, $xmlElement);
      }

      if ($xmlElement->getName() === 'testcase') {
        $testCase = $this->buildTestCaseFromXML($xmlElement);
        $parentSuite->addTestCase($testCase);
      }
    }
  }
}