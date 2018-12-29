<?php

namespace Erjh17\Answer;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Erjh17\Answer\HTMLForm\CreateForm;
use Erjh17\Answer\HTMLForm\AnswerForm;
use Erjh17\Answer\HTMLForm\EditForm;
use Erjh17\Answer\HTMLForm\DeleteForm;
use Erjh17\Answer\HTMLForm\UpdateForm;
use Erjh17\Comment\HTMLForm\CommentForm;
use Erjh17\User\UserSecurity;
use Erjh17\Question\Question;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class AnswerController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet(int $question) : object
    {
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $page->add("answer/crud/view-all", [
            "items" => $answer->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("answer/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di);
        $form->check();

        $page->add("answer/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("answer/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }


    /**
     * Show item.
     *
     * @return object as a response object
     */
    public function writeAction(int $questionId) : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");
        $form = new AnswerForm($this->di, $questionId);
        $form->check();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $questionId);
        // var_dump($question);

        $page->add("question/crud/answer", [
            "question" => $question,
            "form" => $form->getHTML()
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }


    /**
     * Show item.
     *
     * @return object as a response object
     */
    public function commentAction(int $answerId) : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");
        $form = new CommentForm($this->di, $answerId, "answer");
        $form->check();

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $answerId);

        $page->add("answer/crud/comment", [
            "answer" => $answer,
            "form" => $form->getHTML()
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}
