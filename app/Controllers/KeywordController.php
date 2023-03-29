<?php

class KeywordController
{
	/* This page shows all keywords */
    public function keywords(){		
		// Load configuration file
		require_once 'app/Views/general/config.php';

		/* Check if user is logged in */
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			// Create instance of Keyword class
			$Keyword = new Keyword();
		
			// Retrieve all keywords from the database and store them in an array
			$arrayKeywords = $Keyword->getAllKeywords()->fetchAll();
			
			// Load the "mykeywords" view file to display the list of keywords
			require 'app/Views/learner/myKeywords.view.php';	
		}
		/* Redirect user to "login" page */
		else {
			header("Location: login");
		}
	}

	/* In this page you can add a keyword */
	public function addKeyword(){
		// Load configuration file
		require_once 'app/Views/general/config.php';

		/* Check if user is logged in */
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			// Create instance of Keyword class
			$Keyword = new Keyword();

			// Check if server request method is POST
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Retrieve theme parameter from form data and sanitize it
				$topic = e(post('topic'));

				// Add new keyword to database
				$Keyword->addKeywords($topic);
	
				// Redirect user to "keywords" page
				header('Location: keywords');
			}

			// Load add keyword view file
			require 'app/Views/learner/addKeyword.view.php';
		}
		/* Redirect user to "login" page */
		else {
			header("Location: login");
		}
	}

	/* In this page you can edit a keyword */
	public function editKeywords(){
		// Load configuration file
		require_once 'app/Views/general/config.php';

		// Check if user is logged in
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			// Retrieve ID parameter from URL
			$id = $_GET['id'];

			// Create instance of Keyword class
			$Keyword = new Keyword();

			// Check if server request method is POST
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Retrieve title parameter from form data and sanitize it
				$topic = e(post('topic'));

				// Edit keyword with specified ID in database
				$Keyword->editKeyword($id, $topic);

				// Redirect user to "keywords" page
				header('Location: keywords');	
			}else{
				// Retrieve keyword data to edit from database
				$getKeyword = $Keyword -> getKeyword($id)->fetchAll();
			}

			// Load edit keyword view file
			require 'app/Views/learner/editKeyword.view.php';
		}else{
			// Redirect user to "login" page
			header("Location: login");
		}
	}

	/* In this page you can delete a keyword */
	public function deleteKeyword(){
		// Load configuration file
		require_once 'app/Views/general/config.php';

		// Check if user is logged in
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			// Create instance of Keyword class
			$Keyword = new Keyword();

			// Connect to database using helper function
			$pdo = connectDatabase();

			// Set PDO error mode to throw exceptions
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Retrieve ID parameter from URL
			$id = $_GET['id'];

			// Delete keyword with specified ID from database
			$Keyword->deleteKeyword($id);

			// Redirect user to "keywords" page
			header('Location: keywords');
		}else {
			// Redirect user to "login" page
			header("Location: login");
		}
	}
}