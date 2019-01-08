<?php

namespace Erjh17\Tag;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the TagController.
 */
class TagControllerTest extends TestCase
{
    
    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;


        $sessionUser = array(
            'name' => "admin",
            'id' => "1",
            'email' => "test@test.com"
        );
        $_SERVER["SERVER_NAME"] = "test";

        $this->di->get("session")->set('login', $sessionUser);
        // Setup the controller
        $this->controller = new TagController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        // $controller = new TagController();
        // $controller->initialize();
        $res = $this->controller->IndexActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertEquals("Tag Tag", $res);


        // $res = $this->controller->indexAction();

        $body = $res->getBody();
        $exp = "<title>Show all tags | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }
}
