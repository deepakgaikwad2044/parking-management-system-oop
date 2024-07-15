<?php

session_start();
class Database
{
  private $servername;
  private $username;
  private $password;
  private $db_name;

  protected function connect()
  {
    $servername = $this->servername = "localhost:3306";
    $username = $this->username = "root";
    $password = $this->password = "root";
    $db_name = $this->db_name = "parking_management_system";

    $conn = new mysqli($servername, $username, $password, $db_name);
    return $conn;
  }
}

class Query extends Database
{
  public function getRevenue()
  {
    $sql = " SELECT SUM(parking_fees) AS total_sum FROM users where status ='1' ;
    ";

    $res = $this->connect()->query($sql);

    if ($res->num_rows > 0) {
      // Output data of each row
      while ($row = $res->fetch_assoc()) {
        return $row["total_sum"];
      }
    } else {
      return "0 results";
    }
  }

  public function getData(
    $table_name,
    $fields,
    $order_field,
    $order_type,
    $data
  ) {
    $sql = "SELECT $fields FROM $table_name";

    foreach ($data as $key => $value) {
      $sql .= " WHERE $key = '$value' ";
    }

    $sql .= " ORDER BY $order_field $order_type";

    $res = $this->connect()->query($sql);

    return $res;
  }

  //function for data  insert
  public function insertData($table_name, $param)
  {
    $check_veh_no = $param["veh_no"];
    $check_email = $param["email"];

    $sql = "SELECT * FROM $table_name WHERE status = '0' " ;

    $res = $this->connect()->query($sql);

    while ($data = $res->fetch_assoc()) {
      if ( $data['veh_no'] == $param['veh_no'] ){ 
       $_SESSION["veh_no"] = $data["veh_no"];
        return false;  
    }
      else if(!empty($data["email"]) && $data["email"] == $param["email"]) {
        $_SESSION["email"] = $data["email"];
        return false;
      }
    }

    $fields = [];
    $values = [];

    foreach ($param as $key => $value) {
      $fields[] = $key;
      $values[] = $value;
    }

    $fields = implode(",", $fields);
    $values = "'" . implode("','", $values) . "'";

    $sql = " INSERT INTO $table_name ($fields) VALUES ($values) ";

    $result = $this->connect()->query($sql);

    return $result;
  }

  // //function for get single record
  public function getDataById($table_name, $fields, $where, $id)
  {
    $sql = "SELECT $fields FROM $table_name Where $where = $id ";

    $result = $this->connect()->query($sql);

    return $result;
  }

  // function for update data
  public function updateEmployee($table_name, $param, $where, $id)
  {
    $checkmail = $param["veh_no"];

    $sql = "SELECT * FROM $table_name WHERE veh_no  = '{$checkmail}' ";

    $sql_check = $this->connect()->query($sql);

    $sql = "UPDATE users SET ";

    $fields = [];
    $values = [];

    $length = count($param);
    $i = 1;

    foreach ($param as $key => $value) {
      if ($i == $length) {
        $sql .= " $key='$value'  ";
      } else {
        $sql .= " $key='$value' , ";
      }
      $i++;
    }

    $sql .= "Where $where = $id";

    $result = $this->connect()->query($sql);

    return $result;
  }

  //function for delete created entry
  public function deleteRecord($table_name, $where, $id)
  {
    $sql = "DELETE  FROM $table_name Where $where = '$id' ";

    $result = $this->connect()->query($sql);
    return $result;
  }

  //function for delete completed entry

  public function deleteComplete($table_name, $where, $id, $data)
  {
    $sql = "UPDATE $table_name  SET";

    foreach ($data as $key => $value) {
      $sql .= " $key = '$value' ";
    }

    $sql .= "WHERE $where = '$id' ";

    $res = $this->connect()->query($sql);
    return $res;
  }

  //out user

  public function checkOut($table_name, $out, $where, $id)
  {
    $current_timestamp = date("Y-m-d H:i:s");

    $current_timestamp;

    $sql = " UPDATE  $table_name SET $out =  '$current_timestamp' , status = '1' WHERE $where = $id ";

    $res = $this->connect()->query($sql);

    if (!$res) {
      // Query failed, display the error message
      return false;
    } else {
      // Query succeeded, return the result
      return $res;
    }
  }
}

?>
