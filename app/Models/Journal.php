<?php
class Journal
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

	// Gets all daily journals which have not been released
	public function getAllDailyJournalsInProcess(){
		$statement = $this->db->prepare('SELECT journal.journalId, journal.text, journal.date, user.full_name FROM journal 
		INNER JOIN user ON user.userId = journal.fk_userId WHERE journal.status = 0 AND journal.fk_userId = :id');
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}

	// Gets all daily journals which have been released
	public function getAllDailyJournalsInRelease(){
		$statement = $this->db->prepare('SELECT journal.journalId, journal.text, journal.date, user.full_name FROM journal 
		INNER JOIN user ON user.userId = journal.fk_userId WHERE journal.status = 1 AND journal.fk_userId = :id');
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}
}