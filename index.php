<?php
  session_start();
  $siteTitle = "MambaAndMe | Kobe Bryant | Inspirational Short Stories";
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
    <div class="container-login background-image home overlay homepage">
        <div class="wrap-login homepage">
            <div class="welcome-header">
                <h1>Short stories inspired by Kobe Bryant, from fans around the world.</h1>
                <h3>"Everything negative – pressure, challenges – is all an opportunity for me to rise." - Kobe Bryant</h3>
            </div>
        </div>
    </div>

    <div class="favourite-posts">
        <div class="top-posts-wrapper">
            <div class="top-post-header">
                <h2>Popular Stories</h2>
            </div>
            <?php
                $sql = "SELECT storyID, username, title, story, heart, country FROM story ORDER BY heart DESC LIMIT 3";
                
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

                        echo "<div class='top-post' id=".$storyDivID.">";
                        echo "<div class='story-heading'>";
                            echo "<a class='story-title-link' href='readStory.php?storyID=".$id."'><h3>" . $storyTitle . "</h3></a>";
                            echo "<div class='hearts'>";
                                echo "<img src='img/heart.png' alt='heart icon'>";
                                echo "<p class='heart-number'>" . $storyHeart . "</p>";
                            echo "</div>";
                        echo "</div>";
                        echo "<h4>" . $storyUser . " | " . $storyCountry . "</h4>";
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
				    <input class="form-input post-story-btn" type="text" name="title" placeholder="Write your story here...">
                </a>
            </div>
        </form>
    </div>
    
    <div class="story" id="story">
        <div class="story-header">
            <a href="allStories.php"><h2>Stories</h2></a>
        </div>
        <?php  
            // If logged in, retrieve the users hearted stories
            $heartedStoriesID = [];
            $row_cnt = 0;
            // Get total number of records from table
            $sql = "SELECT * FROM story";
            if ($result = $connection->query($sql)) {
                $row_cnt = $result->num_rows;
                $result->close();
            }

            // Check if page num is specified, if not, return default page (1)
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            // Num results to show per page
            $num_results_on_page = 5;


           // $start_from = ($pn-1) * $limit;

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

            $sql = "SELECT storyID, timestamp, username, title, story, heart, country, videoID FROM story ORDER BY timestamp DESC LIMIT ?,?";

            if ($stmt = $connection->prepare($sql)) {
                // Calculate the page to get results
                $calc_page = ($page - 1) * $num_results_on_page;
                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
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
                $videoID = $row['videoID'];
                $storyCountry = $row['country'];
                $date = date("F j, Y", $time);
                $storyID = $row['storyID'];
                $storyDivID = 'story_' . $storyID;

                $shortenedStory = strip_tags($story);
                $overLimit = false;        
                if (strlen($shortenedStory) > 500) {
                    $overLimit = true;
                    // truncate string
                    $storyCut = substr($shortenedStory, 0, 500);
                    $endPoint = strrpos($storyCut, ' ');

                    $shortenedStory = $endPoint ? substr($storyCut, 0, $endPoint) : substr($storyCut, 0);
                    $shortenedStory .= "... <a href='readStory.php?storyID=".$storyID."' class='read-more-link' href='#'>read more</a>";
                }

                echo "<div class='story-post' id='" . $storyDivID . "'>";
                    echo "<div class='story-title'>";
                        echo "<div class='story-top'>";
                            echo "<a class='story-title-link' href='readStory.php?storyID=".$storyID."'><h3>" . $title . "</h3></a>";
                            echo "<div class='hearts'>";
                            echo "<img src='img/heart.png' alt='heart icon'>";
                            echo "<p class='heart-number'>" . $heart . "</p>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='story-metadata'>";
                            echo "<p>" . $username . " | " . $storyCountry . "</p>";
                            echo "<p>" . $date . "</p>";
                        echo "</div>";                        
                    echo "</div>";
                
                    echo "<div class='story-content'>";
                        echo "<p>" . nl2br($shortenedStory) . "</p>";
                    echo "</div>";

                    if (!empty($videoID) && !$overLimit) {
                        echo "<div class='video-container'>";
                            echo "<iframe ";
                            echo "src= 'https://www.youtube.com/embed/" . $videoID . "'>";
                            echo "</iframe>";
                        echo "</div>";
                    }

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
                            echo "<a class='heart-button' href='login.php?loggedin=false'>";
                                echo "<p>Send a </p>";
                                echo "<img src='img/heart.png'>";
                            echo "</a>";
                        }
                    }
                    echo "</div>";
                echo "</div>";
            } 
        ?>

        <?php if (ceil($row_cnt / $num_results_on_page) > 0): ?>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="prev"><a href="index.php?page=<?php echo $page-1 ?>#story">Prev</a></li>
                <?php endif; ?>

                <?php if ($page > 3): ?>
                    <li class="start"><a href="index.php?page1#story">1</a></li>
                    <li class="dots">...</li>
                <?php endif; ?>

                <?php if ($page-2 > 0): ?><li class="page"><a href="index.php?page=<?php echo $page-2 ?>#story"><?php echo $page-2 ?></a></li><?php endif; ?>
                <?php if ($page-1 > 0): ?><li class="page"><a href="index.php?page=<?php echo $page-1 ?>#story"><?php echo $page-1 ?></a></li><?php endif; ?>

                <li class="currentpage"><a href="index.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                <?php if ($page+1 < ceil($row_cnt / $num_results_on_page)+1): ?><li class="page"><a href="index.php?page=<?php echo $page+1 ?>#story"><?php echo $page+1 ?></a></li><?php endif; ?>
                <?php if ($page+2 < ceil($row_cnt / $num_results_on_page)+1): ?><li class="page"><a href="index.php?page=<?php echo $page+2 ?>#story"><?php echo $page+2 ?></a></li><?php endif; ?>

                <?php if ($page < ceil($row_cnt / $num_results_on_page)-2): ?>
                    <li class="dots">...</li>
                    <li class="end"><a href="index.php?page=<?php echo ceil($row_cnt / $num_results_on_page) ?>#story"><?php echo ceil($row_cnt / $num_results_on_page) ?></a></li>
                <?php endif; ?>

                <?php if ($page < ceil($row_cnt / $num_results_on_page)): ?>
                    <li class="next"><a href="index.php?page=<?php echo $page+1 ?>#story">Next</a></li>
                <?php endif; ?>
            </ul>
                
        <?php endif; ?>
            

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