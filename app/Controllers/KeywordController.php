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

			// Usage analytics (per-keyword daily report counts; weekly carries no keywords)
			$keywordUsage = $Keyword->getKeywordUsage($_SESSION['id']);

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
				$id = $Keyword->addKeywords($topic);

				// Inline add (fetch) -> JSON; classic submit -> redirect.
				if (isAjax()) {
					jsonResponse(['ok' => true, 'id' => $id, 'topic' => $topic]);
				}
				header('Location: keywords');
				return;
			}

			// Load add keyword view file
			require 'app/Views/learner/addKeyword.view.php';
		}
		/* Redirect user to "login" page */
		else {
			header("Location: login");
		}
	}

	/* Update endpoint for a keyword (no edit page — editing is inline). */
	public function editKeyword(){
		// Load configuration file
		require_once 'app/Views/general/config.php';

		// Check if user is logged in
		if (!isset($_SESSION['access_token']) || !$_SESSION['access_token']) {
			if (isAjax()) jsonResponse(['ok' => false, 'error' => 'auth'], 401);
			header("Location: login");
			return;
		}

		$id = $_GET['id'] ?? null;
		$Keyword = new Keyword();

		// Only POST performs an update; the old GET edit page has been removed.
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$topic = e(post('topic'));
			$Keyword->editKeyword($id, $topic);

			if (isAjax()) {
				jsonResponse(['ok' => true, 'id' => $id, 'topic' => $topic]);
			}
			header('Location: keywords');
			return;
		}

		// Any non-POST access just returns to the keywords page.
		header('Location: keywords');
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