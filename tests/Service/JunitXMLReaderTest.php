<?php

namespace App\Tests\Service;

use App\Entity\TestCase;
use App\Entity\TestReport;
use App\Entity\TestSuite;
use App\Service\JunitXMLReader;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class JunitXMLReaderTest extends PHPUnitTestCase
{
  /**
   * @test Estructura de una suite con dos tests que pasan
   */
  public function testSimpleTestCase() {
    // Given
    $xml = '<testsuites>
              <testsuite name="/Users/carlos/mamp/PruebasUnitarias/tests" tests="2" assertions="2" errors="0" warnings="0" failures="0" skipped="0" time="0.000204">
                <testsuite name="misc\HolaMundoTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/misc/HolaMundoTest.php" tests="2" assertions="2" errors="0" warnings="0" failures="0" skipped="0" time="0.000204">
                  <testcase name="testPruebaSumaPositivos" class="misc\HolaMundoTest" classname="misc.HolaMundoTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/misc/HolaMundoTest.php" line="10" assertions="1" time="0.000144"/>
                  <testcase name="testPruebaSumaNegativos" class="misc\HolaMundoTest" classname="misc.HolaMundoTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/misc/HolaMundoTest.php" line="17" assertions="1" time="0.000060"/>
                </testsuite>
              </testsuite>
            </testsuites>
            ';

    $reader = new JunitXMLReader();

    // Act
    $report = $reader->parse($xml);


    // Expected
    self::assertEquals(2, $report->getTests());
    self::assertEquals(2, $report->getAssertions());
    self::assertEquals(0, $report->getErrors());
    self::assertEquals(0, $report->getWarnings());
    self::assertEquals(0, $report->getFailures());
    self::assertEquals(0, $report->getSkipped());
    self::assertEquals(0.000204, $report->getTime());
    self::assertCount(1, $report->getTestSuites());

    $rootSuite = $report->getTestSuites()[0];

    self::assertCount(1, $rootSuite->getChildSuites());

    $suite = $rootSuite->getChildSuites()[0];

    self::assertCount(2, $suite->getTestCases());
  }

  /**
   * @test Estructura de una suite con tests que fallan
   */
  public function testFailures() {
    // Given
    $xml = '<testsuites>
              <testsuite name="/Users/carlos/mamp/PruebasUnitarias/tests" tests="114" assertions="125" errors="0" warnings="0" failures="3" skipped="4" time="0.022517">
                <testsuite name="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" tests="21" assertions="20" errors="0" warnings="0" failures="3" skipped="1" time="0.008897">
                  <testsuite name="AppExtensionTest::testSfCalculator6" tests="8" assertions="8" errors="0" warnings="0" failures="3" skipped="0" time="0.003020">
                    <testcase name="testSfCalculator6 with data set &quot;número negativo con decimales&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.002540">
                      <failure type="PHPUnit\Framework\ExpectationFailedException">AppExtensionTest::testSfCalculator6 with data set "número negativo con decimales" (-28.99, 20.01)
            Mensaje del programador en el assert
            Failed asserting that 20.99 matches expected 20.01.
            
            /Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php:72</failure>
                    </testcase>
                    <testcase name="testSfCalculator6 with data set &quot;con más de 3 decimales (3er decimal menor de 5)&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000118">
                      <failure type="PHPUnit\Framework\ExpectationFailedException">AppExtensionTest::testSfCalculator6 with data set "con más de 3 decimales (3er decimal menor de 5)" (47.004, 20.99)
            Mensaje del programador en el assert
            Failed asserting that 21.0 matches expected 20.99.
            
            /Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php:72</failure>
                    </testcase>
                    <testcase name="testSfCalculator6 with data set &quot;con más de 3 decimales (3er decimal mayor de 5)&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000068">
                      <failure type="PHPUnit\Framework\ExpectationFailedException">AppExtensionTest::testSfCalculator6 with data set "con más de 3 decimales (3er decimal mayor de 5)" (47.997, 20.01)
            Mensaje del programador en el assert
            Failed asserting that 20.0 matches expected 20.01.
            
            /Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php:72</failure>
                    </testcase>
                    <testcase name="testSfCalculator6 with data set &quot;sin decimales&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000053"/>
                    <testcase name="testSfCalculator6 with data set &quot;con 0&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000068"/>
                    <testcase name="testSfCalculator6 with data set &quot;con decimales&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000074"/>
                    <testcase name="testSfCalculator6 with data set &quot;con decimales .01&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000056"/>
                    <testcase name="testSfCalculator6 with data set &quot;con decimales .99&quot;" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="67" assertions="1" time="0.000044"/>
                  </testsuite>  
                </testsuite>
              </testsuite>
            </testsuites>
            ';

    $reader = new JunitXMLReader();

    // Act
    $report = $reader->parse($xml);


    // Expected
    $rootSuite = $report->getTestSuites()[0];

    $suiteWithFailedTests = $rootSuite->getChildSuites()[0]->getChildSuites()[0];

    self::assertCount(8, $suiteWithFailedTests->getTestCases());
    self::assertEquals(TestCase::Failed, $suiteWithFailedTests->getTestCases()[0]->getStatus());
    self::assertEquals(TestCase::Failed, $suiteWithFailedTests->getTestCases()[1]->getStatus());
    self::assertEquals(TestCase::Failed, $suiteWithFailedTests->getTestCases()[2]->getStatus());
    self::assertEquals(TestCase::Passed, $suiteWithFailedTests->getTestCases()[3]->getStatus());
    self::assertEquals(TestCase::Passed, $suiteWithFailedTests->getTestCases()[4]->getStatus());
    self::assertEquals(TestCase::Passed, $suiteWithFailedTests->getTestCases()[5]->getStatus());
    self::assertEquals(TestCase::Passed, $suiteWithFailedTests->getTestCases()[6]->getStatus());
    self::assertEquals(TestCase::Passed, $suiteWithFailedTests->getTestCases()[7]->getStatus());

    // Mensajes de fallo
    self::assertStringContainsString('Mensaje del programador en el assert', $suiteWithFailedTests->getTestCases()[0]->getMessage());
    self::assertStringContainsString('Failed asserting that 20.99 matches expected 20.01.', $suiteWithFailedTests->getTestCases()[0]->getMessage());
    self::assertNull($suiteWithFailedTests->getTestCases()[3]->getMessage());
  }

  /**
   * @test Estructura de una suite con tests skipped
   */
  public function testSkipped() {
    // Given
    $xml = '<testsuites>
              <testsuite name="/Users/carlos/mamp/PruebasUnitarias/tests" tests="114" assertions="125" errors="0" warnings="0" failures="3" skipped="4" time="0.022517">
                <testsuite name="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" tests="21" assertions="20" errors="0" warnings="0" failures="3" skipped="1" time="0.008897">
                  <testcase name="testStringDiffDateOneMinuteOfDifference" class="AppExtensionTest" classname="AppExtensionTest" file="/Users/carlos/mamp/PruebasUnitarias/tests/AppExtensionTest.php" line="109" assertions="0" time="0.004860">
                    <skipped/>
                  </testcase>
                </testsuite>
              </testsuite>
            </testsuites>
            ';

    $reader = new JunitXMLReader();

    // Act
    $report = $reader->parse($xml);


    // Expected
    $rootSuite = $report->getTestSuites()[0];

    $suiteWithSkippedTest = $rootSuite->getChildSuites()[0];

    self::assertCount(1, $suiteWithSkippedTest->getTestCases());
    self::assertEquals(TestCase::SKIPPED, $suiteWithSkippedTest->getTestCases()[0]->getStatus());
  }

}