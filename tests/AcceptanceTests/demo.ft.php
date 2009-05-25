<?php
/**
 * TODO: Functional Tests for demo page ... using PHPUnit + selenium ... maybe even cruisecontrol :)
 */


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*firefox");
    $this->setBrowserUrl("http://localhost/");
  }

  function testMyTestCase()
  {
    $this->open("/~pjkix/projects/short-urls/demo.phtml");
    try {
        $this->assertTrue($this->isTextPresent("exact:http://tinyurl.com/kotu"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
  }
}
?>