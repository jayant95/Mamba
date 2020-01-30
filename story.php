<?php
session_start();
require("includes/header.php");

$data = [];

if (isset($_SESSION['username'])) {
    if (isset($_POST['submit'])) {
        $data['title'] = !empty($_POST['title']) ? $_POST['title'] : "";
        $data['story'] = !empty($_POST['story']) ? $_POST['story'] : "";
    
        $errors = [];
        if (empty($data['title'])) $errors[] = "Oops, your title cannot be blank";
        if (empty($data['story'])) $errors[] = "Oops, your story cannot be blank";
    
        if (empty($errors)) {
            require_once("includes/story_helper.php");
            require_once("includes/db_connection.php");
            
            // Get country of user 
            require_once("includes/geo_country.php");
            $country = "";
            $country = getCountryFromDB($_SESSION['memberID'], $connection);
            $data['country'] = $country;
            postStory($data, $connection);
    
            header("Location: index.php#story");
        }
    }
} else {
    header("Location: login.php?loggedin=false");
}
?>


<div class="login-wrapper">
    <div class="container-login background-image story overlay">
        <div class="wrap-login write-story">
            <form class="user-comment" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="post-story-header">
                    <h2>Post your story</h2>
                </div>
                <div class="wrap-input">
                    <input class="form-input" type="text" name="title" placeholder="Title" />
                </div>
                <div class="wrap-input textarea">
                    <textarea class="form-input" name="story" placeholder="Write your story here..."></textarea>
                </div>
                <div class="user-submit-btn">
                    <input class="story-submit-button" type="submit" name="submit" value="Post" />
                </div>
            </form>
        </div>
	</div>
</div>

<?php require("includes/footer.php")  ?>