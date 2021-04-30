<?php

include_once( __DIR__ . '/Db.php' );

class User
{
    private $email;
    private $password;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare( 'SELECT email FROM users WHERE email = :email' );
        $statement->bindValue( 'email', $email );
        $statement->execute();
        $email = $statement->fetchAll( PDO::FETCH_ASSOC );
        return $email;
        
        if ( empty( $email ) ) {
            throw new Exception( 'Email cannot be empty' );
        }

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
}