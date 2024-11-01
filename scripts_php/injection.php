<?php

class Injection
{
    public $id;
    public $hardware_id;

    public $volume;
    public $flow_rate;
    public $medication_id;
    public $medication_name;
    public $concentration;

    public $starting_date;
    public $date_end;
    public $time_length;
    public $time_left;
    public $time_left_ratio;
    
    public $moderate_threshold;
    public $severe_threshold;
    public $status;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->hardware_id = $row['hardware_id'];
        $this->hardware_id = $row['hardware_id'];

        $this->volume = $row['volume'];
        $this->flow_rate = $row['flow_rate'];
        $this->medication_id = $row['medication_id'];
        $this->medication_name = $row['medication_name'];
        $this->concentration = $row['concentration'];

        $this->starting_date = $row['starting_date'];
        $this->time_length = $this->volume / $this->flow_rate * 3600;
        $this->date_end = strtotime($this->starting_date) + $this->time_length; //Passer la duree en secondes

        $this->time_left = array("raw_time_left" => ($this->date_end - strtotime(date("Y-m-d H:i:s"))));
        $this->time_left["hours_left"] = (int)($this->time_left["raw_time_left"] / 3600);
        $this->time_left["minutes_left"] = (int)(($this->time_left["raw_time_left"] - $this->time_left["hours_left"] * 3600) / 60);
        $this->time_left["seconds_left"] = (int)($this->time_left["raw_time_left"] - $this->time_left["hours_left"] * 3600 - $this->time_left["minutes_left"] * 60);
        $this->time_left_ratio = $this->time_left["raw_time_left"] / $this->time_length;
        $this->moderate_threshold = $row['moderate_threshold'];
        $this->severe_threshold = $row['severe_threshold'];

        // if ($row['moderate_threshold'] != 0){
        //     $this->set_thresholds();
        // }
        // else{

        // }
        $this->set_status();
    }

    public function set_status()
    {
        if ($this->time_left["raw_time_left"] > $this->time_length) {
            $this->status = 'not-started';
        } elseif ($this->time_left_ratio >= $this->moderate_threshold) {
            $this->status = 'minor-priority';
        } elseif ($this->time_left_ratio >= $this->severe_threshold) {
            $this->status = 'moderate-priority';    
        } elseif ($this->time_left["raw_time_left"] > 0) {
            $this->status = 'severe-priority';
        } elseif ($this->time_left["raw_time_left"] <= 0) {
            $this->status = 'empty';
        } else {
            $this->status = 'failure';
        }

    }

    public function display_time()
    {
        if ($this->time_left["hours_left"] > 0) {
            echo ("Temps restant: " . $this->time_left["hours_left"] . "h : " . $this->time_left["minutes_left"] . "m : " . $this->time_left["seconds_left"] . "s");
        } elseif ($this->time_left["minutes_left"] > 0) {
            echo ("Temps restant: ".$this->time_left["minutes_left"] . "m : " . $this->time_left["seconds_left"] . "s");
        } elseif ($this->time_left["seconds_left"] >= 0) {
            echo ("Temps restant: ".$this->time_left["seconds_left"] . "s");
        } elseif ($this->time_left["hours_left"] < 0) {
            echo ("En retard de " . -$this->time_left["hours_left"] . "h, " . -$this->time_left["minutes_left"] . "min et " . -$this->time_left["seconds_left"] . "s");
        } elseif ($this->time_left["minutes_left"] < 0) {
            echo ("En retard de " . -$this->time_left["minutes_left"] . "min et " . -$this->time_left["seconds_left"] . "s");
        } elseif ($this->time_left["seconds_left"] < 0) {
            echo ("En retard de " . -$this->time_left["seconds_left"] . "s");
        }
    }
    public function set_thresholds($calculated = false){
        if ($calculated==false){
            $this->moderate_threshold = 0.25;
            $this->severe_threshold = 0.1;
        }
    }
    public function update_thresholds($conn){
        $conn->query("UPDATE `injections` SET `moderate_threshold` = '".$this->moderate_threshold."', `severe_threshold` = '".$this->severe_threshold."' WHERE `injections`.`id` = ".$this->id.";");
    }
}


