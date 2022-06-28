<?php
$UID = $_POST['UID'];
$Password = $_POST['Password'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "central";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die('Could not connect to the database.');
}
else {
    $Select = "SELECT UID FROM student WHERE UID = ? LIMIT 1";
    $Insert = "INSERT into student(UID, Password) values(?, ?)";

    $stmt = $conn->prepare($Select);
    $stmt->bind_param("s", $UID);
    $stmt->execute();
    $stmt->bind_result($UID);
    $stmt->store_result();
    $stmt->fetch();
    $rnum = $stmt->num_rows;

    if ($rnum == 0)
    {
        $stmt->close();

        $stmt = $conn->prepare($Insert);
        $stmt->bind_param("ss",$UID, $Password);
        if ($stmt->execute()) 
        {
            echo "New record inserted sucessfully.";
        }
        else 
        {
            echo $stmt->error;
        }
    }
    else 
    {
        echo "Someone already registered using this email.";
    }
    $stmt->close();
    $conn->close();
}
?>