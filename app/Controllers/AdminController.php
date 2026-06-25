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

	/* Update endpoint for a user's role (no edit page — editing is inline). */
	public function editUser() {
		// Include the configuration file
		require_once 'app/Views/general/config.php';

		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['token'])) {
			if (isAjax()) jsonResponse(['ok' => false, 'error' => 'auth'], 401);
			header("Location: login");
			die();
		}

		// Only administrators may change roles
		if ($_SESSION['role'] != 2) {
			if (isAjax()) jsonResponse(['ok' => false, 'error' => 'forbidden'], 403);
			header("Location: home");
			die();
		}

		$id = $_GET['id'] ?? null;
		$Admin = new Admin();

		// Only POST performs an update; the old GET edit page has been removed.
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$role = e(post('role'));
			$Admin->editUser($id, $role);
			if (isAjax()) jsonResponse(['ok' => true, 'id' => $id, 'role' => $role]);
			header('Location: userOverview');
			die();
		}

		header('Location: userOverview');
	}

	/* The URL to delete a user */
	public function deleteUser() {
		// Include configuration file and instantiate Admin object
		require_once 'app/Views/general/config.php';
		
		// Check if user is logged in
		if (!isset($_SESSION['token'])) {
			header("Location: login");
			die();
		}
	
		// Check if user has permission to delete user accounts
		if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
			header("Location: home");
			die();
		}

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