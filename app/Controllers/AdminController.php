<?php

class AdminController
{
	/* Shows all users except with role as admin */
    public function userOverview()
	{
		// Include the configuration file
		require_once 'app/Views/general/config.php';

		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['token'])) {
			header("Location: login");
			die();
		}

		// Redirect to home page if user is not an admin
		if ($_SESSION['role'] != 2) {
			header("Location: home");
			die();
		}

		// Get all users from the database
		$Admin = new Admin();
		$arrayUsers = $Admin->getAllUsers()->fetchAll();

		// Load the userOverview view
		require 'app/Views/admin/userOverview.view.php';
	}

	/* The page to edit a user */
	public function editUser() {
		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['user_token'])) {
			header("Location: login");
			die();
		}
	
		// Redirect to home page if the user is not authorized to access this page
		if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
			header("Location: home");
			die();
		}
	
		require_once 'app/Views/general/config.php';
	
		$id = $_GET['id'];
	
		$Admin = new Admin();
	
		// If the HTTP method is POST, update user details in the database
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$role = e(post('role'));
			$Admin->editUser($id, $role);
			header('Location: userOverview');
			die();
		}
	
		/* Get Data to edit */
		$getUser = $Admin->getUser($id)->fetchAll();
	
		require 'app/Views/editUser.view.php';
	}

	/* The URL to delete a user */
	public function deleteUser() {
		// Check if user is logged in
		if (!isset($_SESSION['user_token'])) {
			header("Location: login");
			die();
		}
	
		// Check if user has permission to delete user accounts
		if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
			header("Location: home");
			die();
		}
	
		// Include configuration file and instantiate Admin object
		require_once 'app/Views/general/config.php';
		$Admin = new Admin();
	
		// Connect to the database
		$pdo = connectDatabase();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		// Get the ID of the user to be deleted
		$id = $_GET['id'];
	
		// Call the deleteUser method of the Admin object to delete the user
		$Admin->deleteUser($id);
	
		// Redirect to the userOverview page
		header('Location: userOverview');
	}	
}