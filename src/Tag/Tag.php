<?php

namespace Erjh17\Tag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Tag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tag";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag;
    public $slug;
    public $question;

    public function getTags($limit = 1000000)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select("tag, slug, count(tag) as count")
                        ->from($this->tableName)
                        ->groupBy("tag")
                        ->limit($limit)
                        ->orderBy("count DESC")
                        ->execute()
                        ->fetchAll();
    }
}
