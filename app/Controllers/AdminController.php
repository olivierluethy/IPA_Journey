<?php

class AdminController
{
	/* Shows all users except with role as admin */
    public function useroverview()
	{
		// Load the useroverview view
		require 'app/Views/admin/useroverview.view.php';
	}

	/* The page to edit a user */
	public function editUser() {}

	/* The URL to delete a user */
	public function deleteUser() {}
}