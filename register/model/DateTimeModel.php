<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-09-23
 * Time: 10:08
 */

namespace model;


class DateTimeModel
{
    private $today;
    private $day;
    private $date;
    private $month;
    private $year;
    private $time;

    public function __construct(){
        date_default_timezone_set("Europe/Stockholm");
        $this->today = new \DateTime();

        $this->day = $this->today->format('l');
        $this->date = $this->today->format('jS');
        $this->month = $this->today->format('F');
        $this->year = $this->today->format('Y');
        $this->time = $this->today->format('H:i:s');
    }

    public function getDay(){
        return $this->day;
    }
    public function getDate(){
        return $this->date;
    }
    public function getMonth(){
        return $this->month;
    }
    public function getYear(){
        return $this->year;
    }
    public function getTime(){
        return $this->time;
    }
}