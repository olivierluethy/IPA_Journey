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
			$text = e(post('text'));
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

	/* The page to edit a daily report */
    public function editDailyReport(){
		// Including configuration file
		require_once 'app/Views/general/config.php';
		// Checking if the user is logged in
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			$id = $_GET['id'];
			$dailyReport = new DailyReport();
			
			// If the form has been submitted
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Sanitizing and validating input
				$text = e(post('text'));
				$topics = post('topics', []);
			
				if (!is_array($topics)) {
					$topics = [$topics];
				}
				
				$status = 0;
				// Updating daily report with new data
				$dailyReport->editDailyReport($id, $text, $status);
				
				// Updating topics of the daily report
				foreach ($topics as $topic) {
					$dailyReport->addSelectedTopics($topic, $id);
				}
				
				header('Location: dailyRaport');
			} else {
				// Retrieving data of the daily report and keywords
				$getDailyReport = $dailyReport->getDailyReport($id)->fetchAll();
			
				$keyword = new Keyword();
				$getKeywords = $keyword->getAllKeywords()->fetchAll();
				$getPickedKeywords = $keyword->getSelectedKeywords($id)->fetchAll();
			}
			
			// Loading the edit daily journal view
			require 'app/Views/learner/editDailyJournal.view.php';
		}else {
			// Redirecting to the login page if user is not logged in
			header('Location: login');
		}
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