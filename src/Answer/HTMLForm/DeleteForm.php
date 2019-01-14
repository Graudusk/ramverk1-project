<?php

namespace Erjh17\Answer\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Erjh17\Answer\Answer;
use Erjh17\Question\Question;

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
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $answer = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Delete an answer",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $answer->id,
                ],

                "question" => [
                    "type" => "hidden",
                    "value" => $answer->question,
                    "validation" => ["not_empty"],
                    "readonly" => true,
                ],

                "answer" => [
                    "type" => "textarea",
                    "value" => $answer->answer,
                    "validation" => ["not_empty"],
                    "readonly" => true,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Delete answer",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Answer
     */
    public function getItemDetails($id) : object
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $id);
        return $answer;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $this->form->value("id"));
        $answer->delete();
        return true;
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Question
     */
    public function getQuestionDetails($id) : object
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);
        return $question;
    }


    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $question = $this->getQuestionDetails($this->form->value("question"));
        $this->di->get("response")->redirect("question/show/{$question->slug}")->send();
        // $this->di->get("response")->redirect("question")->send();
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
