<?php

    function getHearts($connection) {
        $heart = 0;

        $stmt = $connection->prepare('SELECT heart FROM story WHERE memberID = ?');
        $stmt->bind_param('i', $_SESSION['memberID']);
    
        $stmt->execute();

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $heart = $row['heart'];
        }

        $stmt->close();
        $connection->close();

        return $heart;
    }

    function postStory($data, $connection) {
        $hearts = 0;
        $date = time();

        $stmt = $connection->prepare('INSERT INTO story (memberID, timestamp, username, title, story, heart) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issssi', $_SESSION['memberID'], $date, $_SESSION['username'], $data['title'], $data['story'], $hearts);
    
        $stmt->execute();

        $stmt->close();
        $connection->close();

        $_SESSION['message'] = "Thank you for sharing your story!";
        header("Location: index.php#story");
    }

?>