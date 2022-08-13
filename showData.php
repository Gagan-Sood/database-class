<?php
include "Database.php";

$obj = new Database();
$columns = "students.id, students.name, students.age, city.name as cname";
$join = "city on students.city = city.id";
$limit = 2;
$obj->select('students',$columns,$join,null,null,$limit);
$result = $obj->getResult();

if (!empty($result)) {
    echo "<table border = '1' width = '100%'>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Age</th>
            <th>City</th>
        </tr>";
    foreach ($result as list("id" => $id, "name" => $name, "age" => $age, "cname" => $cname)) {
        echo "<tr><td>$id</td><td>$name</td><td>$age</td><td>$cname</td></tr>";
    }
    echo "</table";
}
echo $obj->pagination('students',$columns,$join,null,$limit);
?>