<?php
class Fachkraft
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    // Gets all daily raports
	public function getDailyRaports(){
		$statement = $this->db->prepare('SELECT journal.journalId, journal.text, journal.date, user.full_name FROM journal 
		INNER JOIN user ON user.userId = journal.fk_userId WHERE journal.status = 1');
		$statement->execute();
        return $statement;
	}

    // Gets all weekly raports
	public function getWeeklyRaports(){
		$statement = $this->db->prepare('SELECT *, user.full_name FROM weeklyreport 
		INNER JOIN user ON user.userId = weeklyreport.fk_userId WHERE weeklyreport.status = 1');
		$statement->execute();
        return $statement;
	}

    // Gets all apprentices
    public function getAllLernende(){
        $statement = $this->db->prepare('SELECT * FROM user
        WHERE user.role = 0');
		$statement->execute();
        return $statement;
    }

	// Sort Algorithm
    public function sortTask($sort_option){
        // $statement = $this->db->prepare("SELECT * FROM aufgabe WHERE fk_benutzerId = :benutzerId AND status = 0 ORDER BY $sort_option");
        // $statement->bindParam(':benutzerId', $_SESSION["id"], PDO::PARAM_STR);
        // $statement->execute();
        // return $statement;
    }
}