cronjob-in-cakephp2.3.x
=======================

How to set cronjob in cakephp 2.3.x?

Step1:
Create a shell file with name ReminderShell.php and Path should be PROJECT_DIR_PATH/PROJECT_NAME/app/Console/Command/ReminderShell.php
Copy below script and paste it
<?php

class ReminderShell extends Shell {
       var $tasks = array('Mail'); 
	function main() {
	    $this->Mail->enroll_reminder();
   }
}


Step2:
Create Task file with name MailTask.php and path should be PROJECT_DIR_PATH/PROJECT_NAME/app/Console/Command/Task/MailTask.php 

<?php

App::uses('CakeEmail', 'Network/Email');

class MailTask extends Shell {

    var $uses = array('Contact');

    public function enroll_reminder() {
		$Email = new CakeEmail();
		$Email->config('default');
		$reminder = $this->Contact->find('all');
		if (!empty($reminder)) {
			foreach ($reminder as $val) {
			$id = $val['Contact']['id'];
			$name = $val['Contact']['first_name'];
			$email = $val['Contact']['email'];
			$Email->template('reminder')
				->viewVars(array('fname' => $name))
				->emailFormat('html')
				->subject('xyz.com: Enrollment Reminder')
				->to($email)
				->from('noreply@xyz.com');
			if ($Email->send()) {
				$update_val['Contact']['id'] = $id;
				$update_val['Contact']['enroll_reminder'] = 'sent';
				$update_val['Contact']['enroll_reminder_date'] = date("Y-m-d H:i:s");
				$this->Contact->save($update_val['Contact']);
				$this->out($email.' Mail Sent');
			}
			}
		}
    }

Step3: 
Create a email template with name reminder.ctp and path sould be PROJECT_DIR_PATH/PROJECT_NAME/app/View/Emails/html/reminder.ctp

Step4: 
Create email.php in config directory
 
Step5: 
Run below command in Terminal: Console/cake Reminder 

	PROJECT_DIR_PATH/PROJECT_NAME/app Console/cake Reminder 
	
