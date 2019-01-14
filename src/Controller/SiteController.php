<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Route\Exception\NotFoundException;
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
     * Add internal routes for 403, 404 and 500 that provides a page with
     * error information, using the default page layout.
     *
     * @param string $message with details.
     *
     * @throws Anax\Route\Exception\NotFoundException

     * @return object as the response.
     */
    public function catchAll(...$args) : object
    {
        $title = " | Anax";
        $pages = [
            "403" => [
                "Anax 403: Forbidden",
                "You are not permitted to do this."
            ],
            "404" => [
                "Anax 404: Not Found",
                "The page you are looking for is not here."
            ],
            "500" => [
                "Anax 500: Internal Server Error",
                "An unexpected condition was encountered."
            ],
        ];

        $path = $this->di->get("router")->getMatchedPath();
        if (!array_key_exists($path, $pages)) {
            throw new NotFoundException("Internal route for '$path' is not found.");
        }

        $page = $this->di->get("page");
        $page->add(
            "anax/v2/error/default",
            [
                "header" => $pages[$path][0],
                "text" => $pages[$path][1],
            ]
        );

        return $page->render([
            "title" => $pages[$path][0] . $title
        ], $path);
    }

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

        $page->add("site/flash", [
            "src" => "img/departures.png",
            "text" => "Travelers' <i class='fas fa-info-circle'></i>",
        ], "flash");

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

        $user = new User();
        $smith = $user->getGravatar("smith@travelers.com", true, 100);
        $locke = $user->getGravatar("locke@travelers.com", true, 100);
        $homer = $user->getGravatar("homer@travelers.com", true, 100);
        $johansson = $user->getGravatar("johansson@travelers.com", true, 100);

        $page->add("site/flash", [
            "src" => "img/airplane.jpg",
            "text" => "About us",
        ], "flash");

        $page->add("site/about", [
            "smith" => $smith,
            "locke" => $locke,
            "homer" => $homer,
            "johansson" => $johansson
        ]);

        return $page->render([
            "title" => "About"
        ]);
    }
}
