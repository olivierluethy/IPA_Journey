<?php

class JournalController
{
	/* Für Lernender */
	public function home(){
		require 'app/Views/home.view.php';
	}	

	public function releasedreports(){		
		require 'app/Views/fachkraft/releasedreports.view.php';
	}
}