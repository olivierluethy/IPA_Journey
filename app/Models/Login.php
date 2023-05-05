<?php
class Login
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    // Check if the user exists in the database
	public function doesUserExist($email){
        $statement = $this->db->prepare('SELECT * FROM user WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }    

    // Gets role of given email
    public function getRole($email){
        $statement = $this->db->prepare('SELECT role FROM user WHERE email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        return $statement->fetch();
    }

    // Gets ID of given email
    public function getId($email){
        $statement = $this->db->prepare('SELECT userId FROM user WHERE email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        return $statement->fetch();
    }

    // If the user is not in the database, add them
    public function addUser($email, $firstName, $lastName, $gender, $name, $profileImageUrl, $verifiedEmail, $token){
        $statement = $this->db->prepare("INSERT INTO user (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token, role) 
        VALUES (:email, :first_name, :last_name, :gender, :full_name, :picture, :verifiedEmail, :token, 0)");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':first_name', $firstName);
        $statement->bindParam(':last_name', $lastName);
        if (isset($gender)) {
            $statement->bindParam(':gender', $gender);
        } else {
            $gender = null;
            $statement->bindParam(':gender', $gender, PDO::PARAM_NULL);
        }
        $statement->bindParam(':full_name', $name);
        $statement->bindParam(':picture', $profileImageUrl);
        $statement->bindParam(':verifiedEmail', $verifiedEmail);
        $statement->bindParam(':token', $token);
        $statement->execute();
    }

    // If the information from the user as been changed
    public function updateUser($email, $firstName, $lastName, $gender, $name, $profileImageUrl, $verifiedEmail, $token){
        $userId = $this->getId($email)['userId'];
        if (!$userId) {
            throw new Exception("User does not exist in the database.");
        }
        $statement = $this->db->prepare('UPDATE user SET first_name = :first_name, last_name = :last_name, gender = :gender, full_name = :full_name, picture = :picture, verifiedEmail = :verifiedEmail, token = :token WHERE userId = :userId');
        $statement->bindParam(':first_name', $firstName);
        $statement->bindParam(':last_name', $lastName);
        $statement->bindParam(':gender', $gender);
        $statement->bindParam(':full_name', $name);
        $statement->bindParam(':picture', $profileImageUrl);
        $statement->bindParam(':verifiedEmail', $verifiedEmail);
        $statement->bindParam(':token', $token);
        $statement->bindParam(':userId', $userId);
        $statement->execute();
    }
}