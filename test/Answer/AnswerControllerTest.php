<?php

namespace Erjh17\Answer;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the AnswerController.
 */
class AnswerControllerTest extends TestCase
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
        $this->controller = new AnswerController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }
    /**
     * Test the route "index".
     */
    public function testWriteAction()
    {
        // $controller = new AnswerController();
        // $controller->initialize();
        $res = $this->controller->writeAction(1);
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertEquals("Answer question", $res);


        // $res = $this->controller->indexAction();

        $body = $res->getBody();
        $exp = "<title>Answer question | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Delete".
     */
    public function testDeleteAction()
    {
        // $controller = new AnswerController();
        // $controller->initialize();
        $res = $this->controller->deleteAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertEquals("Answer question", $res);


        // $res = $this->controller->indexAction();

        $body = $res->getBody();
        $exp = "<h1>Delete an answer</h1>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Update".
     */
    public function testUpdateAction()
    {
        // $controller = new AnswerController();
        // $controller->initialize();
        $res = $this->controller->updateAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertEquals("Answer question", $res);


        // $res = $this->controller->indexAction();

        $body = $res->getBody();
        $exp = "<h1>Update answer</h1>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Comment".
     */
    public function testCommentAction()
    {
        // $controller = new AnswerController();
        // $controller->initialize();
        $res = $this->controller->commentAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertEquals("Answer question", $res);


        // $res = $this->controller->indexAction();

        $body = $res->getBody();
        $exp = "<h1>Comment answer</h1>";
        $this->assertContains($exp, $body);
    }

    // /**
    //  * Test the route "info".
    //  */
    // public function testInfoActionGet()
    // {
    //     $controller = new SampleController();
    //     $controller->initialize();
    //     $res = $controller->infoActionGet();
    //     $this->assertContains("db is active", $res);
    // }



    // /**
    //  * Test the route "dump-di".
    //  */
    // public function testDumpDiActionGet()
    // {
    //     // Setup di
    //     $di = new DIFactoryConfig();
    //     $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

    //     // Setup the controller
    //     $controller = new SampleController();
    //     $controller->setDI($di);
    //     $controller->initialize();

    //     // Do the test and assert it
    //     $res = $controller->dumpDiActionGet();
    //     $this->assertContains("di contains", $res);
    //     $this->assertContains("configuration", $res);
    //     $this->assertContains("request", $res);
    //     $this->assertContains("response", $res);
    // }
}
