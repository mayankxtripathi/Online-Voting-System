<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "onlinevotingsystem"; 

$db = new mysqli($servername, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if(isset($_GET['id'])) {
    $candidate_id = mysqli_real_escape_string($db, $_GET['id']);
    
    // Fetch the candidate's photo path
    $result = mysqli_query($db, "SELECT candidate_photo FROM candidate_details WHERE id='$candidate_id'");
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $candidate_photo = $row['candidate_photo'];
        
        // Delete the photo from the server
        if(file_exists($candidate_photo)) {
            unlink($candidate_photo);
        }

        // Delete candidate from the database
        $query = "DELETE FROM candidate_details WHERE id='$candidate_id'";
        if(mysqli_query($db, $query)) {
            echo "<script>location.assign('../index.php?addCandidatePage=1&deleted=1');</script>";
        } else {
            echo "<script>location.assign('../index.php?addCandidatePage=1&error=1');</script>";
        }
    } else {
        echo "<script>location.assign('../index.php?addCandidatePage=1&error=1');</script>";
    }
} else {
    echo "<script>location.assign('../index.php?addCandidatePage=1&error=1');</script>";
}

$db->close();
?>
