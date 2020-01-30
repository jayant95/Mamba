<?php
    function getVisitorCountry() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
            return $_SERVER['HTTP_CLIENT_IP']; 
        } 
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            return $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } 
        else { 
            return $_SERVER['REMOTE_ADDR']; 
        } 
    }


    function getCountryFromDB($memberID, $connection) {
        $country = "";
        $sql = "SELECT country FROM members where memberID = ?";

        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('i', $memberID);
            $stmt->execute();

            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
              $country = $row['country'];
            }
        }

        // $stmt->close();


        return $country;
    }

    function updateUserCountry($data, $connection) {
        $sql = "UPDATE members SET country = ? WHERE memberID = ?";

        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('si', $data['country'], $data['memberID']);
            $stmt->execute();
        }

        $stmt->close();
    }
?>