<?php

class DailyReportController
{
	/* The page to show daily raports made by user */
    public function dailyRaport() {
		// Include configuration file
		require_once 'app/Views/general/config.php';
		
		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			return;
		}
		
		// Get all daily journals which are in progress
		$Journal = new Journal();
		$arrayJournalsInProcess = $Journal->getAllDailyJournalsInProcess()->fetchAll();
		
		// Get all daily journals which are released
		$arrayJournalIsReleased = $Journal->getAllDailyJournalsInRelease()->fetchAll();

		// Available keywords for inline topic editing
		$Keyword = new Keyword();
		$arrayTopics = $Keyword->getAllKeywords()->fetchAll();

		// Load dailyRaport view
		require 'app/Views/learner/dailyRaport.view.php';
	}
	
	/* The page to add daily journal */
	public function addDailyJournal() {
		// Include the database configuration file
		require_once 'app/Views/general/config.php';
		
		// Redirect to the login page if the user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			die(); // Stop script execution
		}
		
		// Fetch all the keywords from the database
		$Keyword = new Keyword();
		$arrayTopics = $Keyword->getAllKeywords()->fetchAll();
		
		// Check if the form has been submitted
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Sanitize and validate the user input
			$text = sanitizeHtml(post('text'));
			$topics = !empty($_POST['topics']) ? $_POST['topics'] : array();
		
			// Set the status of the daily report to "not completed"
			$status = 0;
		
			// Add the daily journal entry to the database
			$DailyReport = new DailyReport();
			$journalId = $DailyReport->addDailyJournal($text, $status);
		
			// Add the selected topics to the database
			foreach ($topics as $topic) {
				$DailyReport->addSelectedTopics($topic, $journalId);
			}
		
			// Redirect the user to the daily report page
			header('Location: dailyRaport');
		}
		
		// Load the daily journal form view
		require 'app/Views/learner/addDailyJournal.view.php';
	}	

	/* Update endpoint for a daily report (no edit page — editing is inline). */
    public function editDailyReport(){
		// Including configuration file
		require_once 'app/Views/general/config.php';

		// Checking if the user is logged in
		if (!isset($_SESSION['access_token']) || !$_SESSION['access_token']) {
			if (isAjax()) jsonResponse(['ok' => false, 'error' => 'auth'], 401);
			header('Location: login');
			return;
		}

		$id = $_GET['id'] ?? null;
		$dailyReport = new DailyReport();

		// Only POST performs an update; the old GET edit page has been removed.
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$text = sanitizeHtml(post('text'));
			$topics = post('topics', []);
			if (!is_array($topics)) {
				$topics = [$topics];
			}

			$status = 0;
			// editDailyReport also clears the existing selected topics.
			$dailyReport->editDailyReport($id, $text, $status);
			foreach ($topics as $topic) {
				$dailyReport->addSelectedTopics($topic, $id);
			}

			if (isAjax()) {
				jsonResponse(['ok' => true, 'id' => $id, 'text' => $text]);
			}
			header('Location: dailyRaport');
			return;
		}

		header('Location: dailyRaport');
	}

	/* The page to delete a daily report */
	public function deleteDailyReport() {
		require_once 'app/Views/general/config.php';
	
		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			die();
		} else {
			// Instantiate DailyReport object
			$DailyReport = new DailyReport();
	
			// Connect to the database
			$pdo = connectDatabase();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			// Get the id of the daily report to be deleted from the query string
			$id = $_GET['id'];
	
			// Call the deleteDailyReport method to delete the daily report from the database
			$DailyReport->deleteDailyReport($id);
	
			// Redirect to daily report page after deletion
			header('Location: dailyRaport');
		}
	}	

	/* The URL to release a daily report */
	public function releaseDailyReport(){
		// Require the configuration file for general settings
		require_once 'app/Views/general/config.php';
	
		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			die();
		} else {
			// Create new DailyReport object and set up database connection
			$DailyReport = new DailyReport();
			$pdo = connectDatabase();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			// Get the ID of the report to release from the URL parameter
			$id = $_GET['id'];
	
			// Call the releaseDailyReport method of the DailyReport object with the ID parameter
			$DailyReport->releaseDailyReport($id);
			
			// Redirect to the daily report page
			header('Location: dailyRaport');
		}
	}
}