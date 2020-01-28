<?php
  session_start();
  require("includes/header.php");
  require_once("includes/db_connection.php");

  if (isset($_POST['submit'])) {
    $user['title'] = !empty($_POST['title']) ? $_POST['title'] : "";
    $user['story'] = !empty($_POST['story']) ? $_POST['story'] : "";

    $errors = [];
    if (empty($user['title'])) $errors[] = "Oops, your title cannot be blank";
    if (empty($user['story'])) $errors[] = "Oops, your story cannot be blank";

    if (empty($errors)) {
      
    }
}
  
?>

<div class="page-background">
    <div class="container-login background-image home overlay">
        <div class="wrap-login homepage">
            <div class="welcome-header">
                <h1>"Everything negative – pressure, challenges – is all an opportunity for me to rise."</h1>
                <h3>Share your stories on how Kobe Bryant influenced and motivated your life</h3>
            </div>
        </div>
    </div>

    <div class="favourite-posts">
        <div class="top-posts-wrapper">
            <div class="top-post-header">
                <h2>Top Stories</h2>
            </div>
            <?php
                $sql = "SELECT storyID, username, title, story, heart FROM story ORDER BY heart DESC LIMIT 3";
                
                if ($stmt = $connection->prepare($sql)) {
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
                        $id = $row['storyID'];
                        $storyDivID = 'topStory_' . $id;

                        $shortenedStory = strip_tags($storyContent);
                        
                        if (strlen($shortenedStory) > 300) {
                            // truncate string
                            $storyCut = substr($shortenedStory, 0, 300);
                            $endPoint = strrpos($storyCut, ' ');

                            $shortenedStory = $endPoint ? substr($storyCut, 0, $endPoint) : substr($storyCut, 0);
                            $shortenedStory .= "... <a href='readStory.php?storyID=".$id."' class='read-more-link' href='#'>read more</a>";
                        }

                        echo "<div class='top-post' id=".$storyDivID.">";
                        echo "<div class='story-heading'>";
                            echo "<h3>" . $storyTitle . "</h3>";
                            echo "<div class='hearts'>";
                                echo "<img src='img/heart.png' alt='heart icon'>";
                                echo "<p class='heart-number'>" . $storyHeart . "</p>";
                            echo "</div>";
                        echo "</div>";
                        echo "<h4>" . $storyUser . "</h4>";
                        echo "<p>" . $shortenedStory . "</p>";
                        echo "</div>";
                        
                    }
                }
            
            ?>
        </div>
    </div>

    <div class="user-story-wrapper">
        <form class="user-story">
            <div class="wrap-input post">
                <a href="story.php">
				    <input class="form-input" type="text" name="title" placeholder="Write your story here">
                </a>
            </div>
        </form>
    </div>
    
    <div class="story" id="story">
        <div class="story-header">
            <h2>Stories</h2>
        </div>
        <?php  
            // If logged in retrieve the users hearted stories
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

            if ($stmt = $connection->prepare('SELECT storyID, timestamp, username, title, story, heart FROM story ORDER BY timestamp DESC')) {
                $stmt->execute();
            } else {
                $error = $connection->errno . ' ' . $connection->error;
                echo $error;
            }

            $result = $stmt->get_result();
            $time = "";
            $username = "";
            $title = "";
            $story = "";
            $storyID = null;
            $heart = null;

            while ($row = $result->fetch_assoc()) {
                $time = $row['timestamp'];
                $username = $row['username'];
                $title = $row['title'];
                $story = $row['story'];
                $heart = $row['heart'];
                $date = date("F j, Y", $time);
                $storyID = $row['storyID'];
                $storyDivID = 'story_' . $storyID;

                $shortenedStory = strip_tags($story);
                        
                if (strlen($shortenedStory) > 300) {
                    // truncate string
                    $storyCut = substr($shortenedStory, 0, 300);
                    $endPoint = strrpos($storyCut, ' ');

                    $shortenedStory = $endPoint ? substr($storyCut, 0, $endPoint) : substr($storyCut, 0);
                    $shortenedStory .= "... <a href='readStory.php?storyID=".$storyID."' class='read-more-link' href='#'>read more</a>";
                }

                echo "<div class='story-post' id='" . $storyDivID . "'>";
                    echo "<div class='story-title'>";
                        echo "<div class='story-top'>";
                            echo "<h3>" . $title . "</h3>";
                            echo "<div class='hearts'>";
                            echo "<img src='img/heart.png' alt='heart icon'>";
                            echo "<p class='heart-number'>" . $heart . "</p>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='story-metadata'>";
                            echo "<p>" . $username . "</p>";
                            echo "<p>" . $date . "</p>";
                        echo "</div>";                        
                    echo "</div>";
                
                    echo "<div class='story-content'>";
                        echo "<p>" . nl2br($shortenedStory) . "</p>";
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
            
        ?>
    </div>
</div>

<script src="js/hearts.js"></script>

</body>
</html>