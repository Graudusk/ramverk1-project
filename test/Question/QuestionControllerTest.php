<?php

namespace Erjh17\Question;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the QuestionController.
 */
class QuestionControllerTest extends TestCase
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
        $this->controller = new QuestionController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $res = $this->controller->IndexActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Show all questions | Travellers</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Create".
     */
    public function testCreateAction()
    {
        $res = $this->controller->createAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Ask a question | Travellers</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Show".
     */
    public function testShowAction()
    {
        $res = $this->controller->showActionGet("what-to-do-in-japan");
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $exp = "<h1>What to do in Japan?</h1>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "answer".
     */
    public function testAnswerAction()
    {
        $res = $this->controller->AnswerAction(1);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Answer question | Travellers</title>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Delete".
     */
    public function testDeleteAction()
    {
        $res = $this->controller->deleteAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<h1>Delete a question</h1>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Update".
     */
    public function testUpdateAction()
    {
        $res = $this->controller->updateAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<h1>Update a question</h1>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Comment".
     */
    public function testTagAction()
    {
        $res = $this->controller->tagActionGet("tokyo");
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Show questions with tag | Travellers</title>";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "Comment".
     */
    public function testCommentAction()
    {
        $res = $this->controller->commentAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Comment question | Travellers</title>";
        $this->assertContains($exp, $body);
    }
}
