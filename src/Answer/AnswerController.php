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
use Erjh17\Comment\Comment;
use Michelf\MarkdownExtra;

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



    // /**
    //  * Show all items.
    //  *
    //  * @return object as a response object
    //  */
    // public function indexActionGet(int $question) : object
    // {
    //     $page = $this->di->get("page");
    //     $answer = new Answer();
    //     $answer->setDb($this->di->get("dbqb"));

    //     $page->add("answer/crud/view-all", [
    //         "items" => $answer->findAll(),
    //     ]);

    //     return $page->render([
    //         "title" => "A collection of items",
    //     ]);
    // }



    // /**
    //  * Handler with form to create a new item.
    //  *
    //  * @return object as a response object
    //  */
    // public function createAction() : object
    // {
    //     $page = $this->di->get("page");
    //     $form = new CreateForm($this->di);
    //     $form->check();

    //     $page->add("answer/crud/create", [
    //         "form" => $form->getHTML(),
    //     ]);

    //     return $page->render([
    //         "title" => "Create a item",
    //     ]);
    // }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction($id) : object
    {
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di, $id);
        $form->check();

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $id);

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $answer->question);


        $page->add("answer/crud/delete", [
            "question" => $question,
            "answer" => $answer,
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

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $id);

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $answer->question);

        $page->add("answer/crud/update", [
            "question" => $question,
            "answer" => $answer,
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
        $question->getQuestionObject("Question.id", $questionId);
        $questionHtml = MarkdownExtra::defaultTransform($question->question);
        // var_dump($question);

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $answers = $answer->findAllAnswers($question->id);

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        $questionComments = $comment->findAllWhereJoin("Comment.*, User.name", "post = ? AND type = ?", [$question->id, "question"], "User", "User.id = user");

        foreach ($questionComments as $comment) {
            $comment->html = MarkdownExtra::defaultTransform($comment->text);
        }

        foreach ((array)$answers as $key => $value) {
            $value->html = MarkdownExtra::defaultTransform($value->answer);
            $answerComment = new Comment();
            $answerComment->setDb($this->di->get("dbqb"));

            $answers[$key]->comments = $answerComment->findAllComments([$value->id, "answer"]);
            foreach ($answers[$key]->comments as $comment) {
                $comment->html = MarkdownExtra::defaultTransform($comment->text);
            }
        }

        $page->add("question/crud/answer", [
            "question" => $question,
            "form" => $form->getHTML(),
            "comments" => $questionComments,
            "answers" => $answers,
            "questionHtml" => $questionHtml
        ]);

        return $page->render([
            "title" => "Answer question",
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
        // $answer->find("id", $answerId);
        $answer->findAnswer($answerId);
        $answerHtml = MarkdownExtra::defaultTransform($answer->answer);


        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        $comments = $comment->findAllWhereJoin("Comment.*, User.name", "post = ? AND type = ?", [$answer->id, "answer"], "User", "User.id = user");

        foreach ($comments as $comment) {
            $comment->html = MarkdownExtra::defaultTransform($comment->text);
        }

        $page->add("answer/crud/comment", [
            "answer" => $answer,
            "answerHtml" => $answerHtml,
            "form" => $form->getHTML(),
            "comments" => $comments
        ]);

        return $page->render([
            "title" => "Comment answer",
        ]);
    }
}
