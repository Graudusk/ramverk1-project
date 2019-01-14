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



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();
    }



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
        $questions = $question->getQuestions();

        foreach ((array)$questions as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $tags = $tag->findAllWhere("question = ?", $item->id);
            $item->tags = $tags;
        }

        $page->add("question/crud/view-all", [
            "questions" => $questions,
        ]);

        return $page->render([
            "title" => "Show all questions",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        // $userSecurity = new UserSecurity($this->di);
        // $userSecurity->auth();
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("question/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Ask a question",
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

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);

        if (!$question) {
            $page = $this->di->get("page");
            $page->add(
                "anax/v2/error/default",
                [
                    "header" => $pages[$path][0],
                    "text" => $pages[$path][1],
                ]
            );

            return $page->render([
                "title" => "Delete an item",
            ]);
        }

        $page->add("question/crud/delete", [
            "question" => $question,
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

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findWhere('id = ?', $id);


        $page->add("question/crud/update", [
            "question" => $question,
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update a question",
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
        $question->getQuestionObject("slug", $slug);

        if (!$question->id) {
            $page = $this->di->get("page");
            $page->add(
                "anax/v2/error/default",
                [
                    "header" => "Anax 404: Not Found",
                    "text" => "The page you are looking for is not here.",
                ]
            );

            return $page->render([
                "title" => "Anax 404: Not Found",
            ]);
        }

        $questionHtml = MarkdownExtra::defaultTransform($question->question);

        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAllWhere("question = ?", $question->id);

        $userId = $this->di->session->get('login')['id'];
        $isUser = $question->user === $userId;

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


            $answers[$key]->isUser = $answers[$key]->user === $userId;

            $answers[$key]->comments = $answerComment->findAllComments([$value->id, "answer"]);
            foreach ($answers[$key]->comments as $comment) {
                $comment->html = MarkdownExtra::defaultTransform($comment->text);
            }
        }

        $page->add("question/crud/show", [
            "isUser" => $isUser,
            "question" => $question,
            "comments" => $questionComments,
            "answers" => $answers,
            "questionHtml" => $questionHtml,
            "tags" => $tags
        ]);

        $title = isset($question->title) ? $question->title : "Show question";

        return $page->render([
            "title" => $title,
        ]);
    }




    /**
     * Show item.
     *
     * @return object as a response object
     */
    public function answerAction(int $questionId) : object
    {
        $page = $this->di->get("page");
        $form = new AnswerForm($this->di, $questionId);
        $form->check();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->getQuestionObject("Question.id", $questionId);

        if (!$question->id) {
            $page = $this->di->get("page");
            $page->add(
                "anax/v2/error/default",
                [
                    "header" => "Anax 404: Not Found",
                    "text" => "The page you are looking for is not here.",
                ]
            );

            return $page->render([
                "title" => "Anax 404: Not Found",
            ]);
        }

        $questionHtml = MarkdownExtra::defaultTransform($question->question);

        $page->add("question/crud/answer", [
            "question" => $question,
            "questionHtml" => $questionHtml,
            "form" => $form->getHTML()
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
    public function commentAction(int $questionId) : object
    {
        $page = $this->di->get("page");
        $form = new CommentForm($this->di, $questionId, "question");
        $form->check();

        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAllWhere("question = ?", $questionId);

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        // $question->find("id", $questionId);
        $question->getQuestionObject("Question.id", $questionId);

        if (!$question->id) {
            $page = $this->di->get("page");
            $page->add(
                "anax/v2/error/default",
                [
                    "header" => "Anax 404: Not Found",
                    "text" => "The page you are looking for is not here.",
                ]
            );

            return $page->render([
                "title" => "Anax 404: Not Found",
            ]);
        }

        $questionHtml = MarkdownExtra::defaultTransform($question->question);

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllAnswers($question->id);

        foreach ((array)$answers as $key => $value) {
            $value->html = MarkdownExtra::defaultTransform($value->answer);
            $answerComment = new Comment();
            $answerComment->setDb($this->di->get("dbqb"));

            $answers[$key]->comments = $answerComment->findAllComments([$value->id, "answer"]);
            foreach ($answers[$key]->comments as $comment) {
                $comment->html = MarkdownExtra::defaultTransform($comment->text);
            }
        }

        $page->add("question/crud/comment", [
            "question" => $question,
            "answers" => $answers,
            "tags" => $tags,
            "form" => $form->getHTML(),
            "questionHtml" => $questionHtml
        ]);

        return $page->render([
            "title" => "Comment question",
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
            "title" => "Show questions with tag",
        ]);
    }
}
