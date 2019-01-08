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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function profileAction() : object
    {

        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $userId = $this->di->session->get('login')['id'];
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
        $page = $this->di->get("page");
        $id = $this->di->session->get('login')['id'];

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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function viewAction($id) : object
    {
        $userSecurity = new UserSecurity($this->di);
        $userSecurity->auth();

        $page = $this->di->get("page");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        $userId = $this->di->session->get('login')['id'];
        $user->isUser = $user->id === $userId;


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
            "avatar" => $user->getGravatar($user->email, true, 200),
            "questions" => $questions,
            "questionComments" => $questionComments,
            "answerComments" => $answerComments
        ]);


        return $page->render([
            "title" => "User profile page",
        ]);
    }
}
