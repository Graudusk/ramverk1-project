<?php

namespace Erjh17\Answer;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answer";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $answer;
    public $user;
    public $question;
    public $created;
    public $updated;
    // "id" INTEGER PRIMARY KEY NOT NULL,
    // -- "title" TEXT NOT NULL,
    // "text" TEXT NOT NULL,
    // "user" INT,
    // "question" INT,
    // "created" TIMESTAMP,
    // "updated" DATETIME
    // 
    // 


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

}
