<?php

class User
{
    public $login;
    public $mail;
    public $passwd;
    public $cle;
    public $profile;
    public $creation_date;
    public $status;

    public function __construct($data = null)
    {
        if (is_array($data)) {
			if (isset($data['login']))
				$this->login = $data['login'];
			if (isset($data['mail']))
				$this->mail = $data['mail'];
			if (isset($data['passwd']))
				$this->passwd = $data['passwd'];
            if (isset($data['cle']))
                $this->cle = $data['cle'];
            $this->profile = 'USER';
            $this->status = 'NOT_ACTIVATED';
        }
    }

    public function checkUserNonexistant($db)
    {
        $statement = $db->prepare('SELECT count(*) AS counter FROM User WHERE login = :login');
        $statement->bindParam(':login', $this->login);
        $statement->execute();
        $result = $statement->fetchAll();
        $count = $result[0]['counter'];
        if ($count > 0)
            return false;
        return true;
    }

    public function persist($db)
    {
        if ($this->checkUserNonexistant($db))
        {
			try {
            $statement = $db->prepare('INSERT INTO User
            (login, mail, passwd, cle, profile, creation_date, status)
            VALUES
            (:login, :mail, :passwd, :cle, :profile, NOW(), :status)'
            );
            $statement->bindParam(':login', $this->login);
            $statement->bindParam(':mail', $this->mail);
            $statement->bindParam(':passwd', $this->passwd);
            $statement->bindParam(':cle', $this->cle);
            $statement->bindParam(':profile', $this->profile);
            $statement->bindParam(':status', $this->status);
            $statement->execute();
			}
			catch (PDOException $e)
			{
				return false;
			}
            return true;
        }
        else 
            return false;
    }

    public function checkCredentials($db)
    {
        $sql = 'SELECT profile, status FROM User WHERE login = :login AND passwd = :passwd';
        $statement = $db->prepare($sql);
        $statement->bindParam(':login', $this->login);
        $statement->bindParam(':passwd', $this->passwd);
        $statement->execute();
        $result = $statement->fetchAll();

        if (count($result) === 0)
            return false;
        $value = $result[0];
        $this->profile = $value['profile'];
        $this->status = $value['status'];
        return true;
    }

    public function listAll($db)
    {
        $statement = $db->prepare("SELECT login, mail, profile, status FROM User");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public function getDb($db)
    {
        $statement = $db->prepare('SELECT passwd, cle, profile, status FROM User WHERE login = :login');
        $statement->bindParam(':login', $this->login);
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) === 0)
            return false;
        $value = $result[0];
        $this->passwd = $value['passwd'];
        $this->cle = $value['cle'];
        $this->profile = $value['profile'];
        $this->status = $value['status'];        
        return true;
    }

    public function getUserByMail($db)
    {
        $statement = $db->prepare('SELECT login, passwd, cle, profile, status FROM User WHERE mail = :mail');
        $statement->bindParam(':mail', $this->mail);
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) === 0)
            return false;
        $value = $result[0];
        $this->login = $value['login'];
        $this->passwd = $value['passwd'];
        $this->cle = $value['cle'];
        $this->profile = $value['profile'];
        $this->status = $value['status'];        
        return true;
    }

    public function setStatus($db)
    {
        $sql = 'UPDATE User SET STATUS=:status WHERE login = :login';
        $statement = $db->prepare($sql);
        $statement->bindParam(':status', $this->status);
        $statement->bindParam(':login', $this->login);        
        return ($statement->execute());
    }

    public function setPasswdByLogin($db)
    {
        $sql = 'UPDATE User SET PASSWD=:passwd WHERE login = :login';
        $statement = $db->prepare($sql);
        $statement->bindParam(':login', $this->login);
        $statement->bindParam(':passwd', $this->passwd);
        return ($statement->execute());
    }

    public function setMailByLogin($db)
    {
        $sql = 'UPDATE User SET MAIL=:mail WHERE login = :login';
        $statement = $db->prepare($sql);
        $statement->bindParam(':login', $this->login);
        $statement->bindParam(':mail', $this->mail);
        return ($statement->execute());
    }

    public function deleteUser($db)
    {
        $sql = 'DELETE FROM User where login=:login';
        $statement = $db->prepare($sql);
        $statement->bindParam(':login', $this->login);  
        return ($statement->execute());
    }

    public function findByImage($db, $image_id)
    {
        $statement = $db->prepare('SELECT login, mail FROM user u INNER JOIN image i ON i.user_id=u.login WHERE i.id=:image_id');
        $statement->bindParam(':image_id', $image_id);  
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) === 0)
            return false;
        $value = $result[0];
        $this->mail = $value['mail'];
        $this->login = $value['login']; 
        return true;
    }
}
