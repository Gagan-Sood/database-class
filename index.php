<?php
include "Database.php";

$obj = new Database();
// $obj->insert('students',['name' => "Sham Gupta", "age" => 22, "city" => "Delhi"]);
// $obj->update('students',['name' => "Sham Naresh", "age" => 20], "id='6'");
// $obj->delete('students', "id='6'");
// $obj->select('students','*',null,null,null,2);
echo $obj->pagination('students','*',null,null,1);
?>