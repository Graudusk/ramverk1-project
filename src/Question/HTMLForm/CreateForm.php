<?php

namespace Erjh17\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Erjh17\Question\Question;
use Erjh17\Tag\Tag;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Question data",
            ],
            [
                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "question" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type" => "text",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create question",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        // var_dump($this->form->value("title"));
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title  = $this->form->value("title");
        $question->question  = $this->form->value("question");

        $question->user  = $this->getUserId();
        $question->slug  = $question->slugify($this->form->value("title"));

        $query = new Question();
        $query->setDb($this->di->get("dbqb"));
        $res = $query->findAllCol("slug");

        $slugs = array();
        foreach ($res as $value) {
            array_push($slugs, $value->slug);
        }

        $counter = 1;
        $needle = $question->slug;
        while (in_array($needle, $slugs)) {
            $needle = $question->slug . "-$counter";
            $counter++;
        }
        $question->slug = $needle;
        $question->created  = date("Y-m-d H:i:s");
        $question->save();

        $questionId = $question->getLastInsertId();
        foreach (explode(",", $this->form->value("tags")) as $value) {
            if ($value) {
                $tag = new Tag();
                $tag->setDb($this->di->get("dbqb"));
                $tag->slug  = $question->slugify($value);
                $tag->tag = $value;
                $tag->question = $questionId;
                $tag->save();
            }
        }
        return true;
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->di->session->get('login')['id'];
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
