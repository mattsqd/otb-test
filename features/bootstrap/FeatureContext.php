<?php

use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\AfterStepScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements SnippetAcceptingContext {

  /**
   * Check if the current step failed and take a screen shot.
   *
   * @param \Behat\Behat\Hook\Scope\AfterStepScope $event
   *
   * @AfterStep
   */
  public function printLastResponseOnError(AfterStepScope $event)
  {
    if (!$event->getTestResult()->isPassed()) {
      $this->saveDebugScreenshot($event);
    }
  }

  /**
   * Save a screen shot of the current step.
   *
   * @param \Behat\Behat\Hook\Scope\AfterStepScope $event
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

    $path = './behat_screenshots';
    if (!file_exists($path)) {
      mkdir($path);
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
