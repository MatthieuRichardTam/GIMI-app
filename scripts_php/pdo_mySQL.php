<?php

class PdoMySQL
{
    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DBNAME = "gimi";

    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function sign_in($username, $password)
    {
        return $this->connection->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'")->fetch_assoc();
    }

    public function get_medications()
    {
        $medications = array();
        $query = $this->connection->query("SELECT id, name FROM medications");
        while ($medication = $query->fetch_assoc()) {
            array_push($medications, $medication);
        }
        return $medications;
    }

    public function get_patients()
    {
        $patients = array();
        $query = $this->connection->query("SELECT id, first_name, last_name FROM patients");
        while ($patient = $query->fetch_assoc()) {
            array_push($patients, $patient);
        }
        return $patients;
    }

    public function get_injections()
    {
        return $this->connection->query("SELECT injections.id as id, hardware_id, starting_date, volume, flow_rate, medication_id, medications.name as medication_name, concentration, moderate_threshold, severe_threshold FROM injections INNER JOIN medications ON injections.medication_id = medications.id");
    }

    public function create_tasks($injection_id, $type){
        $sql="INSERT INTO `tasks` (`injection_id`, `type`)
        SELECT * FROM (SELECT ".$injection_id." AS injection_id, '".$type."' AS type) AS tmp
        WHERE NOT EXISTS (
            SELECT * FROM `tasks` 
            WHERE `injection_id` = ".$injection_id." AND `type` = '".$type."'
        );";
        if ($this->connection->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tasks(){
        return $this->connection->query("SELECT users.firstname as 'caregiver_first_name', users.surname as 'caregiver_last_name', tasks.`id` as 'task_id', tasks.`injection_id`, tasks.`type`, tasks.`done`, tasks.`user_id`, injections.id, injections.hardware_id, injections.starting_date, injections.volume, injections.flow_rate, injections.medication_id, injections.moderate_threshold, injections.severe_threshold, injections.concentration, patients.first_name, patients.last_name, beds.room, beds.id as 'bed_id', medications.name as medication_name FROM `tasks` INNER JOIN injections ON injections.id = tasks.injection_id INNER JOIN patients ON patients.id = injections.patient_id INNER JOIN beds ON beds.id = patients.bed_id INNER JOIN medications ON injections.medication_id = medications.id LEFT JOIN users ON tasks.user_id = users.username WHERE tasks.deleted = 0 AND tasks.done = 0");
    }

    public function get_patient_treatment($patient_id)
    {
        return $this->connection->query("SELECT medications.id, medications.name FROM injections INNER JOIN medications ON medications.id = injections.medication_id WHERE injections.patient_id = $patient_id");
    }

    public function get_patient_injections($patient_id)
    {
        $result = array();
        $injections = $this->connection->query("SELECT injections.id, hardware_id, starting_date, volume, flow_rate, medications.name as medication_name, medications.id as medication_id,moderate_threshold, severe_threshold, concentration FROM injections JOIN medications ON injections.medication_id = medications.id WHERE patient_id =" . $patient_id);
        $number = $this->connection->query("SELECT COUNT(*) FROM injections WHERE patient_id =" . $patient_id);
        $result['injections'] = $injections;
        $result['number'] = $number;
        return $result;
    }

    public function get_patients_id()
    {
        return $this->connection->query("SELECT id FROM patients");
    }

    public function get_patient($patient_id)
    {
        return $this->connection->query("SELECT patients.id, patients.first_name, patients.last_name, beds.room, beds.id as bed FROM patients JOIN beds ON patients.bed_id = beds.id WHERE patients.id =" . $patient_id)->fetch_assoc();
    }

    public function add_injection($injection,$patient_id,$username){
        $sql="INSERT INTO `injections` (`id`, `patient_id`, `caregiver_id`, `hardware_id`, `volume`, `flow_rate`, `medication_id`, `concentration`, `starting_date`) VALUES (NULL,".$patient_id.", '".$username."', '".$injection->hardware_id."', ".$injection->volume.", ".$injection->flow_rate.",'".$injection->medication_id."', ".$injection->concentration.",'".$injection->starting_date."');";
        echo($sql);
        if ($this->connection->query($sql) === TRUE) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }
    public function add_patient($row){
        $sql="INSERT INTO `patients` (`first_name`, `last_name`, `birthdate`, `bed_id`) VALUES ('".$row['first_name']."','".$row['last_name']."','".$row['birthdate']."','".$row['bed']."');";
        if ($this->connection->query($sql) === TRUE) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
        $sql="UPDATE beds SET taken = 1 WHERE id =" .$row['bed'];
        if ($this->connection->query($sql) === TRUE) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }    
    public function get_severe_injections(){
        $sql = "SELECT * FROM injections WHERE severity = 'severe'";
        return $this->connection->query($sql);
    
    }

    public function get_compatibility($medication1,$medication2){
        $sql="SELECT compatibility FROM compatibilites WHERE medication1 = ". $medication1 ." AND medication2 = ".$medication2;
        return $this->connection->query($sql)->fetch_assoc()["compatibility"];
    }

    public function delete_injection($injection_id){
        $sql="DELETE FROM injections WHERE id = ".$injection_id;
        return $this->connection->query($sql);
    }

    public function delete_task($task_id){
        $sql="UPDATE tasks SET deleted = 1 WHERE id =".$task_id;
        return $this->connection->query($sql);
    }

    public function change_task_user($task_id, $user_id){
        if ($this->connection->query("SELECT user_id FROM tasks WHERE id =".$task_id)->fetch_assoc()['user_id'] == ''){
            $sql="UPDATE tasks SET user_id ='".$user_id."' WHERE id =".$task_id;
        } else {
            $sql="UPDATE tasks SET user_id ='' WHERE id =".$task_id;
        } 
        return $this->connection->query($sql);
    }

    public function task_done($task_id){
        $sql="UPDATE tasks SET done = 1 WHERE id =".$task_id;
        return $this->connection->query($sql);
    }

    public function get_empty_beds(){
        $beds = array();
        $sql="SELECT * FROM beds WHERE taken = 0";
        $query = $this->connection->query($sql);
        while ($bed = $query->fetch_assoc()) {
            array_push($beds, $bed);
        }
        return $beds;
    }
}