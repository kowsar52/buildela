<?php
// error_reporting(0);

require_once 'crud.php';
date_default_timezone_set('Europe/London');



$db = new mysqli("sdb-52.hosting.stackcp.net", "buildela", "Buildela2022", "u786279181_buildela-353030347289");
//$db = new Database();
 //$this->db = new Database();
 //       $this->db->connect();
	//$db = $this->db->connect();
// Get the job_id and user_id from the POST data


$job_id = $_POST['job_id'];
$user_id = $_POST['user_id'];

// Check if the user has visited the current job page
$query = "SELECT COUNT(*) FROM visited_jobs WHERE user_id = $user_id AND job_id = $job_id";
$result = $db->query($query);
if ($result->fetch_array()[0] == 0) {
    // Insert the job ID and user ID into the visited_jobs table
    $query = "INSERT INTO visited_jobs (user_id, job_id) VALUES ($user_id, $job_id)";
    $result = $db->query($query);
    echo "Data inserted successfully";
}else{
    echo "Data already exists";
}

?>