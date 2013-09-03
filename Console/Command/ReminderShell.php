<?php

class ReminderShell extends Shell {
       var $tasks = array('Mail'); //found in /vendors/shells/tasks/sound.php
	function main() {
	    $this->Mail->enroll_reminder_first();
	    $this->Mail->enroll_reminder_second();
	    $this->Mail->enroll_reminder_third();
   }
}
