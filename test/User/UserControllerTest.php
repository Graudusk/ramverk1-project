<?php

namespace Erjh17\User;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the UserController.
 */
class UserControllerTest extends TestCase
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
            'name' => "Eric",
            'id' => "2",
            'email' => "123@123.com"
        );
        $_SERVER["SERVER_NAME"] = "test";

        $this->di->get("session")->set('login', $sessionUser);
        // Setup the controller
        $this->controller = new UserController();
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
        $exp = "<title>Show all users | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "View".
     */
    public function testViewAction()
    {
        $res = $this->controller->viewAction(2);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>User profile page | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Create".
     */
    public function testCreateAction()
    {
        $res = $this->controller->createAction(1);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Register user | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Login".
     */
    public function testLoginAction()
    {
        $res = $this->controller->loginAction(1);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Login on site | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Profile".
     */
    public function testProfileAction()
    {
        $res = $this->controller->ProfileAction(1);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>User profile page | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Edit".
     */
    public function testEditAction()
    {
        $res = $this->controller->editAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Update user | Travelers' i</title>";
        $this->assertContains($exp, $body);
    }



    /**
     * Test the route "Logout".
     */
    public function testLogoutAction()
    {
        $res = $this->controller->logoutAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        // $body = $res->getBody();
        // $exp = "<title>Update user | Travelers' i</title>";
        // $this->assertContains($exp, $body);
    }


    /*
    create
    login
    profile
    edit
    logout

     */
}
