<?php

namespace Erjh17\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Question";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $question;
    public $user;
    public $created;
    public $updated;
    public $slug;

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return array of object of this class
     */
    public function getQuestionObject($type, $slug)
    {
        $this->checkDb();
        $params = [$slug];
        return $this->db->connect()
                        ->select("Question.*, User.name")
                        ->from($this->tableName)
                        ->where("$type = ?")
                        ->join("User", "User.id = Question.user")
                        ->execute($params)
                        ->fetchInto($this);
    }
    public function getQuestions($limit = 1000000)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select("Question.*, User.name")
                        ->from($this->tableName)
                        ->join("User", "User.id = Question.user")
                        ->orderBy("updated DESC, created DESC")
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }


    public function getUserQuestions($user)
    {
        $this->checkDb();
        $params = [$user];
        return $this->db->connect()
                        ->select("Question.*, User.name")
                        ->from($this->tableName)
                        ->where("Question.user = ?")
                        ->join("User", "User.id = Question.user")
                        ->orderBy("updated, created DESC")
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }


    /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return array of object of this class
     */
    public function findAllWhereJoin($columns, $where, $value, $table, $joinCondition)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select($columns)
                        ->from($this->tableName)
                        ->join($table, $joinCondition)
                        ->where($where)
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }


    public function getQuestionsFromTags($tag)
    {
        $this->checkDb();
        $params = [$tag];
        return $this->db->connect()
                        ->select("Tag.*, Question.*, User.name")
                        ->from("Tag")
                        ->where("Tag.slug = ?")
                        ->join("Question", "Question.id = Tag.question")
                        ->join("User", "Question.user = User.id")
                        ->groupBy("Tag.question")
                        ->orderBy("created DESC")
                        ->execute($params)
                        ->fetchAll();
    }




    /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return array of object of this class
     */
    public function findAllCol($columns)
    {
        $this->checkDb();
        // $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select($columns)
                        ->from($this->tableName)
                        // ->where($where)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }

    public function getLastInsertId()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->lastInsertId();
    }
}
