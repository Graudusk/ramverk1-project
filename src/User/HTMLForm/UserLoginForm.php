<?php

namespace Erjh17\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Erjh17\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "User Login"
            ],
            [
                "email" => [
                    "type"        => "email",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],
                        
                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $email       = $this->form->value("email");
        $password      = $this->form->value("password");

        // Try to login
        $db = $this->di->get("dbqb");
        $db->connect();
        $user = $db->select("id, password, email, name")
                   ->from("User")
                   ->where("email = ?")
                   ->execute([$email])
                   ->fetch();

        // $user is null if user is not found
        if (!$user || !password_verify($password, $user->password)) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $sessionUser = array(
            'name' => $user->name,
            'id' => $user->id,
            'email' => $user->email
        );

        $this->di->get("session")->set('login', $sessionUser);
        // $this->form->addOutput("User logged in.");
        return $this->di->get("response")->redirect("user/profile");
        // return true;
    }
}
