<?php
session_start();
class Database
{

     private $host = "localhost";
     private $username = 'root';
     private $password = '';
     private  $database = 'tps';
     public $connect;

     public function database_connect()
     {
          $this->connect = null;
          try {
               $this->connect = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password, [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
               ]);
               // echo "Connected successfully";

          } catch (PDOException $e) {
               // echo "Connection failed: " . $e->getMessage();
               return $e->getMessage();
          }
          return $this->connect;
     }

     // public function can_login($table_name,$where_condition){
     //      $condition = '';
     //      $array=array();
     //      foreach ($where_condition as $key => $value) {
     //         $condition .= $key . " = '".$value."' AND ";
     //      }
     //       $condition = substr($condition, 0, -5);
     //         $query = "SELECT * FROM ".$table_name." WHERE ". $condition;
     //       $result = mysqli_query($this->connect, $query);
     //            while ($record = mysqli_fetch_array($result)) {
     //               $array[] = $record;
     //          }
     //          return $array;

     // }

     public function get_employee_data($query)
     {
          $output = '';
          $result = $this->execute_query($query);
          $output .= '

           ';
          while ($row = mysqli_fetch_object($result)) {
               if ($row->gender == 'M') {
                    $gender = 'Male';
               } else {
                    $gender = 'Female';
               }
               $output .= '
                <tr>
                     <td>' . $row->employee_id . '</td>
                     <td>' . $row->employee_name . '</td>
                     <td>' . $row->address . '</td>
                     <td>' . $gender . '</td>
                     <td>' . $row->birthday . '</td>
                     <td><button type="button" name="update" id="' . $row->id . '" class="btn btn-success btn-xs updateEmployee">Update</button><button type="button" name="delete" id="' . $row->id . '" class="btn btn-danger btn-xs deleteEmployee">Delete</button></td>
                </tr>
                ';
          }
          $output .= '';
          return $output;
     }
     public function get_customer_data($query)
     {
          $output = '';
          $result = $this->execute_query($query);
          $output .= '

           ';
          while ($row = mysqli_fetch_object($result)) {
               if ($row->gender == 'M') {
                    $gender = 'Male';
               } else {
                    $gender = 'Female';
               }
               $output .= '
                <tr>
                     <td>' . $row->employee_id . '</td>
                     <td>' . $row->employee_name . '</td>
                     <td>' . $row->address . '</td>
                     <td>' . $gender . '</td>
                     <td>' . $row->birthday . '</td>
                     <td><button type="button" name="update" id="' . $row->id . '" class="btn btn-success btn-xs updateEmployee">Update</button><button type="button" name="delete" id="' . $row->id . '" class="btn btn-danger btn-xs deleteEmployee">Delete</button></td>
                </tr>
                ';
          }
          $output .= '';
          return $output;
     }
     public function get_inventory_data($query)
     {
          $output = '';
          $result = $this->execute_query($query);
          $output .= '

           ';
          while ($row = mysqli_fetch_object($result)) {
               if ($row->gender == 'M') {
                    $gender = 'Male';
               } else {
                    $gender = 'Female';
               }
               $output .= '
                <tr>
                     <td>' . $row->employee_id . '</td>
                     <td>' . $row->employee_name . '</td>
                     <td>' . $row->address . '</td>
                     <td>' . $gender . '</td>
                     <td>' . $row->birthday . '</td>
                     <td><button type="button" name="update" id="' . $row->id . '" class="btn btn-success btn-xs updateEmployee">Update</button><button type="button" name="delete" id="' . $row->id . '" class="btn btn-danger btn-xs deleteEmployee">Delete</button></td>
                </tr>
                ';
          }
          $output .= '';
          return $output;
     }
     public function get_task_data($query)
     {
          $output = '';
          $result = $this->execute_query($query);
          $output .= '

           ';
          while ($row = mysqli_fetch_object($result)) {
               if ($row->gender == 'M') {
                    $gender = 'Male';
               } else {
                    $gender = 'Female';
               }
               $output .= '
                <tr>
                     <td>' . $row->employee_id . '</td>
                     <td>' . $row->employee_name . '</td>
                     <td>' . $row->address . '</td>
                     <td>' . $gender . '</td>
                     <td>' . $row->birthday . '</td>
                     <td><button type="button" name="update" id="' . $row->id . '" class="btn btn-success btn-xs updateEmployee">Update</button><button type="button" name="delete" id="' . $row->id . '" class="btn btn-danger btn-xs deleteEmployee">Delete</button></td>
                </tr>
                ';
          }
          $output .= '';
          return $output;
     }
     public function get_delivery_data($query)
     {
          $output = '';
          $result = $this->execute_query($query);
          $output .= '

           ';
          while ($row = mysqli_fetch_object($result)) {
               if ($row->gender == 'M') {
                    $gender = 'Male';
               } else {
                    $gender = 'Female';
               }
               $output .= '
                <tr>
                     <td>' . $row->employee_id . '</td>
                     <td>' . $row->employee_name . '</td>
                     <td>' . $row->address . '</td>
                     <td>' . $gender . '</td>
                     <td>' . $row->birthday . '</td>
                     <td><button type="button" name="update" id="' . $row->id . '" class="btn btn-success btn-xs updateEmployee">Update</button><button type="button" name="delete" id="' . $row->id . '" class="btn btn-danger btn-xs deleteEmployee">Delete</button></td>
                </tr>
                ';
          }
          $output .= '';
          return $output;
     }
}
