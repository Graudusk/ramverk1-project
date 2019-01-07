<?php

namespace Erjh17\Comment\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Erjh17\Comment\Comment;
use Erjh17\Question\Question;
use Erjh17\Answer\Answer;

/**
 * Form to create an item.
 */
class CommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $question, $type)
    {
        parent::__construct($di);
        $post = $type == "question" ? $this->getQuestionDetails($question) : $this->getAnswerDetails($question);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Comment",
            ],
            [
                "post" => [
                    "type" => "hidden",
                    "value" => $post->id,
                    "validation" => ["not_empty"],
                ],

                "type" => [
                    "type" => "hidden",
                    "value" => $type,
                    "validation" => ["not_empty"],
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Send comment",
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
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Question
     */
    public function getAnswerDetails($id) : object
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
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->user  = $this->getUserId();
        $comment->text  = $this->form->value("text");
        $comment->post  = $this->form->value("post");
        $comment->type  = $this->form->value("type");
        $comment->created  = date("Y-m-d H:i:s");
        // var_dump($comment);
        $comment->save();
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



    /**
     * Callback what to do if the form was unsuccessfully submitted, this
     * happen when the submit callback method returns false or if validation
     * fails. This method can/should be implemented by the subclass for a
     * different behaviour.
     */
    public function callbackFail()
    {
        $this->di->get("response")->redirectSelf()->send();
    }
}
