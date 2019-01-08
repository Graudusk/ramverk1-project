<?php

namespace Erjh17\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Erjh17\Question\Question;
use Erjh17\Answer\Answer;
use Erjh17\Tag\Tag;
use Erjh17\Comment\Comment;
use Erjh17\User\UserSecurity;

/**
 * Form to delete an item.
 */
class DeleteForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $id)
    {
        parent::__construct($di);
        $question = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Delete question",
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
                    "readonly" => true,
                    "value" => html_entity_decode($question->title),
                ],

                "question" => [
                    "type" => "textarea",
                    "readonly" => true,
                    "validation" => ["not_empty"],
                    "value" => html_entity_decode($question->question),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Delete",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
        /*$this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Delete an item",
            ],
            [
                "select" => [
                    "type"        => "select",
                    "label"       => "Select item to delete:",
                    "options"     => $this->getAllItems(),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Delete item",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );*/
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
     * Get all items as array suitable for display in select option dropdown.
     *
     * @return array with key value of all items.
     */
    // protected function getAllItems() : array
    // {
    //     $question = new Question();
    //     $question->setDb($this->di->get("dbqb"));

    //     $questions = ["-1" => "Select an item..."];
    //     foreach ($question->findAll() as $obj) {
    //         $questions[$obj->id] = "{$obj->column1} ({$obj->id})";
    //     }

    //     $security = new UserSecurity($this->di);
    //     $security->userAuth($question->user);

    //     return $questions;
    // }



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
        $question->delete();

        $answers = new Answer();
        $answers->setDb($this->di->get("dbqb"));
        $answers->deleteWhere("question = ?", $this->form->value("id"));

        $tags = new Tag();
        $tags->setDb($this->di->get("dbqb"));
        $tags->deleteWhere("question = ?", $this->form->value("id"));
        
        $comments = new Comment();
        $comments->setDb($this->di->get("dbqb"));
        $comments->deleteWhere("post = ? AND type = 'question'", $this->form->value("id"));

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question")->send();
    }



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
