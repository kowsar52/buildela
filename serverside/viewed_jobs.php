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


// Get the user_id from the GET data
$user_id = $_GET['user_id'];

// Get the total number of jobs and the number of viewed jobs
$query = "SELECT COUNT(DISTINCT post_job.id) AS total, COUNT(DISTINCT visited_jobs.job_id) AS viewed
FROM post_job
LEFT JOIN visited_jobs ON post_job.id = visited_jobs.job_id AND visited_jobs.user_id = $user_id";
$result = $db->query($query);
$row = $result->fetch_assoc();

// Calculate the number of jobs not viewed
$jobs_not_viewed = $row['total'] - $row['viewed'];

// Return the result
echo $jobs_not_viewed;
?>