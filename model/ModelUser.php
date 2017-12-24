<?php

require_once File::build_path(array('model', 'Model.php'));

class ModelUser extends Model
{

    protected static $object = 'User';
    protected static $primary = 'mailUser';

    private $mailUser;
    private $passwordUser;
    private $admin;

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return mixed
     */
    public function getMailUser()
    {
        return $this->mailUser;
    }

    /**
     * @return mixed
     */
    public function getPasswordUser()
    {
        return $this->passwordUser;
    }

    /**
     * @return mixed
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param mixed $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    public function __construct($mail = null, $password = null, $admin = null)
    {
        if (!is_null($admin) && !is_null($mail) && !is_null($password)) {
            $this->admin = $admin;
            $this->mailUser = $mail;
            $this->passwordUser = $password;
        }
    }

    public static function checkPassword($login, $mot_de_passe_chiffre)
    {
        $user = ModelUser::select($login);
        if (!$user) return false;
        if ($user->getPasswordUser() == $mot_de_passe_chiffre) {
            return true;
        }
        return false;
    }

    public static function update($data)
    {
        try {
            $sql = 'UPDATE User SET mailUser=:mailUser , passwordUser=:passwordUser WHERE mailUser=:ancienMail';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function setAdmin($mailUser)
    {
        try {
            $sql = 'UPDATE User SET admin=1 WHERE mailUser=:mailUser';
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "mailUser" => $mailUser
            );
            $req_prep->execute($values);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}