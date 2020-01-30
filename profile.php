<?php
  session_start();
  require("includes/header.php");
  require("includes/db_connection.php");

?>

<div class="page-background">
    <div class="container-login background-image profile overlay">

    <div class="profile-user">
        <div class="profile-user-posts">
            <h2>Your Stories</h2>
        </div>
<?php    
  
if (isset($_SESSION['username'])) {

    // retrieve and display users posts
    $sql = "SELECT storyID, timestamp, title, story, heart FROM story WHERE memberID = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('i', $_SESSION['memberID']);
        $stmt->execute();

        $result = $stmt->get_result();

        $storyTitle = "";
        $storyUser = "";
        $storyContent = "";
        $storyHeart = null;

        while ($row = $result->fetch_assoc()) {
            $storyTitle = $row['title'];
            $storyContent = $row['story'];
            $storyHeart = $row['heart'];
            $date = $row['timestamp'];
            $storyID = $row['storyID'];
            $storyDate = date("F j, Y", $date);

            $storyDivID = 'story_' . $storyID;

            $shortenedStory = strip_tags($storyContent);
                        
            if (strlen($shortenedStory) > 300) {
                // truncate string
                $storyCut = substr($shortenedStory, 0, 300);
                $endPoint = strrpos($storyCut, ' ');

                $shortenedStory = $endPoint ? substr($storyCut, 0, $endPoint) : substr($storyCut, 0);
                $shortenedStory .= "... <a href='readStory.php?storyID=".$storyID."' class='read-more-link' href='#'>read more</a>";
            }

            echo "<div class='story-post profile-page' id='" . $storyDivID . "'>";
                echo "<div class='story-title'>";
                    echo "<div class='story-top'>";
                        echo "<h3>" . $storyTitle . "</h3>";
                    echo "<div class='hearts'>";
                        echo "<img src='img/heart.png' alt='heart icon'>";
                        echo "<p class='heart-number'>" . $storyHeart . "</p>";
                    echo "</div>";
                echo "</div>";
                echo "<div class='story-metadata'>";
                    echo "<p>" . $storyDate . "</p>";
                echo "</div>";                        
            echo "</div>";
        
            echo "<div class='story-content'>";
                echo "<p>" . nl2br($shortenedStory) . "</p>";
            echo "</div>";
            echo "<div class='add-heart'>";
                echo "<div class='heart-button clicked'>";
                    echo "<img src='img/heart_clicked.png'>";
                echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        $error = $connection->errno . ' ' . $connection->error;
        echo $error;
    } 
    
    // Get hearted stories ID
    require_once("includes/story_helper.php");
    $heartedStoriesID = [];
    $heartedStoriesID = getHeartedStories($storyID, $connection);




} else {
    header("Location: index.php");
}
?>

  </div>
</div>

<?php require("includes/footer.php") ?>