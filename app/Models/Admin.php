<?php
class Admin
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    // Gets all user except with role as admin
	public function getAllUsers(){
		$statement = $this->db->prepare('SELECT * FROM benutzer
        WHERE benutzer.role != 2');
		$statement->execute();
        return $statement;
	}

    // Updates all information from changed user
    public function editUser($id, $role){
        $statement = $this->db->prepare('UPDATE benutzer SET role = :role WHERE benutzerId = :id');
        $statement->bindParam(':role', $role, PDO::PARAM_STR);
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
    }

    // Deletes selected user
    public function deleteUser($id){
        $statement = $this->db->prepare('DELETE FROM `benutzer` WHERE benutzerId = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();
    }

    // Gets all the information about an user
    public function getUser($id){
        $statement = $this->db->prepare('SELECT * FROM benutzer
        WHERE benutzer.benutzerId = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
        return $statement;
    }
}