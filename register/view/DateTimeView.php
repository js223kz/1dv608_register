<?php

namespace view;
require_once('model/DateTimeModel.php');

class DateTimeView {

	public function renderDateTimeString() {
		$dateTimeModel = new \model\DateTimeModel();

		$timeString = $dateTimeModel->getDay() . ", the " .
			$dateTimeModel->getDate() . " of " . $dateTimeModel->getMonth() . " "
			. $dateTimeModel->getYear() . ", The time is " . $dateTimeModel->getTime();

		return '<p>' . $timeString . '</p>';
	}
}
