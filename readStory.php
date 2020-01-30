<?php

    session_start();
    require("includes/header.php");
    $storyID = $_GET['storyID'];
?>

<div class="page-background">
    <div class="container-login background-image read-story overlay">
<?php

    if (!empty($storyID)) {
        require_once("includes/db_connection.php");
        require_once("includes/story_helper.php");
        $heartedStories = [];
        $heartedStoriesID = getHeartedStories($storyID, $connection);

        $sql = "SELECT timestamp, username, title, story, heart, country FROM story WHERE storyID = ?";

        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('i', $storyID);
            $stmt->execute();

            $result = $stmt->get_result();

            $storyTitle = "";
            $storyUser = "";
            $storyContent = "";
            $storyHeart = null;

            while ($row = $result->fetch_assoc()) {
                $storyTitle = $row['title'];
                $storyUser = $row['username'];
                $storyContent = $row['story'];
                $storyHeart = $row['heart'];
                $storyCountry = $row['country'];
                $date = $row['timestamp'];
                $storyDate = date("F j, Y", $date);

                $storyDivID = 'story_' . $storyID;

                echo "<div class='story-post separate-page' id='" . $storyDivID . "'>";
                echo "<div class='story-title'>";
                    echo "<div class='story-top'>";
                        echo "<h3>" . $storyTitle . "</h3>";
                        echo "<div class='hearts'>";
                        echo "<img src='img/heart.png' alt='heart icon'>";
                        echo "<p class='heart-number'>" . $storyHeart . "</p>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='story-metadata'>";
                        echo "<p>" . $storyUser . " | " . $storyCountry . "</p>";
                        echo "<p>" . $storyDate . "</p>";
                    echo "</div>";                        
                echo "</div>";
            
                echo "<div class='story-content'>";
                    echo "<p>" . nl2br($storyContent) . "</p>";
                echo "</div>";
                echo "<div class='add-heart'>";
                if (in_array($storyID, $heartedStoriesID)) {
                    echo "<div class='heart-button clicked'>";
                        echo "<img src='img/heart_clicked.png'>";
                    echo "</div>";
                } else {
                    if (isset($_SESSION['username'])) {
                        echo "<div class='heart-button' onclick='addHeart(".$storyDivID.")'>";
                            echo "<p>Send a </p>";
                            echo "<img src='img/heart.png'>";
                        echo "</div>";
                    } else {
                        echo "<a class='heart-button' href='login.php'>";
                            echo "<p>Send a </p>";
                            echo "<img src='img/heart.png'>";
                        echo "</a>";
                    }
                }
                echo "</div>";
            echo "</div>";
                
            }
        } else {
            $error = $connection->errno . ' ' . $connection->error;
            echo $error;
        }
    } else {
        header("Location: index.php");
    }
?>

    </div>
</div>
<div class="footer">
    <p>© 2020 MambaAndMe. All Rights Reserved.</p>
</div>
<script src="js/hearts.js"></script>

</body>
</html>