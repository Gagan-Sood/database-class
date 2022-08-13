<?php
    include "Database.php";
    $db = new Database();
    $db->select('city');
    $cities = $db->getResult();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
   <form action="saveData.php" method="POST">
        <label>Student Name</label>
        <input type="text" name="name" />
        </br></br>
        <label>Student Age</label>
        <input type="number" name="age" />
        </br></br>
        <label>City</label>
        <select name="city">
            <?php
                foreach ($cities as list("id" => $id, "name" => $name)) {
                    echo "<option value='$id'>$name</option>";
                }
            ?>
        </select>
        </br></br>
        <input type="submit" value="Save" name="save" />
   </form> 
</body>
</html>