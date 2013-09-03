<?php

App::uses('CakeEmail', 'Network/Email');

class MailTask extends Shell {

    var $uses = array('Contact');

    public function enroll_reminder_first() {
	$Email = new CakeEmail();
	$Email->config('default');
	$reminder_first = $this->Contact->find('all', array('conditions' => array('Contact.enroll_later_first_reminder' => '', 'Contact.contact_type' => 'EnrollLater')));
	if (!empty($reminder_first)) {
	    foreach ($reminder_first as $val) {
		$id = $val['Contact']['id'];
		$name = $val['Contact']['first_name'];
		$email = $val['Contact']['email'];
		$Email->template('reminder')
			->viewVars(array('fname' => $name))
			->emailFormat('html')
			->subject('Park Power: Enrollment Later First Reminder')
			->to($email)
			->from('noreply@parkpower.com');
		if ($Email->send()) {
		    $update_val_first['Contact']['id'] = $id;
		    $update_val_first['Contact']['enroll_later_first_reminder'] = 'sent';
		    $update_val_first['Contact']['enroll_later_first_reminder_date'] = date("Y-m-d H:i:s");
		    $this->Contact->save($update_val_first['Contact']);
		    $this->out($email.' Mail Sent');
		}
	    }
	}
//	$this->out(print_r($reminder_first, true));
    }

    public function enroll_reminder_second() {
	$Email = new CakeEmail();
	$Email->config('default');
	$reminder_second = $this->Contact->find('all', array('conditions' => array('Contact.enroll_later_first_reminder !=' => '', 'Contact.enroll_later_second_reminder' => '', 'Contact.contact_type' => 'EnrollLater')));
	if (!empty($reminder_second)) {
	    foreach ($reminder_second as $val) {
		$second_reminder_after_2_date = strtotime(date("Y-m-d", strtotime("+2 day", strtotime($val['Contact']['enroll_later_first_reminder_date']))) . " " . "00:00:00");
		$current_date = strtotime(date("Y-m-d") . " " . "00:00:00");
		if ($current_date == $second_reminder_after_2_date) {
		    $id = $val['Contact']['id'];
		    $name = $val['Contact']['first_name'];
		    $email = $val['Contact']['email'];
		    $Email->template('reminder')
			    ->viewVars(array('fname' => $name))
			    ->emailFormat('html')
			    ->subject('Park Power: Enrollment Second Later Reminder')
			    ->to($email)
			    ->from('noreply@parkpower.com');
		    if ($Email->send()) {
			$update_val_second['Contact']['id'] = $id;
			$update_val_second['Contact']['enroll_later_second_reminder'] = 'sent';
			$update_val_second['Contact']['enroll_later_second_reminder_date'] = date("Y-m-d H:i:s");
			$this->Contact->save($update_val_second['Contact']);
			$this->out($email.' Mail Sent');
		    }
		}
	    }
	}
    }

    public function enroll_reminder_third() {
	$Email = new CakeEmail();
	$Email->config('default');
	$reminder_third = $this->Contact->find('all', array('conditions' => array('Contact.enroll_later_first_reminder !=' => '', 'Contact.enroll_later_second_reminder !=' => '', 'Contact.enroll_later_third_reminder' => '', 'Contact.contact_type' => 'EnrollLater')));
	if (!empty($reminder_third)) {
	    foreach ($reminder_third as $val) {
		$third_reminder_after_2_date = strtotime(date("Y-m-d", strtotime("+2 day", strtotime($val['Contact']['enroll_later_second_reminder_date']))) . " " . "00:00:00");
		$current_date = strtotime(date("Y-m-d") . " " . "00:00:00");
		if ($current_date == $third_reminder_after_2_date) {
		    $id = $val['Contact']['id'];
		    $name = $val['Contact']['first_name'];
		    $email = $val['Contact']['email'];
		    $Email->template('reminder')
			    ->viewVars(array('fname' => $name))
			    ->emailFormat('html')
			    ->subject('Park Power: Enrollment Later Third Reminder')
			    ->to($email)
			    ->from('noreply@parkpower.com');
		    if ($Email->send()) {
			$update_val_third['Contact']['id'] = $id;
			$update_val_third['Contact']['enroll_later_third_reminder'] = 'sent';
			$update_val_third['Contact']['enroll_later_third_reminder_date'] = date("Y-m-d H:i:s"); // Prints something like: Monday 8th of August 2005 03:12:46 PM
			$this->Contact->save($update_val_third['Contact']);
			$this->out($email.' Mail Sent');
		    }
		}
	    }
	}
    }

}
?> 
