<?php

namespace Erjh17\Comment;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $user;
    public $text;
    public $post;
    public $type;
    public $created;
    public $updated;


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
    public function findAllComments($value)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select("Comment.*, User.name")
                        ->from($this->tableName)
                        ->join("User", "User.id = user")
                        ->where("post = ? AND type = ?")
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }


    public function getUserQuestionComments($user)
    {
        $this->checkDb();
        $params = [$user];
        return $this->db->connect()
                        ->select("Comment.*, User.name, Question.*")
                        ->from($this->tableName)
                        ->where("Comment.user = ?")
                        ->join("User", "User.id = Comment.user")
                        // ->join("Answer", "Answer.id = Comment.post AND Comment.type = 'answer'")
                        ->join("Question", "Question.id = Comment.post AND Comment.type = 'question'")
                        ->orderBy("updated, created DESC")
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }

    public function getUserAnswerComments($user)
    {
        $this->checkDb();
        $params = [$user];
        return $this->db->connect()
                        ->select("Comment.*, User.name, Question.*")
                        ->from($this->tableName)
                        ->where("Comment.user = ?")
                        ->join("User", "User.id = Comment.user")
                        ->join("Answer", "Answer.id = Comment.post AND Comment.type = 'answer'")
                        ->join("Question", "Question.id = Answer.question")
                        ->orderBy("updated, created DESC")
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }
}
