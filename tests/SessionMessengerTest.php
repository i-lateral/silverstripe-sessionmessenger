<?php

/**
 * Test the functionality of setting session messages
 *
 * @package sessionmessager
 * @subpackage tests
 */
class SessionMessengerTest extends SapphireTest
{

	/**
	 * Test that a session message is set correctly
	 */
	public function testGoodMessageSet()
    {
		$message = "This is a good message";

        // set a message
        $controller = singleton("Controller");
        $controller->setSessionMessage("success", $message);
        $session = Session::get("Site.Message");

        $this->assertArrayHasKey("Message", $session);
		$this->assertEquals($session["Message"], $message);
		$this->assertEquals($session["Type"], "success");
	}


	/**
	 * Test that a session message is set correctly
	 */
	public function testBadMessageSet()
    {
        $message = "This is a bad message";

        // set a message
        $controller = singleton("Controller");
        $controller->setSessionMessage("error", $message);
        $session = Session::get("Site.Message");

        $this->assertArrayHasKey("Message", $session);
		$this->assertEquals($session["Message"], $message);
		$this->assertEquals($session["Type"], "error");
	}

	/**
	 * Determine if the session message is rendered correctly
	 */
	public function testRenderedMessage()
    {
        $message = "This is a message";

        // set a message
        $controller = singleton("Controller");
        $controller->setSessionMessage("success", $message);
        $rendered = $controller->getSessionMessage();
        $session = Session::get("Site.Message");

		// Session should be cleared
        $this->assertNull($session);

		// Check the html rendered correctly
		$this->assertContains($message, $rendered);
	}
}