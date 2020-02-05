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

        $stmt = $connection->prepare('INSERT INTO story (memberID, timestamp, username, title, story, heart, country, videoID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issssiss', $data['memberID'], $date, $data['username'], $data['title'], $data['story'], $hearts, $data['country'], $data['videoCode']);
    
        $stmt->execute();

        $stmt->close();
        $connection->close();

        header("Location: confirmation.php");
    }

    function getHeartedStories($storyID, $connection) {
        $heartedStoriesID = [];
        if (isset($_SESSION['username'])) {
            $sql = "SELECT storyID FROM hearts WHERE memberID = ?";
            if ($stmt = $connection->prepare($sql)) {
                $stmt->bind_param('i', $_SESSION['memberID']);
                $stmt->execute();

                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $heartedStoriesID[] = $row['storyID'];
                }
            }
            $stmt->close();
        }

        return $heartedStoriesID;
    }

?>