<?php

namespace Erjh17\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Erjh17\User\HTMLForm\UserLoginForm;
use Erjh17\User\HTMLForm\CreateUserForm;
use Erjh17\User\HTMLForm\EditUserForm;
use Erjh17\User\UserSecurity;
use Erjh17\Question\Question;
use Erjh17\Comment\Comment;
use Erjh17\Answer\Answer;
use Erjh17\Tag\Tag;
use Michelf\MarkdownExtra;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
     * [indexActionGet description]
     * @return object [description]
     */
    public function indexActionGet() : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $users = $user->getUsers(3);

        foreach ($users as $value) {
            $value->avatar = $user->getGravatar($value->email, true, 40);
        }

        $page->add("user/view-all", [
            "users" => $users,
        ]);

        return $page->render([
            "title" => "Show all users",
        ]);
    }

    /**
     * [loginAction description]
     * @return object rendered page
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("user/login", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Login on site",
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
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("user/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Register user",
        ]);
    }


    /**
     * [profileAction description]
     * @return object [description]
     */
    public function profileAction() : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $session = $this->di->get("session");
        $userId = $session->get('login')['id'];

        if (!$userId) {
            return $this->di->get('response')->redirect("user/login");
        }
        return $this->di->get('response')->redirect("user/view/$userId");
    }


    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function editAction() : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $id = $session->get('login')['id'];

        $form = new EditUserForm($this->di, $id);
        $form->check();

        $page->add("user/edit", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update user",
        ]);
    }

    public function logoutAction()
    {
        $this->di->get('session')->set('login', null);
        return $this->di->get('response')->redirect("");
    }

    /**
     * [viewAction description]
     * @param  integer $id [description]
     * @return object     [description]
     */
    public function viewAction($id) : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);



        if (!$user->id) {
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

        $userId = $this->di->get("session")->get('login')['id'];
        $isUser = $user->id === $userId;

        //hämta frågor
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $questions = $question->getUserQuestions($id);

        foreach ((array)$questions as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $tags = $tag->findAllWhere("question = ?", $item->id);
            $item->tags = $tags;
        }


        //hämta svar
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->getUserAnswers($id);

        foreach ($answers as $answer) {
            $answer->html = MarkdownExtra::defaultTransform($answer->answer);
        }

        //hämta kommentarer
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $questionComments = $comment->getUserQuestionComments($id);
        $answerComments = $comment->getUserAnswerComments($id);

        foreach ($questionComments as $comment) {
            $comment->html = MarkdownExtra::defaultTransform($comment->text);
        }
        foreach ($answerComments as $comment) {
            $comment->html = MarkdownExtra::defaultTransform($comment->text);
        }

        $page->add("user/profile", [
            "user" => $user,
            "isUser" => $isUser,
            "avatar" => $user->getGravatar($user->email, true, 200),
            "questions" => $questions,
            "answers" => $answers,
            "questionComments" => $questionComments,
            "answerComments" => $answerComments
        ]);


        return $page->render([
            "title" => "User profile page",
        ]);
    }
}
