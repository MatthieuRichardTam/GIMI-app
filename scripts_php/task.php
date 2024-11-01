<?php



function create_tasks($injections)
{
    $conn = new PdoMySQL();

    foreach ($injections as $injection) {
        if ($injection->time_left_ratio <= $injection->moderate_threshold) {
            $conn->create_tasks($injection->id, "danger");
        }
    }
}

class Task
{
    public $id;
    public $injection;
    public $type;
    public $done;
    public $user;

    public $first_name;
    public $last_name;
    public $room;
    public $bed;

    public $caregiver_first_name;
    public $caregiver_last_name;

    public function __construct($row)
    {
        $this->id = $row['task_id'];
        $this->user = $row['user_id'];
        $this->caregiver_first_name = $row['caregiver_first_name'];
        $this->caregiver_last_name = $row['caregiver_last_name'];
        $this->type = $row['type'];
        $this->done = $row['done'];
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->room = $row['room'];
        $this->bed = $row['bed_id'];

        $this->injection = new Injection($row);
    }

}