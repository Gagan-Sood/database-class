<?php
include "Database.php";

$db = new Database();
if (!empty($_POST['save'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $values = ["name" => $name, "age" => $age, "city" => $city];
    if ($db->insert("students", $values)) {
        echo "<h2>Data inserted Successfully</h2>";
    } else {
        echo "<h2>Data not inserted. Please fill correct information</h2>";
    }
}
?>