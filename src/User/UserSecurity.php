<?php

namespace Erjh17\User;

// use Anax\Commons\ContainerInjectableInterface;
// use Anax\Commons\ContainerInjectableTrait;
use Psr\Container\ContainerInterface;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserSecurity
{
    // use ContainerInjectableTrait;


    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        $this->di = $di;
        // parent::__construct($di);
    }

    /**
     * @var $data description
     */
    //private $data;



    /**
     * Checks wether a user is logged in.
     *
     * @param number $level the user level to check for.
     *
     * @return true | redirect to start page
     */
    public function auth()
    {
        if ($this->di->session->get("login")) {
            return true;
        } else {
            return $this->di->get("response")->redirect("user/login");
        }
    }

    /**
     * Checks wether a user is logged in.
     *
     * @param number $level the user level to check for.
     *
     * @return true | redirect to start page
     */
    public function userAuth($user)
    {
        if ($this->di->session->get("login")["id"] == $user) {
            return true;
        } else {
            return $this->di->get("response")->redirect("");
        }
    }
}
