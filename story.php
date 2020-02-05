<?php
session_start();
$siteTitle = "MambaAndMe | Write a Story";
require("includes/header.php");

    $data = [];
    $loggedIn = false;
    if (isset($_SESSION['username'])) {
        $loggedIn = true;
    } else {
        $_SESSION['message'] = "You can post anonymously! Logging in would further allow you to track your story and give hearts to others.";
    }


    if (isset($_POST['submit'])) {
        $data['title'] = !empty($_POST['title']) ? $_POST['title'] : "";
        $data['story'] = !empty($_POST['story']) ? $_POST['story'] : "";
        $videoLink = !empty($_POST['video']) ? $_POST['video'] : "";
        
        $data['videoCode'] = "";
        $regex_pattern = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
        $match;
        
        if(!preg_match($regex_pattern, $videoLink, $match)){
            $errors[] = "Sorry, not a youtube URL";
        } else {
            $data['videoCode'] = $match[4];
            echo $data['videoCode'];
        }

        $errors = [];
        if (empty($data['title'])) $errors[] = "Oops, your title cannot be blank";
        if (empty($data['story'])) $errors[] = "Oops, your story cannot be blank";

        if (empty($errors)) {
            require_once("includes/story_helper.php");
            require_once("includes/db_connection.php");
            require_once("includes/geo_country.php");

            $country = "";

            // Get country of user from DB
            if ($loggedIn) {
                $country = getCountryFromDB($_SESSION['memberID'], $connection);
                $data['country'] = $country;
                $data['memberID'] = $_SESSION['memberID'];
                $data['username'] = $_SESSION['username'];
            } else {
                $address = getVisitorCountry();
                $addressData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $address));
                $country = $addressData->geoplugin_countryName;
                $data['country'] = strVal($country);
                $data['memberID'] = -1;
                $data['username'] = "Anonymous";
            }

            postStory($data, $connection);
        }
    }

    if (isset($_SESSION['message'])) {
        echo "<div class='site-message'>";
        echo "<p>" . $_SESSION['message'] . "</p>";
        echo "</div>";
        unset($_SESSION['message']);
    }
?>


<div class="login-wrapper">
    <div class="container-login background-image story overlay">
        <div class="wrap-login write-story">
            <form class="user-comment" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="post-story-header">
                    <h2>Post your story</h2>
                    <h3>Share your story of Kobe. If you have a YouTube video, tribute or your favorite moment, feel free to share the link below.</p> 
                </div>
                <div class="wrap-input">
                    <input class="form-input" type="text" name="title" placeholder="Title" />
                </div>
                <div class="wrap-input textarea">
                    <textarea class="form-input" name="story" placeholder="Write your story here..."></textarea>
                </div>
                <div class="wrap-input">
                    <input class="form-input" type="text" name="video" placeholder="Optional YouTube link..." />
                </div>
                <div class="user-submit-btn">
                    <input class="story-submit-button" type="submit" name="submit" value="Post" />
                </div>
            </form>
        </div>
	</div>
</div>

<?php require("includes/footer.php")  ?>