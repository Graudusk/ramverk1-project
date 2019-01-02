<?php

namespace Erjh17\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Erjh17\Question\HTMLForm\CreateForm;
use Erjh17\Question\HTMLForm\DeleteForm;
use Erjh17\Question\HTMLForm\UpdateForm;
use Erjh17\Answer\HTMLForm\AnswerForm;
use Erjh17\Comment\HTMLForm\CommentForm;
use Erjh17\Answer\Answer;
use Erjh17\Comment\Comment;
use Erjh17\Tag\Tag;
use Erjh17\User\UserSecurity;
use Michelf\MarkdownExtra;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
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
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        // $questions = $question->findAll();
        $questions = $question->getQuestions();
        // $questionHtml = MarkdownExtra::defaultTransform($question->question);

        foreach ((array)$questions as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $tags = $tag->findAllWhere("question = ?", $item->id);
            // $tags = explode(',', $item->tags);
            // $html = "";
            // foreach ($tags as $tag) {
            //     $tagUrl = $this->di->get('url')->create("tag/{$tag}");
            //     $html .= "<a class='tag' href='{$tagUrl}'>{$tag}</a>";
            // }
            $item->tags = $tags;
        }

        $page->add("question/crud/view-all", [
            "questions" => $questions,
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
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("question/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create an item",
        ]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di, $id);
        $form->check();

        $page->add("question/crud/delete", [
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
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("question/crud/update", [
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
    public function showActionGet($slug) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        // $question->find("slug", $slug);
        $question->getQuestionObject("slug", $slug);
        $questionHtml = MarkdownExtra::defaultTransform($question->question);

        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAllWhere("question = ?", $question->id);
        // var_dump($tags);
        
        $userId = $this->di->session->get('login')['id'];
        $question->isUser = $question->user === $userId;

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllAnswers($question->id);

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        $questionComments = $comment->findAllComments([$question->id, "question"]);

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

        $page->add("question/crud/show", [
            "question" => $question,
            "comments" => $questionComments,
            "answers" => $answers,
            "questionHtml" => $questionHtml,
            "tags" => $tags
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
    public function answerAction(int $questionId) : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");
        $form = new AnswerForm($this->di, $questionId);
        $form->check();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $questionId);

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
    public function commentAction(int $questionId) : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");
        $form = new CommentForm($this->di, $questionId, "question");
        $form->check();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $questionId);

        $page->add("question/crud/comment", [
            "question" => $question,
            "form" => $form->getHTML()
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Show all items by tag.
     *
     * @return object as a response object
     */
    public function tagActionGet($searchtag) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->getQuestionsFromTags($searchtag);

        foreach ((array)$questions as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $tags = $tag->findAllWhere("question = ?", $item->id);
            $item->tags = $tags;
        }

        $page->add("question/crud/tag-view", [
            "questions" => $questions,
            "tag" => $searchtag
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}
