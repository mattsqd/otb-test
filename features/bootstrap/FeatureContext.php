<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\AfterStepScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements SnippetAcceptingContext {

  /**
   * @AfterStep
   */
  public function printLastResponseOnError(AfterStepScope $event)
  {
    var_dump($event->getTestResult()->getResultCode());
    var_dump(!$event->getTestResult()->isPassed());
    if (!$event->getTestResult()->isPassed()) {
      $this->saveDebugScreenshot($event);
    }
  }

  /**
   * @AfterStep
   */
  public function saveDebugScreenshot(AfterStepScope $event)
  {
    $driver = $this->getSession()->getDriver();

    if (!$driver instanceof Selenium2Driver) {
      return;
    }

    if (!getenv('BEHAT_SCREENSHOTS')) {
      return;
    }

    $filename = rawurlencode($event->getFeature()->getTitle() . '-' . $event->getStep()->getText()) . '.png';

    $path = '/var/behat_screenshots';

    if (!file_exists($path)) {
      $path = './behat_screenshots';
      if (!file_exists($path)) {
        mkdir($path);
      }
    }

    $this->saveScreenshot($filename, $path);
  }

  /**
   * @When I wait for Ajax to finish
   */
  public function iWaitForAjaxToFinish()
  {
    $time = 5000; // time should be in milliseconds
    $this->getSession()->wait($time, '(0 === jQuery.active)');
  }

}
