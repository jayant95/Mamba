<?php
    session_start();
    $status = $_GET['status'];

    if ($status == "success") {
        $numHearts = $_GET['hearts'];
        $fullID = $_GET['id'];
        $exploded = explode('_', $fullID);
        $storyID = intval(end($exploded));

        require_once("db_connection.php");

        //$sql = "UPDATE story SET heart = " . $numHearts . " WHERE storyID = " . $storyID;

        // $myfile = fopen("log.txt", "w");
        // fwrite($myfile, $fullID);
        // fwrite($myfile, $sql);
        // fclose($myfile);

        $sql = "UPDATE story SET heart = ? WHERE storyID = ?";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('ii', $numHearts, $storyID);
            $stmt->execute();
        } else {
            // error
        }

        $stmt->close();

        // Insert a new row to hearts with that memberID and storyID
        $sql = "INSERT INTO hearts (storyID, memberID) VALUES (?, ?)";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('ii', $storyID, $_SESSION['memberID']);
            $stmt->execute();
        } else {
            // error
        }

        $connection->close();
    }


?>