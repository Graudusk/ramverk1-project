<?php

namespace Erjh17\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Erjh17\Question\Question;
use Erjh17\User\UserSecurity;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $question = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $question->id,
                ],

                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => html_entity_decode($question->title),
                ],

                "question" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "value" => html_entity_decode($question->question),
                ],

                "tags" => [
                    "type" => "text",
                    "value" => html_entity_decode($question->tags),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return Question
     */
    public function getItemDetails($id) : object
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);

        $security = new UserSecurity($this->di);
        $security->userAuth($question->user);
        return $question;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $this->form->value("id"));
        $question->title  = $this->form->value("title");
        $question->question  = $this->form->value("question");
        $question->tags  = $this->form->value("tags");
        $question->user  = $this->getUserId();
        $question->slug  = $question->slugify($this->form->value("title"));
        $question->updated  = date("Y-m-d H:i:s");
        $question->save();
        return true;
    }

    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return Book
     */
    public function getUserId()
    {
        return $this->di->session->get('login')['id'];
    }

    public function userAuth($user) {
        // var_dump($user);
        // var_dump($this->di->session->get("login")['id']);
        if ($this->di->session->get("login") && $this->di->session->get("login")['id'] == $user) {
            // return true;
        } else {
            // return $this->di->get("response")->redirect("user/login");
        }
    }


    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("question")->send();
    //     //$this->di->get("response")->redirect("question/update/{$question->id}");
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
