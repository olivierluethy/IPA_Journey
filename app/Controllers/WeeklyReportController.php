<?php

class WeeklyReportController
{
    public function weeklyRaport(){		
		// Load configuration file
		require_once 'app/Views/general/config.php';

		/* Check if user is logged in */
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			// Create instance of WeeklyReport class
			$WeeklyReport = new WeeklyReport();
			
			// Retrieve all weekly reports in process and store them in an array
			$arrayWeeklyInProcess = $WeeklyReport->getAllWeeklyInProcess()->fetchAll();
			
			// Retrieve all weekly reports that are released and store them in an array
			$arrayWeeklyIsReleased = $WeeklyReport->getAllWeeklyInRelease()->fetchAll();

			// Load the "weeklyRaport" view file to display the lists of weekly reports
			require 'app/Views/learner/weeklyRaport.view.php';
		}else{
			// Redirect user to "login" page if not logged in
			header("Location: login");
		}
	}

	public function addWeeklyJournal(){
		require_once 'app/Views/general/config.php';
	
		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			die();
		}
		// If user is logged in, show the weekly journal entry form
		else {
			$WeeklyReport = new WeeklyReport();
	
			// If the form is submitted via POST request, add the weekly journal entry to the database
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$calendar_week = e(post('calendar_week'));
				$completed_tasks = e(post('completed_tasks'));
				$still_in_work = e(post('still_in_work'));
				$reflection = e(post('reflection'));
				$issues = e(post('issues'));
	
				$status = 0;
	
				$WeeklyReport->addWeeklyRaport($calendar_week, $completed_tasks, $still_in_work, $reflection, $issues, $status);
	
				// Redirect to the weekly report page after successfully adding the journal entry
				header('Location: weeklyRaport');
			}
	
			// Load the add weekly journal entry form view
			require 'app/Views/learner/addWeeklyJournal.view.php';
		}
	}	

    public function editWeeklyRaport(){
		// Require the necessary configuration files
		require_once 'app/Views/general/config.php';
	
		// Check if the user is logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			// Redirect the user to the login page
			header("Location: login");
			die();
		} else {
			// Get the ID of the weekly report from the URL parameter
			$id = $_GET['id'];
	
			// Create a new instance of the WeeklyReport class
			$WeeklyReport = new WeeklyReport();
	
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Get the updated values from the form
				$calendar_week = e(post('calendar_week'));
				$completed_tasks = e(post('completed_tasks'));
				$still_in_work = e(post('still_in_work'));
				$reflection = e(post('reflection'));
				$issues = e(post('issues'));
	
				// Update the weekly report in the database
				$WeeklyReport->editWeeklyReport($calendar_week, $completed_tasks, $still_in_work, $reflection, $issues, $id);
	
				// Redirect the user to the weekly report page
				header('Location: weeklyRaport');
			} else {
				// Get the data of the weekly report to be edited
				$getWeeklyReport = $WeeklyReport -> getWeeklyReport($id)->fetchAll();
			}
	
			// Load the view for editing the weekly report
			require 'app/Views/learner/editWeeklyJournal.view.php';
		}
	}	

	public function deleteWeeklyRaport(){
		require_once 'app/Views/general/config.php';

		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			die();
		}else{
			$WeeklyReport = new WeeklyReport();

			// Connect to database and set error mode to exception
			$pdo = connectDatabase();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$id = $_GET['id'];

			// Call the deleteWeeklyReport method to delete the report with the specified ID
			$WeeklyReport->deleteWeeklyReport($id);
			
			// Redirect the user to the weekly report page
			header('Location: weeklyRaport');
		}
	}

	public function releaseWeeklyReport(){
		require_once 'app/Views/general/config.php';
	
		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) {
			header("Location: login");
			die();
		} else {
			// Create a new WeeklyReport object and connect to the database
			$WeeklyReport = new WeeklyReport();
			$pdo = connectDatabase();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			// Retrieve the ID of the weekly report to be released from the query string
			$id = $_GET['id'];
	
			// Call the releaseWeeklyReport() method of the WeeklyReport class to release the weekly report
			$WeeklyReport->releaseWeeklyReport($id);
	
			// Redirect the user to the weeklyRaport page
			header('Location: weeklyRaport');
		}
	}
}