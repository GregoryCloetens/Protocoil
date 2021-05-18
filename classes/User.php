<?php

include_once( __DIR__ . '/Db.php' );

class User
{
    private $firstname;
    private $lastname;
    private $email;
    private $password;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function login( ) 
    {
        session_start();
        $_SESSION['admin'] = $this->getEmail();
        header( 'Location: dashboard.php' );
    }

    public function register($email, $password, $firstname, $lastname){
        $options = [
            'cost' => 14,
        ];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);

        $conn = Db::getConnection();
        $query = $conn->prepare("insert into admin (email, password, firstname, lastname) values (:email, :password, :firstname, :lastname)");
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->bindValue(":firstname", $firstname);
        $query->bindValue(":lastname", $lastname);
        $query->execute();
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
}