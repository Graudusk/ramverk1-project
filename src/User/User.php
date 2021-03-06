<?php
namespace Erjh17\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $email;
    public $name;
    public $password;
    public $created;
    public $updated;
    public $deleted;
    public $active;


    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the email and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $email  email to check.
     * @param string $password the password to use.
     *
     * @return boolean true if email and password matches, else false.
     */
    // public function verifyPassword($email, $password)
    // {
    //     $this->find("email", $email);
    //     return password_verify($password, $this->password);
    // }


    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boolean $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function getGravatar($email, $img = false, $size = 80, $default = 'identicon', $rating = 'g')
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$size&d=$default&r=$rating";
        if ($img) {
            $url = '<img src="' . $url . '"';
            $url .= ' />';
        }
        return $url;
    }


    public function getUsers($limit = 1000000)
    {
        $this->checkDb();
        return $this->db->connect()
                        // ->select("User.*, count(Question.id) as qcount, count(Answer.id) as acount, count(Comment.id) as ccount")
                        ->select("
    User.id,
    User.name,
    User.email,
    (SELECT count(Question.id) FROM Question WHERE Question.user = User.id) as qcount,
    (SELECT count(Answer.id) FROM Answer WHERE Answer.user = User.id) as acount,
    (SELECT count(Comment.id) FROM Comment WHERE Comment.user = User.id) as ccount,
    -- count(User.id) as countsum
    ((SELECT count(Question.id) FROM Question WHERE Question.user = User.id) +
    (SELECT count(Answer.id) FROM Answer WHERE Answer.user = User.id) +
    (SELECT count(Comment.id) FROM Comment WHERE Comment.user = User.id)) as countsum")
                        ->from($this->tableName)
                        ->leftJoin("Question", "User.id = Question.user")
                        ->groupBy("User.id")
                        ->limit($limit)
                        ->orderBy("countSum DESC")
                        ->execute()
                        ->fetchAll();
                        // ->getSql();
    }
}
