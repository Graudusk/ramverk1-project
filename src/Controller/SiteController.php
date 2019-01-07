<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Erjh17\Question\Question;
use Erjh17\User\UserSecurity;
use Erjh17\Tag\Tag;
use Erjh17\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class SiteController implements ContainerInjectableInterface
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
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->getQuestions(4);

        foreach ((array)$questions as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $tags = $tag->findAllWhere("question = ?", $item->id);
            $item->tags = $tags;
        }

        $popularTag = new Tag();
        $popularTag->setDb($this->di->get("dbqb"));
        $popularTags = $popularTag->getTags(3);

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $users = $user->getUsers(3);

        foreach ($users as $value) {
            $value->avatar = $user->getGravatar($value->email, true, 40);
        }

        // var_dump($users);

        $page->add("site/index", [
            "questions" => $questions,
            "popularTags" => $popularTags,
            "users" => $users
        ]);

        return $page->render([
            "title" => "Home",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function aboutActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("site/about");

        return $page->render([
            "title" => "About",
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
        $question->find("slug", $slug);
        // var_dump($question);

        $page->add("question/crud/show", [
            "item" => $question,
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}
