<?php

namespace Erjh17\User;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the UserController.
 */
class UserTest extends TestCase
{
    
    // Create the di container.
    protected $di;
    protected $user;



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
        $this->user = new User();
        $this->userSecurity = new UserSecurity($this->di);
        // $this->user->setDI($this->di);
        //$this->controller->initialize();
    }



    /**
     * Test the "setPassword"-function.
     */
    public function testSetPasswordAction()
    {
        $this->user->setPassword("test");

        $exp = "";
        $this->assertNotEquals($exp, $this->user->password);
    }



    /**
     * Test the "getGravatar"-function.
     */
    public function testGetGravatarAction()
    {
        $res = $this->user->getGravatar("test@test.com", true, 200);
        $exp = '<img src="https://www.gravatar.com/avatar/b642b4217b34b1e8d3bd915fc65c4452?s=200&d=identicon&r=g" />';
        $this->assertEquals($res, $exp);
    }



    /**
     * Test the "userAuth"-function.
     */
    public function testUserAuthSuccessAction()
    {
        $res = $this->userSecurity->userAuth(2);
        // $this->assertInstanceOf("\Anax\Response\Response", $res);
        $this->assertTrue($res);
    }



    /**
     * Test the "LogoutFail"-function.
     */
    public function testAuthFailAction()
    {
        $this->di->get('session')->set('login', null);
        $res = $this->userSecurity->auth();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertEquals($res, $exp);
    }
}
