<?php
include "injection.php";
class Patient
{
  public $id;
  public $first_name;
  public $last_name;
  public $room;
  public $bed;
  public $injections;
  public $nb_injections;
  public $display_injections;

  public function __construct($patient_id, $conn)
  {
    $row_patient = $conn->get_patient($patient_id);
    $this->id = $row_patient['id'];
    $this->first_name = $row_patient['first_name'];
    $this->last_name = $row_patient['last_name'];
    $this->room = $row_patient['room'];
    $this->bed = $row_patient['bed'];
    $this->display_injections = False;

    $this->update_injections($conn);
    
  }

  public function add_injection($injection)
  {
    array_push($this->injections, $injection);
    $this->nb_injections++;
  }

  public function update_injections($conn){
    $result_sql = $conn->get_patient_injections($this->id);
    $this->injections = array();
    $this->nb_injections = intval($result_sql['number']->fetch_assoc()["COUNT(*)"]);
    while ($row = $result_sql['injections']->fetch_assoc()) {
      $injection = new Injection($row);
      array_push($this->injections, $injection);
    }
  }
}

