<?php

    session_start();
    $siteTitle = "MambaAndMe | All Stories";
    require("includes/header.php");
    require("includes/db_connection.php");
?>

<div class="page-background">
    <div class="story confirmation-container">
        <div class="story-header">
            <h2>Thank You</h2>
       </div>
       <div class="confirmation-content">
            <p>Thank you so much for sharing your story! Read other stories below from other fans across the world!</p>
            <p>If you'd like to leave a 'heart' for others, feel free to register or log in.</p>
        </div>
    </div>

    <div class="story most-recent">
            <div class="story-header">
                <h2>Recent Stories</h2>
            </div>
            <?php
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

                    // $stmt->close();
                }

                $sql = "SELECT storyID, username, title, story, heart, timestamp, country FROM story ORDER BY timestamp DESC LIMIT 3";
                
                if ($stmt = $connection->prepare($sql)) {
                    $stmt->execute();

                    $result = $stmt->get_result();

                    $storyTitle = "";
                    $storyUser = "";
                    $storyContent = "";
                    $storyHeart = null;

                    while ($row = $result->fetch_assoc()) {
                        $date = date("F j, Y", $row['timestamp']);
                        $storyTitle = $row['title'];
                        $storyUser = $row['username'];
                        $storyContent = $row['story'];
                        $storyHeart = $row['heart'];
                        $id = $row['storyID'];
                        $storyCountry = $row['country'];
                        $storyDivID = 'topStory_' . $id;

                        $shortenedStory = strip_tags($storyContent);
                        
                        if (strlen($shortenedStory) > 300) {
                            // truncate string
                            $storyCut = substr($shortenedStory, 0, 300);
                            $endPoint = strrpos($storyCut, ' ');

                            $shortenedStory = $endPoint ? substr($storyCut, 0, $endPoint) : substr($storyCut, 0);
                            $shortenedStory .= "... <a href='readStory.php?storyID=".$id."' class='read-more-link' href='#'>read more</a>";
                        }

                    echo "<div class='story-post' id='" . $storyDivID . "'>";
                        echo "<div class='story-title'>";
                            echo "<div class='story-top'>";
                                echo "<a class='story-title-link' href='readStory.php?storyID=".$id."'><h3>" . $storyTitle . "</h3></a>";
                                echo "<div class='hearts'>";
                                echo "<img src='img/heart.png' alt='heart icon'>";
                                echo "<p class='heart-number'>" . $storyHeart . "</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='story-metadata'>";
                                echo "<p>" . $storyUser . " | " . $storyCountry . "</p>";
                                echo "<p>" . $date . "</p>";
                            echo "</div>";                        
                        echo "</div>";
                    
                        echo "<div class='story-content'>";
                            echo "<p>" . nl2br($shortenedStory) . "</p>";
                        echo "</div>";
                        echo "<div class='add-heart'>";
                        if (in_array($id, $heartedStoriesID)) {
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
                                echo "<a class='heart-button' href='login.php?loggedin=false'>";
                                    echo "<p>Send a </p>";
                                    echo "<img src='img/heart.png'>";
                                echo "</a>";
                            }
                        }
                        echo "</div>";
                    echo "</div>";
                        
                    }
                }
            ?>
            <div class="all-stories-container">
                <a href="allStories.php" class="all-stories-btn">View All</a>
            </div>
        </div>

</div>
<?php
    $word = "Foundations";
    if (strpos($siteTitle, $word) === false) {
        ?>
          <div class="donate-area">
              <a href="donate.php">Donate to Kobe's personal and supported foundations here</a>
          </div>
        <?php
    }
?>
<div class="footer">
    <div class="footer-links">
        <a href="https://www.instagram.com/mambaandme24/">Instagram</a>
        <a href="about.php#about">About the Creator</a>
    </div>
    <div class="footer-info">
        <p>Handcoded in Seattle, Washington</p>
        <p>© 2020 MambaAndMe. All Rights Reserved.</p>
    </div>
</div>
<script src="js/hearts.js"></script>

</body>
</html>