<?php

class KeywordController
{
	/* This page shows all keywords */
    public function keywords(){		
			// Load the "mykeywords" view file to display the list of keywords
			require 'app/Views/lernender/mykeywords.view.php';	
	}

	/* In this page you can add a keyword */
	public function addkeyword(){}

	/* In this page you can edit a keyword */
	public function editkeywords(){}

	/* In this page you can delete a keyword */
	public function deleteKeyword(){}
}