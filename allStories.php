<?php

    session_start();
    $siteTitle = "MambaAndMe | All Stories";
    require("includes/header.php");
    require("includes/db_connection.php");


    if (isset($_SESSION['post-message'])) {
        echo "<div class='site-message'>";
        echo "<p>" . $_SESSION['post-message'] . "</p>";
        echo "</div>";
        unset($_SESSION['post-message']);
    }
?>

<div class="page-background">
        <div class="story all-stories" id="story">
            <div class="story-header">
                <h2>All Stories</h2>
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

                $sql = "SELECT storyID, timestamp, username, title, story, heart, country FROM story ORDER BY timestamp DESC LIMIT ?,?";

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
                    $storyCountry = $row['country'];
                    $date = date("F j, Y", $time);
                    $storyID = $row['storyID'];
                    $storyDivID = 'story_' . $storyID;

                    $shortenedStory = strip_tags($story);
                            
                    if (strlen($shortenedStory) > 500) {
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
                        <li class="prev"><a href="allStories.php?page=<?php echo $page-1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="start"><a href="allStories.php?page1">1</a></li>
                        <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?><li class="page"><a href="allStories.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><a href="allStories.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="allStories.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page+1 < ceil($row_cnt / $num_results_on_page)+1): ?><li class="page"><a href="allStories.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                    <?php if ($page+2 < ceil($row_cnt / $num_results_on_page)+1): ?><li class="page"><a href="allStories.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($row_cnt / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="allStories.php?page=<?php echo ceil($row_cnt / $num_results_on_page) ?>"><?php echo ceil($row_cnt / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($row_cnt / $num_results_on_page)): ?>
                        <li class="next"><a href="allStories.php?page=<?php echo $page+1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
                    
            <?php endif; ?>
                

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
    <a href="https://www.instagram.com/mambaandme24/">Instagram</a>
    <p>© 2020 MambaAndMe. All Rights Reserved.</p>
</div>
<script src="js/hearts.js"></script>

</body>
</html>