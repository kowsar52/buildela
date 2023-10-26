<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');
include 'serverside/api/config.php';
include 'serverside/functions.php';
include 'serverside/api/functions.php';

$apiKey = $_SERVER['HTTP_API_KEY'] ?? '';

$base_url = 'https://buildela.com';

if (!Apifunctions::VerifyApiKey($apiKey)) {
    http_response_code(401);  // Unauthorized
    echo json_encode(['error' => 'Invalid API Key']);
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Use GET for requests that do not require POST data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($_GET['request']) {
        case 'getCountries':
            $country_name = isset($_GET['country_name']) ? $_GET['country_name'] : null;
            getCountries($country_name);
            break;
        case 'fetchJobsNew':
            $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
            $type = isset($_GET['type']) ? $_GET['type'] : null;
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            $distance = isset($_GET['distance']) ? $_GET['distance'] : 10;  // 10km
            fetchJobsNew($conn, $userId, $type, $page, $limit, $distance);
            break;
        case 'fetchJobs':
            $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
            $type = isset($_GET['type']) ? $_GET['type'] : null;
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            fetchJobs($conn, $userId, $type, $page, $limit);
            break;
        case 'jobsLiveUpdate':
            $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
            jobsLiveUpdate($conn, $userId);
            break;
        case 'getJobAndUserDetailsNew':
            $jobId = isset($_GET['job_id']) ? $_GET['job_id'] : null;
            $currentUserId = isset($_GET['current_user_id']) ? $_GET['current_user_id'] : null;
            getJobAndUserDetailsNew($conn, $jobId, $currentUserId);
            break;
        case 'getJobAndUserDetails':
            $jobId = isset($_GET['job_id']) ? $_GET['job_id'] : null;
            $currentUserId = isset($_GET['current_user_id']) ? $_GET['current_user_id'] : null;
            getJobAndUserDetails($conn, $jobId, $currentUserId);
            break;
        case 'getHomeownersBlogs':
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            getHomeownersBlogs($conn, $page);
            break;
        case 'getblogsPercat':
            $count = isset($_GET['count']) ? (int) $_GET['count'] : 5;
            $identity = $_GET['type'];
            blogsPercat($conn, $identity, $count);
            break;
        case 'getallblogsofcat':
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            $identity = isset($_GET['type']) ? $_GET['type'] : 'trade';
            $cats = $_GET['cats'];
            getallBlogsbyCat($conn, $cats, $identity, $page);
            break;
        case 'getUser':
            $userId = isset($_GET['id']) ? $_GET['id'] : null;
            getUserById($conn, $userId);
            break;
        case 'getFeedbacksByUserId':
            $userId = isset($_GET['id']) ? $_GET['id'] : null;
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 3;
            getFeedbacksByUserId($conn, $userId, $page, $limit);
            break;
        case 'getProfessionalsBlogs':
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            getProfessionalsBlogs($conn, $page);
            break;
        case 'getSingleBlog':
            $blogId = isset($_GET['id']) ? $_GET['id'] : null;
            getSingleBlog($conn, $blogId);
            break;
        case 'tradeCategories':
            tradesCategories();
            break;
        case 'homeownerCategories':
            homeownerCategories();
            break;
        case 'searchCategory':
            searchCategory($conn);
            break;
        case 'jobmainsearchCategory':
            searchCategory($conn);
            break;
        case 'getTradespersonRewards':
            getTradespersonRewards($conn);
            break;
        case 'getHomeownerRewards':
            getHomeownerRewards($conn);
            break;

        case 'fetchCategoriesWithoutOther':
            fetchCategoriesWithoutOther($conn);
            break;

        case 'fetchCategories':
            fetchCategories($conn);
            break;

        default:
            echo json_encode(array('message' => 'Invalid Request'));
            break;
    }
}

// Use POST for requests that require POST data
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (!$data) {
        // let's write code to get form-data
        $data = $_POST;
    }

    // Check if $data is not null and 'request' key exists in $data
    if ($data && isset($data['request'])) {
        $request = $data['request'];

        switch ($request) {
            case 'register':
                registerUser($conn, $data);
                break;
            case 'login':
                loginUser($conn, $data);
                break;
            case 'getJobsByUserId':
                $userId = isset($data['user_id']) ? $data['user_id'] : null;
                if ($userId) {
                    getJobsByUserId($conn, $userId);
                } else {
                    echo json_encode(array('message' => 'User ID is required.'));
                }
                break;
            case 'getAppliedUsersByJobId':
                $jobId = isset($data['job_id']) ? $data['job_id'] : null;
                if ($jobId) {
                    getAppliedUsersByJobId($conn, $jobId);
                } else {
                    echo json_encode(array('message' => 'Job ID is required.'));
                }
                break;
            case 'updateFcmToken':
                if (isset($data['user_id'])) {
                    updateFcmToken($conn, $data);
                } else {
                    echo json_encode(array('message' => 'user id are required.'));
                }
                break;
            case 'postJob':
                postJob($conn, $data);
                break;
            case 'postJobWithMedia':
                postJobWithMedia($conn, $data);
                break;
            case 'updateUser':
                print_r($data, true);  // Add this debug line
                updateUser($conn, $data);
                break;
            case 'searchSubCategory':
                $name = isset($data['main_type_name']) ? $data['main_type_name'] : null;
                searchSubCategory($conn, $name);
                break;
            case 'searchOptionsById':
                $selectedID = isset($data['selectedID']) ? $data['selectedID'] : null;
                searchOptionsById($conn, $selectedID);
                break;
            case 'getUsersChat':
                if (isset($data['user_id'])) {
                    getUsersChat($conn, $data['user_id']);
                } else {
                    echo json_encode(array('message' => 'User ID not provided.'));
                }
                break;
            case 'getChatList':
                if (isset($data['user_id'])) {
                    getChatList($conn, $data['user_id']);
                } else {
                    echo json_encode(array('message' => 'User ID not provided.'));
                }
                break;

            case 'getChatMessages':
                if (isset($data['user_id']) && isset($data['chat_partner_id']) && isset($data['job_id'])) {
                    getChatMessages($conn, $data['user_id'], $data['chat_partner_id'], $data['job_id']);
                } else {
                    echo json_encode(array('message' => 'User ID, Chat Partner ID, and Job ID are required.'));
                }
                break;
            case 'postChatMessage':
                if (isset($data['my_id']) && isset($data['touserid']) && isset($data['jobid']) && isset($data['message'])) {
                    postChatMessage($conn, $data['my_id'], $data['touserid'], $data['jobid'], $data['message']);
                } else {
                    echo json_encode(array('message' => 'All required fields (my_id, touserid, jobid, message) are not provided.'));
                }
                break;

            case 'getUsersByReferral':
                $referralCode = isset($data['referral_code']) ? $data['referral_code'] : null;
                if ($referralCode) {
                    getUsersByReferralCode($conn, $referralCode);
                } else {
                    echo json_encode(array('message' => 'Referral code is required.'));
                }
                break;

            case 'getWithdrawsById':
                $userId = isset($data['user_id']) ? $data['user_id'] : null;
                if ($userId) {
                    getWithdrawsById($conn, $userId);
                } else {
                    echo json_encode(array('message' => 'User ID is required.'));
                }
                break;
            case 'homeownerSignup':
                homeownerSignup($conn, $data);
                break;
            case 'completeJob':
                if (isset($data['user_id']) && isset($data['job_id'])) {
                    completeJob($conn, $data['user_id'], $data['job_id']);
                } else {
                    echo json_encode(array('message' => 'Both user_id and job_id are required.'));
                }
                break;

            case 'startJob':
                if (isset($data['user_id']) && isset($data['job_id'])) {
                    startJob($conn, $data['user_id'], $data['job_id']);
                } else {
                    echo json_encode(array('message' => 'Both user_id and job_id are required.'));
                }
                break;

            case 'applyJob':
                if (isset($data['user_id']) && isset($data['job_id']) && isset($data['job_location']) && isset($data['message'])) {
                    applyJob($conn, $data['job_id'], $data['job_location'], $data['message'], $data['user_id']);
                } else {
                    echo json_encode(array('message' => 'All required fields (user_id, job_id, job_location, message) are not provided.'));
                }
                break;

            case 'updateJobDescription':
                $jobId = isset($data['job_id']) ? $data['job_id'] : null;
                $newDescription = isset($data['new_description']) ? $data['new_description'] : null;
                if ($jobId && $newDescription) {
                    updateJobDescriptionById($conn, $jobId, $newDescription);
                } else {
                    echo json_encode(array('message' => 'Both Job ID and new description are required.'));
                }
                break;

            case 'deleteUser':
                $userId = isset($data['user_id']) ? $data['user_id'] : null;
                if ($userId) {
                    deleteUserById($conn, $userId);
                } else {
                    echo json_encode(array('message' => 'User ID is required.'));
                }
                break;

            case 'getStripeSubscriptionStatus':
                $userId = isset($data['user_id']) ? $data['user_id'] : null;
                if ($userId) {
                    getStripeSubscriptionStatusByUserId($conn, $userId);
                } else {
                    echo json_encode(array('message' => 'User ID is required.'));
                }
                break;

            case 'shortlist':
                if (isset($data['user_id']) && isset($data['job_id'])) {
                    shortlist($conn, $data['user_id'], $data['job_id']);
                } else {
                    echo json_encode(array('message' => 'Both user_id and job_id are required.'));
                }
                break;

            case 'employerStartJob':
                if (isset($data['user_id']) && isset($data['job_id'])) {
                    employerStartJob($conn, $data['user_id'], $data['job_id']);
                } else {
                    echo json_encode(array('message' => 'Both user_id and job_id are required.'));
                }
                break;

            case 'ratingUser':
                if (isset($data['from_user_id'], $data['user_id'], $data['job_id'], $data['job_title'], $data['stars'], $data['recommends'], $data['message'], $data['user_info'])) {
                    ratingUser($conn, $data['from_user_id'], $data['user_id'], $data['job_id'], $data['job_title'], $data['stars'], $data['recommends'], $data['message'], $data['user_info']);
                } else {
                    echo json_encode(array('message' => 'All required fields are not provided.'));
                }
                break;

            case 'checkUserId':
                $userId = isset($data['user_id']) ? $data['user_id'] : null;
                if ($userId !== null) {
                    $exists = userIdExists($conn, $userId);
                    echo json_encode(array('userIdExists' => $exists));
                } else {
                    echo json_encode(array('message' => 'User ID is required'));
                }
                break;

            default:
                echo json_encode(array('message' => 'Invalid Request'));
                break;
        }
    } else {
        echo json_encode(array('message' => 'Invalid Request'));
    }
}

function dd(...$args)
{
    foreach ($args as $x) {
        var_dump($x);
    }
    die (1);
}

function registerUser($conn)
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (username, password) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();

    echo json_encode(array('message' => 'User registered successfully!'));
}

function loginUser($conn, $data)
{
    $email = $data['email'];
    $password = md5($data['password']);

    $sql = 'SELECT * FROM users WHERE email = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'));
        return;
    }

    $bindResult = $stmt->bind_param('s', $email);

    if (!$bindResult) {
        echo json_encode(array('message' => 'Failed to bind parameter.'));
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'));
        return;
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password == $user['password']) {
        unset($user['password']);  // remove password from the response
        echo json_encode($user);
    } else {
        echo json_encode(array('message' => 'Invalid email or password'));
    }
}

function postJob($conn)
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $title = $data['title'];
    $description = $data['description'];

    $sql = 'INSERT INTO jobs (title, description) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $title, $description);
    $stmt->execute();

    echo json_encode(array('message' => 'Job posted successfully!'));
}

function getCountries()
{
    $func = new Functions();
    $userinfo = $func->getClientlocation($_SERVER['REMOTE_ADDR']);
    $usercurrencies = $func->countryCurrency($userinfo['country']);
    $buildelaCountries = $func->countries(true);

    echo json_encode([
        'userinfo' => $userinfo,
        'countries' => $buildelaCountries,
        'usercurrencies' => $usercurrencies
    ]);
}

function getJobsByStatus($conn, $userId, $status)
{
    $stmt = $conn->prepare('SELECT job_id FROM apply_job WHERE user_id = ? AND status = ?;');
    $stmt->bind_param('ii', $userId, $status);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $jobs = array();
            while ($row = $result->fetch_assoc()) {
                $jobs[] = $row['job_id'];
            }
            // Return total jobs along with the jobs.
            return [$jobs, $result->num_rows];
        } else {
            // return an empty array and zero total jobs instead of throwing an exception
            return [[], 0];
        }
    } else {
        echo 'SQL error: ' . $stmt->error;
        return [[], 0];
    }
}

function getUserDetails($conn, $userId)
{
    $stmt = $conn->prepare('SELECT distance, post_code FROM users WHERE id = ?;');
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }

    return null;
}

function getTotalJobs($conn, $userId, $status, $verifiedSkills)
{
    // Prepare the IN clause for verified skills
    $inQuery = implode(',', array_fill(0, count($verifiedSkills), '?'));

    // SQL query to fetch the total jobs
    $sql = "SELECT COUNT(*) as total_jobs 
    FROM post_job 
    WHERE post_job.status = ? AND post_job.main_type IN ({$inQuery})";

    $stmt = $conn->prepare($sql);
    $types = 'i' . str_repeat('i', count($verifiedSkills));
    $stmt->bind_param($types, $status, ...$verifiedSkills);

    $total_jobs = 0;
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_jobs = $row['total_jobs'];
    }

    return $total_jobs;
}

function fetchFilteredJobs($conn, $userId, $status, $verifiedSkills, $userData, $page)
{
    // Prepare the IN clause for verified skills
    $inQuery = implode(',', array_fill(0, count($verifiedSkills), '?'));

    // Fetch all jobs that match the status and main category
    $sql = "SELECT * 
    FROM post_job 
    LEFT JOIN main_category 
    ON post_job.main_type = main_category.id 
    LEFT JOIN sub_category 
    ON post_job.sub_type = sub_category.id 
    LEFT JOIN add_options 
    ON post_job.options = add_options.id
    WHERE post_job.status = ? AND post_job.main_type IN ({$inQuery}) 
    ORDER BY post_job.created_date DESC";

    $stmt = $conn->prepare($sql);
    $types = 'i' . str_repeat('i', count($verifiedSkills));
    $stmt->bind_param($types, $status, ...$verifiedSkills);

    $jobs = [];
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Filter jobs based on distance
        while ($row = $result->fetch_assoc()) {
            // Calculate the distance
            $jobPostCode = urlencode($row['post_code']);
            $userPostCode = urlencode($userData['post_code']);
            $distance = Apifunctions::DistanceCalculation($userPostCode, $jobPostCode);

            $distance = array(
                'meters' => $distance * 1609.34,
                'kilometers' => $distance * 1.60934,
                'yards' => $distance * 1760,
                'miles' => $distance
            );

            // Add the job if it's within the user's preferred distance
            if ($distance <= $userData['distance']) {
                $row['distance'] = $distance;
                $jobs[] = $row;
            }
        }
    }

    // Apply limit and offset to the jobs array
    $offset = $page * 15;
    $jobs = array_slice($jobs, $offset, 15);

    return $jobs;
}

function fetchJobsNew($conn, $userId, $type, $page, $limit, $distance)
{
    $userId = $conn->real_escape_string($userId);
    $offset = ($page - 1) * $limit;
    $distance = (int) $distance;
    $func = new Apifunctions();

    $userInfo = $func->UserInfo($userId);
    $user_post_code = $userInfo['post_code'];
    $categories_ids = $func->getUserCategoryIds($userId);

    // Get the user's latitude and longitude
    $user_lat_long = $func->getLatLong($user_post_code);

    if (!$user_lat_long) {
        echo json_encode(array('message' => 'Invalid Post Code'));
        return;
    }

    $user_latitude = $user_lat_long['latitude'];
    $user_longitude = $user_lat_long['longitude'];

    if (!empty($categories_ids)) {
        // Get jobs using type

        switch ($type) {
            case 'all':
                $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date,
                            main_category.category_name,  
                            3959 * acos (
                                cos ( radians($user_latitude) )
                                * cos( radians( latitude ) )
                                * cos( radians( longitude ) - radians($user_longitude) )
                                + sin ( radians($user_latitude) )
                                * sin( radians( latitude ) )
                            ) AS distance_in_miles
                        FROM post_job 
                        LEFT JOIN main_category ON post_job.main_type = main_category.id 
                        WHERE post_job.main_type IN ($categories_ids)
                        AND post_job.status = 1
                        HAVING distance_in_miles <= ?
                        ORDER BY post_job.created_date DESC";
                $offset_limit_sql = $sql . ' LIMIT ? OFFSET ?';
                $stmt = $conn->prepare($offset_limit_sql);
                $stmt->bind_param('iii', $distance, $limit, $offset);
                break;

            case 'new_leads':
                $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date,
                            main_category.category_name,  
                            3959 * acos (
                                cos ( radians($user_latitude) )
                                * cos( radians( latitude ) )
                                * cos( radians( longitude ) - radians($user_longitude) )
                                + sin ( radians($user_latitude) )
                                * sin( radians( latitude ) )
                            ) AS distance_in_miles
                        FROM post_job 
                        LEFT JOIN main_category ON post_job.main_type = main_category.id
                        WHERE NOT EXISTS (
                            SELECT 1
                            FROM apply_job
                            WHERE apply_job.job_id = post_job.id
                            AND apply_job.user_id = $userId
                        ) 
                        AND post_job.main_type IN ($categories_ids)
                        AND post_job.status = 1
                        HAVING distance_in_miles <= ?
                        ORDER BY post_job.created_date DESC";

                $offset_limit_sql = $sql . ' LIMIT ? OFFSET ?';
                $stmt = $conn->prepare($offset_limit_sql);
                $stmt->bind_param('iii', $distance, $limit, $offset);

                break;

            case 'interested':
                $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date, apply_job.status as apply_job_status , apply_job.employer_status ,apply_job.worker_status,apply_job.apply_date as apply_job_created_at , main_category.category_name, 
                3959 * acos (
                        cos ( radians($user_latitude) )
                        * cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians($user_longitude) )
                        + sin ( radians($user_latitude) )
                        * sin( radians( latitude ) )
                    ) AS distance_in_miles
                FROM post_job 
                LEFT JOIN main_category ON post_job.main_type = main_category.id 
                LEFT JOIN apply_job ON post_job.id = apply_job.job_id
                WHERE post_job.main_type IN ($categories_ids)
                AND post_job.status = 1
                AND apply_job.status = 0
                AND apply_job.user_id = '$userId'
                ORDER BY apply_job.apply_date DESC";
                $offset_limit_sql = $sql . ' LIMIT ? OFFSET ?';
                $stmt = $conn->prepare($offset_limit_sql);
                $stmt->bind_param('ii', $limit, $offset);
                break;

            case 'shortlisted':
                $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date, apply_job.status as apply_job_status , apply_job.employer_status ,apply_job.worker_status,apply_job.apply_date as apply_job_created_at , main_category.category_name, 
                3959 * acos (
                        cos ( radians($user_latitude) )
                        * cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians($user_longitude) )
                        + sin ( radians($user_latitude) )
                        * sin( radians( latitude ) )
                    ) AS distance_in_miles
                FROM post_job 
                LEFT JOIN main_category ON post_job.main_type = main_category.id 
                LEFT JOIN apply_job ON post_job.id = apply_job.job_id
                WHERE post_job.main_type IN ($categories_ids)
                AND post_job.status = 1
                AND apply_job.status = 1
                AND apply_job.employer_status = 1
                AND apply_job.user_id = '$userId'
                ORDER BY apply_job.apply_date DESC";
                $offset_limit_sql = $sql . ' LIMIT ? OFFSET ?';
                $stmt = $conn->prepare($offset_limit_sql);
                $stmt->bind_param('ii', $limit, $offset);

                break;

            case 'hired':
                $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date, apply_job.status as apply_job_status , apply_job.employer_status ,apply_job.worker_status,apply_job.apply_date as apply_job_created_at , main_category.category_name, 
                3959 * acos (
                        cos ( radians($user_latitude) )
                        * cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians($user_longitude) )
                        + sin ( radians($user_latitude) )
                        * sin( radians( latitude ) )
                    ) AS distance_in_miles
                FROM post_job 
                LEFT JOIN main_category ON post_job.main_type = main_category.id 
                LEFT JOIN apply_job ON post_job.id = apply_job.job_id
                WHERE post_job.main_type IN ($categories_ids)
                AND post_job.status = 1
                AND apply_job.employer_status = 0
                AND apply_job.user_id = '$userId'
                ORDER BY apply_job.apply_date DESC";
                $offset_limit_sql = $sql . ' LIMIT ? OFFSET ?';
                $stmt = $conn->prepare($offset_limit_sql);
                $stmt->bind_param('ii', $limit, $offset);
                break;

            default:
                $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date,
                    main_category.category_name,  
                    3959 * acos (
                        cos ( radians($user_latitude) )
                        * cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians($user_longitude) )
                        + sin ( radians($user_latitude) )
                        * sin( radians( latitude ) )
                    ) AS distance_in_miles
                FROM post_job 
                LEFT JOIN main_category ON post_job.main_type = main_category.id 
                WHERE post_job.main_type IN ($categories_ids)
                AND post_job.status = 1
                HAVING distance_in_miles <= ?
                ORDER BY distance_in_miles";
                $offset_limit_sql = $sql . ' LIMIT ? OFFSET ?';
                $stmt = $conn->prepare($offset_limit_sql);
                $stmt->bind_param('iii', $distance, $limit, $offset);
                break;
        }

        if (!$stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 1: ' . $stmt->error));
            return;
        }
        $result = $stmt->get_result();
        // $jobs = $result->fetch_all(MYSQLI_ASSOC);

        $total_stmt = $conn->prepare($sql);
        if ($type == 'all' || $type == 'new_leads') {
            $total_stmt->bind_param('i', $distance);
        }
        if (!$total_stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 2: ' . $total_stmt->error));
            return;
        }
        $total_result = $total_stmt->get_result();
        $total_jobs = $total_result->num_rows;
        $total_stmt->close();

        $jobs = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $filter_field = 'lead_ids';
                if ($type == 'interested') {
                    $filter_field = 'interested_ids';
                }
                if ($type == 'shortlisted') {
                    $filter_field = 'shortlisted_ids';
                }
                if ($type == 'hired') {
                    $filter_field = 'jobswon_ids';
                }
                $read_leads_counter_sql = "SELECT COUNT(*) as read_leads FROM read_leads_counter WHERE user_id = ? AND FIND_IN_SET( ? ,$filter_field)";
                $read_leads_counter_stmt = $conn->prepare($read_leads_counter_sql);
                $read_leads_counter_stmt->bind_param('ii', $userId, $row['id']);
                $read_leads_counter_stmt->execute();
                $read_leads_counter_result = $read_leads_counter_stmt->get_result();
                $row['read_lead'] = $read_leads_counter_result->fetch_assoc()['read_leads'] > 0 ? true : false;

                $jobs[] = $row;
            }
        }

        // Create a response array that includes the total number of jobs and the jobs data
        $response = array(
            'data' => $jobs,
            'total' => (int) $total_jobs,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil((int) $total_jobs / $limit)
        );

        echo json_encode($response);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Failed! No job available.'));
    }
}

// function fetchJobs($conn, $userId, $type, $page, $limit)
// {
//     $userId = $conn->real_escape_string($userId);
//     $offset = $page * $limit;
//     $func = new Apifunctions();

//     $userInfo = $func->UserInfo($userId);
//     $user_post_code = $userInfo['post_code'];
//     $categories_ids = $func->getUserCategoryIds($userId);

//     if (!empty($categories_ids)) {
//         // Get jobs using type
//         switch ($type) {
//             case 'all':
//                 $sql = "SELECT post_job.id AS job_id 
//                         FROM post_job 
//                         WHERE post_job.main_type IN ($categories_ids)";

//                 break;

//             case 'new_leads':
//                 $sql = "SELECT post_job.id AS job_id 
//                 FROM post_job 
//                 WHERE post_job.main_type IN ($categories_ids) 
//                 AND post_job.created_date >= NOW() - INTERVAL 3 HOUR
//                 AND post_job.created_date <= NOW()";

//                 break;

//             case 'interested':
//                 $sql = "SELECT job_id FROM apply_job 
//                         WHERE status='0' AND user_id='$userId'";

//                 break;

//             case 'shortlisted':
//                 $sql = "SELECT job_id FROM apply_job WHERE status='1' AND user_id='$userId'";
//                 break;

//             case 'hired':
//                 $sql = "SELECT job_id FROM apply_job 
//                 WHERE employer_status = 1 AND user_id='$userId'";
//                 break;

//             default:
//                 $sql = "SELECT job_id FROM apply_job WHERE user_id='$userId'";
//                 break;
//         }

//         if (!$stmt = $conn->prepare($sql)) {
//             echo json_encode(array('message' => 'SQL Prepare Error: ' . $conn->error));
//             return;
//         }

//         // $stmt->bind_param("i", $userId);

//         if (!$stmt->execute()) {
//             echo json_encode(array('message' => 'SQL Execution Error: ' . $stmt->error));
//             return;
//         }

//         $result = $stmt->get_result();
//         $jobIdsArray = $result->fetch_all(MYSQLI_ASSOC);

//         // Convert the array of job ids for the IN clause
//         $jobIds = implode(',', array_map(function ($entry) {
//             return $entry['job_id'];
//         }, $jobIdsArray));

//         // If no jobs found, return empty
//         if (empty($jobIds)) {
//             echo json_encode(array('total_jobs' => 0, 'jobs' => array()));
//             return;
//         }

//         $sql = "SELECT post_job.*, 
//             main_category.category_name, 
//             sub_category.category_name AS sub_category_name, 
//             add_options.option,
//             users.fname AS postby_fname, users.lname AS postby_lname, users.phone AS postby_phone, users.img_path as postby_img_path
//         FROM post_job 
//         LEFT JOIN main_category ON post_job.main_type = main_category.id 
//         LEFT JOIN sub_category ON post_job.sub_type = sub_category.id 
//         LEFT JOIN add_options ON post_job.options = add_options.id 
//         LEFT JOIN users ON post_job.user_id = users.id 
//         WHERE post_job.id IN ($jobIds)
//         AND post_job.status = '1' 
//         ORDER BY post_job.id DESC
//         LIMIT ? OFFSET ?";

//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param('ii', $limit, $offset);
//         if (!$stmt->execute()) {
//             echo json_encode(array('message' => 'SQL Execution Error: ' . $stmt->error));
//             return;
//         }
//         $result = $stmt->get_result();
//         // $jobs = $result->fetch_all(MYSQLI_ASSOC);

//         $jobs = array();
//         if ($result && $result->num_rows > 0) {
//             // Fetch each row and add it to the $jobs array
//             while ($row = $result->fetch_assoc()) {
//                 $item = [
//                     'id' => $row['id'],
//                     'title' => $row['title'],
//                     'post_code' => $row['post_code'],
//                     'country' => $row['country'],
//                     'location' => $row['location'],
//                     'looking_to' => $row['looking_to'],
//                     'how_learge' => $row['how_learge'],
//                     'job_discription' => $row['job_discription'],
//                     'status' => $row['status'],
//                     'email_status' => $row['email_status'],
//                     'created_date' => $row['created_date'],
//                     'category_name' => $row['category_name'],
//                     'sub_category_name' => $row['sub_category_name'],
//                     'option' => $row['option'],
//                 ];

//                 // Findout the job distance
//                 $job_post_code = $row['post_code'];
//                 $job_post_code = preg_replace('/\s+/', '', $job_post_code);
//                 $user_post_code = preg_replace('/\s+/', '', $user_post_code);

//                 $mile = $func->DistanceCalculation([$job_post_code, $user_post_code], 'mile');
//                 if ($mile) {
//                     $distance = array(
//                         'meters' => $mile * 1609.34,
//                         'kilometers' => $mile * 1.60934,
//                         'yards' => $mile * 1760,
//                         'miles' => $mile
//                     );
//                 } else {
//                     $distance = array(
//                         'meters' => 0,
//                         'kilometers' => 0,
//                         'yards' => 0,
//                         'miles' => 0
//                     );
//                 }

//                 $item['distance'] = $distance;

//                 $item['is_applied'] = false;
//                 // Postby info & Phone Number show hide
//                 $apply_job = $conn->query('SELECT * FROM apply_job WHERE job_id = ' . $row['id'] . " AND user_id = '$userId'")->fetch_assoc();
//                 if (empty($apply_job)) {
//                     $postby = [
//                         'id' => $row['user_id'],
//                         'username' => $row['postby_fname'],
//                         'phone' => substr($row['postby_phone'], 0, 3) . str_repeat('*', strlen($row['postby_phone']) - 3),
//                         'img_path' => $row['postby_img_path'],
//                     ];
//                 } else if ($apply_job['status'] == 0) {  // apply
//                     $postby = [
//                         'id' => $row['user_id'],
//                         'username' => $row['postby_fname'],
//                         'phone' => substr($row['postby_phone'], 0, 3) . str_repeat('*', strlen($row['postby_phone']) - 3),
//                         'img_path' => $row['postby_img_path'],
//                     ];
//                     $item['is_applied'] = true;
//                 } else if ($apply_job['status'] > 0) {
//                     $postby = [
//                         'id' => $row['user_id'],
//                         'username' => $row['postby_fname'],
//                         'phone' => $row['postby_phone'],
//                         'img_path' => $row['postby_img_path']
//                     ];
//                     $item['is_applied'] = true;
//                 }

//                 $item['postby'] = $postby;

//                 // check if the job created_date is less than 3 hours from now then add new_leads
//                 $item['new_lead'] = false;  // Initialize as false
//                 $created_date = $row['created_date'];
//                 $created_date = strtotime($created_date);
//                 $now = time();
//                 $diff = $now - $created_date;
//                 $hours = $diff / (60 * 60);
//                 if ($hours <= 3) {
//                     $item['new_lead'] = true;  // Set to true if the condition is met
//                 }

//                 // Job status
//                 $item['job_status'] = $row['status'] == '1' ? 'Active' : 'Inactive';

//                 // job gallery
//                 $job_gallery = array();
//                 $jobs_gallery_sql = 'SELECT * FROM jobs_gallery WHERE job_id = ?';
//                 $jobs_gallery_stmt = $conn->prepare($jobs_gallery_sql);
//                 $jobs_gallery_stmt->bind_param('i', $row['id']);
//                 $jobs_gallery_stmt->execute();
//                 $jobs_gallery_result = $jobs_gallery_stmt->get_result();
//                 if ($jobs_gallery_result && $jobs_gallery_result->num_rows > 0) {
//                     while ($jobs_gallery_row = $jobs_gallery_result->fetch_assoc()) {
//                         $job_gallery[] = $jobs_gallery_row;
//                     }
//                 }
//                 $item['job_gallery'] = $job_gallery;

//                 // Findout lead read or not
//                 // SELECT COUNT(*) FROM `read_leads_counter` WHERE user_id = 23 AND lead_ids IN (239);
//                 $read_leads_counter_sql = 'SELECT COUNT(*) as read_leads FROM read_leads_counter WHERE user_id = ? AND lead_ids IN (?)';
//                 $read_leads_counter_stmt = $conn->prepare($read_leads_counter_sql);
//                 $read_leads_counter_stmt->bind_param('ii', $userId, $row['id']);
//                 $read_leads_counter_stmt->execute();
//                 $read_leads_counter_result = $read_leads_counter_stmt->get_result();
//                 $item['read_lead'] = $read_leads_counter_result->fetch_assoc()['read_leads'] > 0 ? true : false;

//                 // Shortlisted & Interseted Count
//                 $jobId = $row['id'];
//                 $item['interested'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE job_id = '$jobId' AND status >= 0")->fetch_assoc()['count'];
//                 $item['shortlisted'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE job_id = '$jobId' AND status > 0")->fetch_assoc()['count'];

//                 $jobs[] = $item;
//             }
//         }

//         // Get the total jobs count
//         $total_jobs_sql = "SELECT COUNT(*) as total_count FROM post_job  WHERE post_job.id IN ($jobIds)  AND post_job.status = 1";
//         // $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE job_id = '$jobId' AND status >= 0")->fetch_assoc()['count']
//         $total_jobs_result = $conn->query($total_jobs_sql);
//         $total_jobs = $total_jobs_result->fetch_assoc()['total_count'];
//         $conn->close();
//         // Create a response array that includes the total number of jobs and the jobs data
//         $response = array(
//             'data' => $jobs,
//             'total' => (int) $total_jobs,
//             'page' => $page,
//             'limit' => $limit,
//             'total_pages' => ceil((int) $total_jobs / $limit)
//         );

//         echo json_encode($response);
//     } else {
//         http_response_code(404);
//         echo json_encode(array('message' => 'Failed! No job available.'));
//     }
// }

/////////jobsLiveUpdate////////////////
function jobsLiveUpdate($conn, $userId)
{
    $userId = $conn->real_escape_string($userId);
    $distance = 100;
    $func = new Apifunctions();

    $userInfo = $func->UserInfo($userId);
    $user_post_code = $userInfo['post_code'];
    $categories_ids = $func->getUserCategoryIds($userId);

    // Get the user's latitude and longitude
    $user_lat_long = $func->getLatLong($user_post_code);

    if (!$user_lat_long) {
        echo json_encode(array('message' => 'Invalid Post Code'));
        return;
    }

    $user_latitude = $user_lat_long['latitude'];
    $user_longitude = $user_lat_long['longitude'];

    if (!empty($categories_ids)) {
        // Get jobs using type
        $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date,
        main_category.category_name,  
                3959 * acos (
                    cos ( radians($user_latitude) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians($user_longitude) )
                    + sin ( radians($user_latitude) )
                    * sin( radians( latitude ) )
                ) AS distance_in_miles
            FROM post_job 
            LEFT JOIN main_category ON post_job.main_type = main_category.id 
            WHERE post_job.main_type IN ($categories_ids)
            AND post_job.status = 1
            HAVING distance_in_miles <= ?
            ORDER BY post_job.created_date DESC";

        $total_stmt = $conn->prepare($sql);
        $total_stmt->bind_param('i', $distance);
        if (!$total_stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 2: ' . $total_stmt->error));
            return;
        }
        $total_result = $total_stmt->get_result();
        $all = $total_result->num_rows;
        $total_stmt->close();

        // count new_leads
        // "SELECT COUNT(*) as read_leads FROM read_leads_counter WHERE user_id = ? AND FIND_IN_SET( ? ,lead_ids)";
        $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date,
                main_category.category_name,  
                3959 * acos (
                    cos ( radians($user_latitude) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians($user_longitude) )
                    + sin ( radians($user_latitude) )
                    * sin( radians( latitude ) )
                ) AS distance_in_miles
            FROM post_job 
            LEFT JOIN main_category ON post_job.main_type = main_category.id
            WHERE NOT EXISTS (
                SELECT 1
                FROM apply_job
                WHERE apply_job.job_id = post_job.id
                AND apply_job.user_id = $userId
            )
            AND NOT EXISTS (
                SELECT 1
                FROM read_leads_counter
                WHERE read_leads_counter.user_id = $userId
                AND FIND_IN_SET( post_job.id ,read_leads_counter.lead_ids)
            ) 
            AND post_job.main_type IN ($categories_ids)
            AND post_job.status = 1
            HAVING distance_in_miles <= ?
            ORDER BY post_job.created_date DESC";
        $total_stmt = $conn->prepare($sql);
        $total_stmt->bind_param('i', $distance);
        if (!$total_stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 2: ' . $total_stmt->error));
            return;
        }
        $total_result = $total_stmt->get_result();
        $new_leads = $total_result->num_rows;
        $total_stmt->close();

        // interested
        $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date, apply_job.status as apply_job_status , apply_job.employer_status ,apply_job.worker_status,apply_job.apply_date as apply_job_created_at , main_category.category_name, 
                3959 * acos (
                        cos ( radians($user_latitude) )
                        * cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians($user_longitude) )
                        + sin ( radians($user_latitude) )
                        * sin( radians( latitude ) )
                    ) AS distance_in_miles
                FROM post_job 
                LEFT JOIN main_category ON post_job.main_type = main_category.id 
                LEFT JOIN apply_job ON post_job.id = apply_job.job_id
                WHERE post_job.main_type IN ($categories_ids)
                AND NOT EXISTS (
                    SELECT 1
                    FROM read_leads_counter
                    WHERE read_leads_counter.user_id = $userId
                    AND FIND_IN_SET( post_job.id ,read_leads_counter.interested_ids)
                )
                AND post_job.status = 1
                AND apply_job.status = 0
                AND apply_job.user_id = '$userId'
                ORDER BY apply_job.apply_date DESC";
        $total_stmt = $conn->prepare($sql);
        if (!$total_stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 2: ' . $total_stmt->error));
            return;
        }
        $total_result = $total_stmt->get_result();
        $interested = $total_result->num_rows;
        $total_stmt->close();

        // shortlisted
        $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date, apply_job.status as apply_job_status , apply_job.employer_status ,apply_job.worker_status,apply_job.apply_date as apply_job_created_at , main_category.category_name, 
        3959 * acos (
                cos ( radians($user_latitude) )
                * cos( radians( latitude ) )
                * cos( radians( longitude ) - radians($user_longitude) )
                + sin ( radians($user_latitude) )
                * sin( radians( latitude ) )
            ) AS distance_in_miles
        FROM post_job 
        LEFT JOIN main_category ON post_job.main_type = main_category.id 
        LEFT JOIN apply_job ON post_job.id = apply_job.job_id
        WHERE post_job.main_type IN ($categories_ids)
        AND NOT EXISTS (
            SELECT 1
            FROM read_leads_counter
            WHERE read_leads_counter.user_id = $userId
            AND FIND_IN_SET( post_job.id ,read_leads_counter.shortlisted_ids)
        )
        AND post_job.status = 1
        AND apply_job.status = 1
        AND apply_job.employer_status = 1
        AND apply_job.user_id = '$userId'
        ORDER BY apply_job.apply_date DESC";
        $total_stmt = $conn->prepare($sql);
        if (!$total_stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 2: ' . $total_stmt->error));
            return;
        }
        $total_result = $total_stmt->get_result();
        $shortlisted = $total_result->num_rows;
        $total_stmt->close();

        // hired
        $sql = "SELECT post_job.id, post_job.title, post_job.post_code, post_job.country, post_job.location,  post_job.status, post_job.created_date, apply_job.status as apply_job_status , apply_job.employer_status ,apply_job.worker_status,apply_job.apply_date as apply_job_created_at , main_category.category_name, 
        3959 * acos (
                cos ( radians($user_latitude) )
                * cos( radians( latitude ) )
                * cos( radians( longitude ) - radians($user_longitude) )
                + sin ( radians($user_latitude) )
                * sin( radians( latitude ) )
            ) AS distance_in_miles
        FROM post_job 
        LEFT JOIN main_category ON post_job.main_type = main_category.id 
        LEFT JOIN apply_job ON post_job.id = apply_job.job_id
        WHERE post_job.main_type IN ($categories_ids)
        AND NOT EXISTS (
            SELECT 1
            FROM read_leads_counter
            WHERE read_leads_counter.user_id = $userId
            AND FIND_IN_SET( post_job.id ,read_leads_counter.jobswon_ids)
        )
        AND post_job.status = 1
        AND apply_job.employer_status = 0
        AND apply_job.user_id = '$userId'
        ORDER BY apply_job.apply_date DESC";
        $total_stmt = $conn->prepare($sql);
        if (!$total_stmt->execute()) {
            echo json_encode(array('message' => 'SQL Execution Error 2: ' . $total_stmt->error));
            return;
        }
        $total_result = $total_stmt->get_result();
        $hired = $total_result->num_rows;
        $total_stmt->close();

        // Create a response array that includes the total number of jobs and the jobs data
        http_response_code(200);
        echo json_encode([
            'total' => $all,  // 'all' => $all,
            'new_leads' => $new_leads,
            'interseted' => $interested,
            'shortlisted' => $shortlisted,
            'hired' => $hired
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        echo json_encode([
            'total' => 0,  // 'all' => $all,
            'new_leads' => 0,
            'interseted' => 0,
            'shortlisted' => 0,
            'hired' => 0
        ]);
    }
}

function getJobAndUserDetailsNew($conn, $jobId, $currentUserId = null)
{
    if (!$jobId) {
        echo json_encode(array('message' => 'Job ID is required.'));
        return;
    }

    $userId = $conn->real_escape_string($currentUserId);
    $jobId = $conn->real_escape_string($jobId);

    $func = new Apifunctions();
    $userInfo = $func->UserInfo($userId);
    $user_post_code = $userInfo['post_code'];
    $categories_ids = $func->getUserCategoryIds($userId);

    // Get the user's latitude and longitude
    $user_lat_long = $func->getLatLong($user_post_code);

    if (!$user_lat_long) {
        echo json_encode(array('message' => 'Invalid Post Code'));
        return;
    }

    $user_latitude = $user_lat_long['latitude'];
    $user_longitude = $user_lat_long['longitude'];

    $sql = "SELECT post_job.*, 
            main_category.category_name, 
            sub_category.category_name AS sub_category_name, 
            add_options.option,
            users.fname AS postby_fname, users.lname AS postby_lname, users.phone AS postby_phone, users.img_path as postby_img_path,
            3959 * acos (
                    cos ( radians($user_latitude) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians($user_longitude) )
                    + sin ( radians($user_latitude) )
                    * sin( radians( latitude ) )
                ) AS distance_in_miles
        FROM post_job 
        LEFT JOIN main_category ON post_job.main_type = main_category.id 
        LEFT JOIN sub_category ON post_job.sub_type = sub_category.id 
        LEFT JOIN add_options ON post_job.options = add_options.id 
        LEFT JOIN users ON post_job.user_id = users.id 
        WHERE post_job.id  = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    if (!$stmt->execute()) {
        echo json_encode(array('message' => 'SQL Execution Error: ' . $stmt->error));
        return;
    }
    // get signle job
    $row = $stmt->get_result()->fetch_assoc();
    // check if have any job
    if (!$row) {
        http_response_code(404);
        echo json_encode(array('message' => 'No job found.'));
        return;
    }

    $item = [
        'id' => $row['id'],
        'title' => $row['title'],
        'post_code' => $row['post_code'],
        'country' => $row['country'],
        'location' => $row['location'],
        'looking_to' => $row['looking_to'],
        'how_learge' => $row['how_learge'],
        'job_discription' => $row['job_discription'],
        'status' => $row['status'],
        'email_status' => $row['email_status'],
        'created_date' => $row['created_date'],
        'category_name' => $row['category_name'],
        'sub_category_name' => $row['sub_category_name'],
        'option' => $row['option'],
    ];

    $item['distance'] = [
        'meters' => $row['distance_in_miles'] * 1609.34,
        'kilometers' => $row['distance_in_miles'] * 1.60934,
        'yards' => $row['distance_in_miles'] * 1760,
        'miles' => $row['distance_in_miles']
    ];

    $item['is_applied'] = false;
    // Postby info & Phone Number show hide
    $apply_job = $conn->query('SELECT * FROM apply_job WHERE job_id = ' . $row['id'] . " AND user_id = '$userId'")->fetch_assoc();
    if (empty($apply_job)) {
        $postby = [
            'id' => $row['user_id'],
            'username' => $row['postby_fname'],
            'phone' => substr($row['postby_phone'], 0, 3) . str_repeat('*', strlen($row['postby_phone']) - 3),
            'img_path' => $row['postby_img_path'],
        ];
    } else if ($apply_job['status'] == 0) {  // apply
        $postby = [
            'id' => $row['user_id'],
            'username' => $row['postby_fname'],
            'phone' => substr($row['postby_phone'], 0, 3) . str_repeat('*', strlen($row['postby_phone']) - 3),
            'img_path' => $row['postby_img_path'],
        ];
        $item['is_applied'] = true;
    } else if ($apply_job['status'] > 0) {
        $postby = [
            'id' => $row['user_id'],
            'username' => $row['postby_fname'],
            'phone' => $row['postby_phone'],
            'img_path' => $row['postby_img_path']
        ];
        $item['is_applied'] = true;
    }

    $item['postby'] = $postby;

    // check if the job created_date is less than 3 hours from now then add new_leads
    $item['new_lead'] = false;  // Initialize as false
    $created_date = $row['created_date'];
    $created_date = strtotime($created_date);
    $now = time();
    $diff = $now - $created_date;
    $hours = $diff / (60 * 60);
    if ($hours <= 3) {
        $item['new_lead'] = true;  // Set to true if the condition is met
    }

    // Job status
    $item['job_status'] = $row['status'] == '1' ? 'Active' : 'Inactive';

    // job gallery
    $job_gallery = array();
    $jobs_gallery_sql = 'SELECT * FROM jobs_gallery WHERE job_id = ?';
    $jobs_gallery_stmt = $conn->prepare($jobs_gallery_sql);
    $jobs_gallery_stmt->bind_param('i', $row['id']);
    $jobs_gallery_stmt->execute();
    $jobs_gallery_result = $jobs_gallery_stmt->get_result();
    if ($jobs_gallery_result && $jobs_gallery_result->num_rows > 0) {
        while ($jobs_gallery_row = $jobs_gallery_result->fetch_assoc()) {
            $job_gallery[] = $jobs_gallery_row;
        }
    }
    $item['job_gallery'] = $job_gallery;

    // Findout lead read or not
    // SELECT COUNT(*) FROM `read_leads_counter` WHERE user_id = 23 AND lead_ids IN (239);
    $read_leads_counter_sql = 'SELECT COUNT(*) as read_leads FROM read_leads_counter WHERE user_id = ? AND lead_ids IN (?)';
    $read_leads_counter_stmt = $conn->prepare($read_leads_counter_sql);
    $read_leads_counter_stmt->bind_param('ii', $userId, $row['id']);
    $read_leads_counter_stmt->execute();
    $read_leads_counter_result = $read_leads_counter_stmt->get_result();
    $item['read_lead'] = $read_leads_counter_result->fetch_assoc()['read_leads'] > 0 ? true : false;

    // Shortlisted & Interseted Count
    $jobId = $row['id'];
    $item['interested'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE job_id = '$jobId' AND status >= 0")->fetch_assoc()['count'];
    $item['shortlisted'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE job_id = '$jobId' AND status > 0")->fetch_assoc()['count'];

    // Get users applied
    $sql = 'SELECT * FROM apply_job WHERE job_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    if ($stmt->execute()) {
        $usersApplied = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($usersApplied as &$user) {  // Note the use of & for reference
            $userId = $user['user_id'];

            // Fetch trading_name for the user
            $sqlUser = 'SELECT trading_name FROM users WHERE id = ?';
            $stmtUser = $conn->prepare($sqlUser);
            $stmtUser->bind_param('i', $userId);
            if ($stmtUser->execute()) {
                $userDetails = $stmtUser->get_result()->fetch_assoc();
                $user['trading_name'] = $userDetails['trading_name'];
            } else {
                echo 'SQL error (fetching trading_name): ' . $stmtUser->error;
                return;
            }

            // Fetch user ratings
            $sqlRating = 'SELECT * FROM rateuser WHERE user_id = ? ORDER BY id DESC';
            $stmtRating = $conn->prepare($sqlRating);
            $stmtRating->bind_param('i', $userId);
            if ($stmtRating->execute()) {
                $ratings = $stmtRating->get_result()->fetch_all(MYSQLI_ASSOC);
                $user['ratings'] = $ratings;
                $user['ratings_count'] = count($ratings);  // Add ratings count
            } else {
                echo 'SQL error (fetching ratings): ' . $stmtRating->error;
                return;
            }
        }
        $item['users_applied'] = $usersApplied;
    } else {
        echo 'SQL error: ' . $stmt->error;
        return;
    }

    if ($currentUserId !== null) {
        $item['current_user'] = array(
            'application_status' => getApplyUserStatus($conn, $currentUserId, $jobId)
        );
    }
    // mark as rad
    $func->setLeadRead($jobId, $userId);

    echo json_encode($item);
}

function getApplyUserStatus($conn, $user_id, $job_id)
{
    $sql = 'select * from apply_job where user_id = ? and job_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $job_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result : '0';
    }
}

function getJobAndUserDetails($conn, $jobId, $currentUserId = null)
{
    if (!$jobId) {
        echo json_encode(array('message' => 'Job ID is required.'));
        return;
    }

    $response = array();

    // Get job details
    $sql = 'SELECT * FROM post_job WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    if ($stmt->execute()) {
        $response['job'] = $stmt->get_result()->fetch_assoc();

        // Fetch job poster's details
        $posterId = $response['job']['user_id'];
        $sqlPoster = 'SELECT fname, phone FROM users WHERE id = ?';
        $stmtPoster = $conn->prepare($sqlPoster);
        $stmtPoster->bind_param('i', $posterId);
        if ($stmtPoster->execute()) {
            $response['job_poster_details'] = $stmtPoster->get_result()->fetch_assoc();
        } else {
            echo 'SQL error (fetching job poster details): ' . $stmtPoster->error;
            return;
        }
    } else {
        echo 'SQL error: ' . $stmt->error;
        return;
    }

    // Get job gallery
    $sql = 'SELECT * FROM jobs_gallery WHERE job_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    $job_gallery_video = array();
    $job_gallery_image = array();
    if ($stmt->execute()) {
        $jobGallery = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($jobGallery as $item) {
            if ($item['file_type'] === 'video') {
                $job_gallery_video[] = $item;
            } elseif ($item['file_type'] === 'image') {
                $job_gallery_image[] = $item;
            }
        }
        $response['job_gallery_video'] = $job_gallery_video;
        $response['job_gallery_image'] = $job_gallery_image;
    } else {
        echo 'SQL error: ' . $stmt->error;
        return;
    }

    // Get users applied
    $sql = 'SELECT * FROM apply_job WHERE job_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    if ($stmt->execute()) {
        $usersApplied = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($usersApplied as &$user) {  // Note the use of & for reference
            $userId = $user['user_id'];

            // Fetch trading_name for the user
            $sqlUser = 'SELECT trading_name FROM users WHERE id = ?';
            $stmtUser = $conn->prepare($sqlUser);
            $stmtUser->bind_param('i', $userId);
            if ($stmtUser->execute()) {
                $userDetails = $stmtUser->get_result()->fetch_assoc();
                $user['trading_name'] = $userDetails['trading_name'];
            } else {
                echo 'SQL error (fetching trading_name): ' . $stmtUser->error;
                return;
            }

            // Fetch user ratings
            $sqlRating = 'SELECT * FROM rateuser WHERE user_id = ? ORDER BY id DESC';
            $stmtRating = $conn->prepare($sqlRating);
            $stmtRating->bind_param('i', $userId);
            if ($stmtRating->execute()) {
                $ratings = $stmtRating->get_result()->fetch_all(MYSQLI_ASSOC);
                $user['ratings'] = $ratings;
                $user['ratings_count'] = count($ratings);  // Add ratings count
            } else {
                echo 'SQL error (fetching ratings): ' . $stmtRating->error;
                return;
            }
        }
        $response['users_applied'] = $usersApplied;
    } else {
        echo 'SQL error: ' . $stmt->error;
        return;
    }

    // Get interested count
    $sql = 'SELECT COUNT(*) as count FROM apply_job WHERE job_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    if ($stmt->execute()) {
        $response['interested_count'] = $stmt->get_result()->fetch_assoc()['count'];
    } else {
        echo 'SQL error: ' . $stmt->error;
        return;
    }

    // Get shortlisted count
    $sql = "SELECT COUNT(*) as count FROM apply_job WHERE job_id = ? and status != '0'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $jobId);
    if ($stmt->execute()) {
        $response['shortlisted_count'] = $stmt->get_result()->fetch_assoc()['count'];
    } else {
        echo 'SQL error: ' . $stmt->error;
        return;
    }

    if ($currentUserId !== null) {
        $response['current_user'] = array(
            'application_status' => getApplyUserStatus($conn, $currentUserId, $jobId)
        );
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

function getUserById($conn, $userId)
{
    // Ensure that the provided user ID is safe to use in a query
    $userId = $conn->real_escape_string($userId);

    $sql = 'SELECT * FROM users WHERE id = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'));
        return;
    }

    $bindResult = $stmt->bind_param('i', $userId);

    if (!$bindResult) {
        echo json_encode(array('message' => 'Failed to bind parameter.'));
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'));
        return;
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $user['hired_counter'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE user_id = '$userId' AND employer_status = 1")->fetch_assoc()['count'];
        if ($user['user_role'] == 'home_owner') {
            $user['total_job_posted'] = $conn->query("SELECT COUNT(*) as count FROM post_job WHERE user_id = '$userId'")->fetch_assoc()['count'];
        } else {
            $user['total_job_applied'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE user_id = '$userId'")->fetch_assoc()['count'];
            $user['total_job_completed'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE user_id = '$userId' AND employer_status = 1")->fetch_assoc()['count'];
        }

        // SQL query to findout User Verification Status for the given user ID
        $status_sql = "SELECT * FROM `electrical_verification` WHERE `user_id` = '$userId' AND `status` = '1'";
        $status_result = $conn->query($status_sql);

        // initial status
        $is_verified = false;
        // Check if there are any results
        if ($status_result && $status_result->num_rows > 0) {
            $is_verified = true;
        }

        // SQL query to findout gallery for the given user ID
        $gallery_sql = "SELECT * FROM `gallery` WHERE `user_id` = '$userId'";
        $gallery_result = $conn->query($gallery_sql);

        // Check if there are any results
        $gallery = null;
        if ($gallery_result && $gallery_result->num_rows > 0) {
            $gallery = $gallery_result->fetch_all(MYSQLI_ASSOC);
        }

        // SQL query to findout social link for the given user ID
        $social_link_sql = "SELECT * FROM `social_media_links` WHERE `user_id` = '$userId'";
        $social_link_result = $conn->query($social_link_sql);

        // Check if there are any results
        $social_links = null;
        if ($social_link_result && $social_link_result->num_rows > 0) {
            $social_links = $social_link_result->fetch_all(MYSQLI_ASSOC);
        }

        // Count total recommendation
        $query = "SELECT COUNT(*) as count FROM `rateuser` WHERE `user_id` = '$userId' AND `recommendation` = 'yes'";
        // Execute the query
        $result_ = $conn->query($query);
        $total_recommendation = 0;
        if ($result_) {
            // Fetch the count value
            $row = $result_->fetch_assoc();
            $total_recommendation = $row['count'];
        }

        // Calculate avarage ratings

        // Prepare SQL statement
        $rating_sql = "SELECT 
                AVG(ratings) as overall_rating,
                COUNT(ratings) as total_ratings,
                SUM(CASE WHEN ratings = 5 THEN 1 ELSE 0 END) as five_star,
                SUM(CASE WHEN ratings = 4 THEN 1 ELSE 0 END) as four_star,
                SUM(CASE WHEN ratings = 3 THEN 1 ELSE 0 END) as three_star,
                SUM(CASE WHEN ratings = 2 THEN 1 ELSE 0 END) as two_star,
                SUM(CASE WHEN ratings = 1 THEN 1 ELSE 0 END) as one_star
            FROM rateuser
            WHERE user_id = $userId
        ";

        $rating_result = $conn->query($rating_sql);
        $data = [];
        if ($rating_result && $rating_result->num_rows > 0) {
            $data = $rating_result->fetch_assoc();

            // Calculate the percentage for each star rating
            $totalRatings = $data['total_ratings'];
            $data['overall_rating'] = round($data['overall_rating'], 1);  // round to 1 decimal place
            if ($totalRatings > 0) {
                $data['5_star_percentage'] = round(($data['five_star'] / $totalRatings) * 100, 0);
                $data['4_star_percentage'] = round(($data['four_star'] / $totalRatings) * 100, 0);
                $data['3_star_percentage'] = round(($data['three_star'] / $totalRatings) * 100, 0);
                $data['2_star_percentage'] = round(($data['two_star'] / $totalRatings) * 100, 0);
                $data['1_star_percentage'] = round(($data['one_star'] / $totalRatings) * 100, 0);
            }
        }

        unset($user['password']);  // remove password from the response
        echo json_encode([
            'user_data' => $user,
            'is_verified' => $is_verified,
            'total_recommended' => $total_recommendation,
            'gallery' => $gallery,
            'social_links' => $social_links,
            'ratings' => $data
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'User not found'), JSON_PRETTY_PRINT);
    }
}

function getFeedbacksByUserId($conn, $userId, $page = 1, $limit = 3)
{
    // Calculate the offset based on the current page
    $offset = ($page - 1) * $limit;

    // Ensure that the provided user ID is safe to use in a query
    $userId = $conn->real_escape_string($userId);

    // Get the total number of records for the given user_id
    $countSql = "SELECT COUNT(*) as total_count FROM rateuser WHERE user_id = $userId";
    $countResult = $conn->query($countSql);
    $totalCount = $countResult->fetch_assoc()['total_count'];

    // Prepare SQL statement with OFFSET and LIMIT for pagination
    $sql = "
        SELECT rateuser.id, rateuser.from_user_id, rateuser.job_title, rateuser.message, rateuser.send_date, rateuser.ratings, users.fname ,users.lname, users.email, users.img_path, replyrateuser.message as reply_message, replyrateuser.send_date as reply_date
        FROM rateuser
        LEFT JOIN users ON users.id = rateuser.from_user_id
        LEFT JOIN replyrateuser ON replyrateuser.rateuser_id = rateuser.id
        WHERE rateuser.user_id = $userId
        LIMIT $limit OFFSET $offset
    ";

    $result = $conn->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode([
        'data' => $data,
        'total' => $totalCount,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => ceil($totalCount / $limit)
    ], JSON_PRETTY_PRINT);
}

function getBlogsCategory($conn)
{
    $sql = 'SELECT * FROM users WHERE id = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'));
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'));
        return;
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

function getHomeownersBlogs($conn, $page = 0)
{
    $limit = 15;  // number of records per page
    $offset = $page * $limit;  // calculate offset

    $sql = "SELECT * FROM blogs WHERE category = 'Homeowners' ORDER BY create_date DESC LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $limit, $offset);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $blogs = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($blogs, JSON_PRETTY_PRINT);
}

function getProfessionalsBlogs($conn, $page = 0)
{
    $limit = 15;  // number of records per page
    $offset = $page * $limit;  // calculate offset

    $sql = "SELECT * FROM blogs WHERE category = 'Professionals' ORDER BY create_date DESC LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $limit, $offset);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $blogs = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($blogs, JSON_PRETTY_PRINT);
}

function blogsPercat($conn, $identity = 'trade', $count = 5)
{
    // pulling categories
    if ($identity == 'trade')
        $sql = "SELECT * FROM blog_category WHERE cat_type='tradespeople_category'";
    elseif ($identity == 'home')
        $sql = "SELECT * FROM blog_category WHERE cat_type='home_owners_category'";

    $stmt = $conn->prepare($sql);

    // home_owners_category
    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $return = [];
    $result = $stmt->get_result();
    $cats = $result->fetch_all(MYSQLI_ASSOC);

    // pulling blogs
    if ($identity == 'trade')
        $bsql = "SELECT * FROM blogs WHERE category='Professionals' ORDER BY RAND()";
    elseif ($identity == 'home')
        $bsql = "SELECT * FROM blogs WHERE category='Homeowners' ORDER BY RAND()";
    $stmt = $conn->prepare($bsql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $return = [];
    $result = $stmt->get_result();
    $blogs = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($cats as $cat) {
        $categoryBlogs = [];
        $blogCount = 0;  // Initialize a count for the blogs in this category

        foreach ($blogs as $blog) {
            $blogcat = (int) preg_replace('/\s+/', '', $blog['blog_category']);
            if ($blogcat === $cat['id']) {
                $blogCount++;
                $categoryBlogs[] = $blog;
                if ($blogCount === $count)
                    break;
            }
        }
        if ($blogCount > 0) {
            $return[] = [
                'category_id' => $cat['id'],
                'category_name' => $cat['name'],
                'blogs_count' => $blogCount,
                'blogs' => $categoryBlogs
            ];
        }
    }

    echo json_encode($return, JSON_PRETTY_PRINT);
}

function getallBlogsbyCat($conn, $cats, $identity = 'trade', $page)
{
    $limit = 15;  // number of records per page
    $offset = $page * $limit;  // calculate offset

    if (is_array($cats)) {
        $inClause = 'IN (' . implode(',', $cats) . ')';
    } else {
        $inClause = '= ?';
    }

    if ($identity == 'trade')
        $sql = "SELECT * FROM blogs WHERE category = 'Professionals' AND blog_category $inClause ORDER BY create_date DESC LIMIT ? OFFSET ?";
    if ($identity == 'home')
        $sql = "SELECT * FROM blogs WHERE category = 'Homeowners' AND blog_category $inClause ORDER BY create_date DESC LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);

    // $stmt->bind_param("ii", $limit, $offset);

    if (is_array($cats)) {
        $stmt->bind_param('ii', $limit, $offset);
    } else {
        $stmt->bind_param('sii', $cats, $limit, $offset);
    }

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $blogs = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($blogs, JSON_PRETTY_PRINT);
}

function getSingleBlog($conn, $blogId)
{
    $sql = 'SELECT * FROM blogs WHERE id = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $bindResult = $stmt->bind_param('i', $blogId);

    if (!$bindResult) {
        echo json_encode(array('message' => 'Failed to bind parameter.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();

    if ($blog) {
        echo json_encode($blog);
    } else {
        echo json_encode(array('message' => 'No blog found with given ID'), JSON_PRETTY_PRINT);
    }
}

function tradesCategories()
{
    $tradescategory = [
        ['category' => 'Expert Tips & Techniques', 'slug' => 'Expert-Tips-&-Techniques'],
        ['category' => 'Project Showcases', 'slug' => 'Project-Showcases'],
        ['category' => 'Client Stories & Testimonials', 'slug' => 'Client-Stories-&-Testimonials'],
        ['category' => 'Industry News & Trends', 'slug' => 'Industry-News-&-Trends'],
        ['category' => 'Business Management', 'slug' => 'Business-Management'],
        ['category' => 'Safety & Regulations', 'slug' => 'Safety-&-Regulations'],
        ['category' => 'Material & Product Reviews', 'slug' => 'Material-&-Product-Reviews'],
        ['category' => 'Collaboration Opportunities', 'slug' => 'Collaboration-Opportunities'],
        ['category' => 'Skills Development', 'slug' => 'Skills-Development'],
        ['category' => 'Customer Education', 'slug' => 'Customer-Education']
    ];

    echo json_encode($tradescategory, JSON_PRETTY_PRINT);
}

function homeownerCategories()
{
    $homeOwnersCategories = [
        ['category' => 'Home Improvement', 'slug' => 'Home-Improvement'],
        ['category' => 'Maintenance & Repairs', 'slug' => 'Maintenance-&-Repairs'],
        ['category' => 'Interior Design', 'slug' => 'Interior-Design'],
        ['category' => 'Landscaping & Outdoor', 'slug' => 'Landscaping-&-Outdoor'],
        ['category' => 'Energy Efficiency', 'slug' => 'Energy-Efficiency'],
        ['category' => 'Appliance & Tech', 'slug' => 'Appliance-&-Tech'],
        ['category' => 'Safety & Security', 'slug' => 'Safety-&-Security'],
        ['category' => 'Real Estate Insights', 'slug' => 'Real-Estate-Insights'],
        ['category' => 'Financing & Budgeting', 'slug' => 'Financing-&-Budgeting'],
        ['category' => 'Community & Lifestyle', 'slug' => 'Community-&-Lifestyle']
    ];

    echo json_encode($homeOwnersCategories, JSON_PRETTY_PRINT);
}

function updateUser($conn, $data)
{
    error_log(print_r($data, true));  // Add this debug line
    $allowedFields = [
        'fname', 'lname', 'email', 'trading_name', 'search_address',
        'work_address', 'town', 'post_code', 'pub_insurance',
        'pub_insurance_date', 'pro_insurance', 'pro_insurance_date', 'note'
    ];

    $userId = $data['id'];
    unset($data['id']);
    unset($data['request']);

    $fields = [];
    $values = [];
    $types = '';

    // Prepare data for SQL statement
    foreach ($allowedFields as $field) {
        if (isset($data[$field]) && $data[$field] !== '') {
            $fields[] = $field . ' = ?';
            $values[] = $data[$field];
            $types .= 's';
        }
    }

    if (empty($fields)) {
        echo json_encode(array('message' => 'No valid fields provided to update', JSON_PRETTY_PRINT));
        return;
    }

    $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    // Add $userId to the end of the values array and the corresponding 'i' to the types
    $values[] = $userId;
    $types .= 'i';

    if (!$stmt->bind_param($types, ...$values)) {
        echo json_encode(array('message' => 'Failed to bind parameters.'), JSON_PRETTY_PRINT);
        return;
    }

    if (!$stmt->execute()) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    echo json_encode(array('message' => 'User updated successfully.'), JSON_PRETTY_PRINT);
}

function searchCategory($conn)
{
    global $base_url;

    $sql = "
    SELECT DISTINCT 
        sub.main_category as id, 
        main.category_name as main_category,
        main.id as main_id,
        main.image as image 
    FROM sub_category sub 
    JOIN main_category main 
    ON sub.main_category=main.id  
    WHERE main.category_name IN (
        'Electrician',
        'Plumber',
        'Carpenter',
        'Gardener',
        'Painter',
        'Builder',
        'Boiler',
        'Tiler',
        'Heating',
        'Locksmith',
        'Bathrooms',
        'Handyman'
    ) 
    ORDER BY main.category_name ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    // $result = $stmt->get_result();
    // $categories = $result->fetch_all(MYSQLI_ASSOC);
    // run a loop and update image path
    $categories = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row['image'] = $base_url . '/images/category-image/' . $row['image'];
        $categories[] = $row;
    }

    echo json_encode($categories);
}

function searchSubCategory($conn, $name)
{
    $name = trim($name);

    $name = $conn->real_escape_string($name);

    $sql = "
    SELECT 
        sub.main_category as main_id, 
        sub.id as id, 
        sub.category_name as sub_category, 
        main.category_name as main_category 
    FROM sub_category sub 
    JOIN main_category main 
    ON sub.main_category=main.id 
    WHERE sub.category_name NOT LIKE '%not sure' 
    AND (sub.category_name LIKE '%$name%' OR main.category_name LIKE '%$name%') 
    ORDER BY main.category_name ASC, sub.index ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $subCategories = [];
    $lastMainCategory = null;
    foreach ($rows as $row) {
        $subcategory = [
            'main_id' => $row['main_id'],
            'id' => $row['id'],
            'sub_category' => $row['sub_category'],
        ];

        if ($row['main_category'] !== $lastMainCategory) {
            // add main_category to first subcategory only
            $subcategory['main_category'] = $row['main_category'];
            $lastMainCategory = $row['main_category'];
        }

        $subCategories[] = $subcategory;
    }

    echo json_encode($subCategories, JSON_PRETTY_PRINT);
}

function searchOptionsById($conn, $selectedID)
{
    // Sanitize input
    $selectedID = $conn->real_escape_string($selectedID);

    // Prepare SQL statement
    $sql = 'SELECT * FROM add_options WHERE sub_category = ?';

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    // Bind parameters
    $stmt->bind_param('i', $selectedID);

    // Execute the statement
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    // Get the result
    $result = $stmt->get_result();
    $options = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($options)) {
        echo json_encode('0');
    } else {
        echo json_encode($options, JSON_PRETTY_PRINT);
    }
}

function postJobWithMedia($conn, $data)
{
    // verify post code
    $Functions = new Functions();
    $func = new Apifunctions();

    if ($Functions->PostVerify($data['post_code'])) {
        $address = $data['post_code'];
        $lat_long = $func->getLatLong($address);
        if ($lat_long['latitude'] == 0 || $lat_long['longitude'] == 0) {
            http_response_code(404);
            echo json_encode(array('message' => 'Invalid post code'), JSON_PRETTY_PRINT);
            return;
        }
        $latitude = $lat_long['latitude'];
        $longitude = $lat_long['longitude'];
        $location = $lat_long['location'];
     

    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Invalid post code'), JSON_PRETTY_PRINT);
        return;
    }

    $user_id = $conn->real_escape_string($data['user_id']);
    $title = $conn->real_escape_string($data['title']);
    $post_code = $conn->real_escape_string($data['post_code']);
    $main_type = $conn->real_escape_string($data['main_type']);
    $sub_type = $conn->real_escape_string($data['sub_type']);
    $options = $conn->real_escape_string($data['options']);
    $note = $conn->real_escape_string($data['job_discription']);  // I assume this is the job description
    $country = $conn->real_escape_string($data['country']);
    $current_date = date('Y-m-d H:i:s');
    $isEdit = false;
    if (isset($data['job_id']) && $data['job_id'] != ''){
        //check if the job is exists in db
        $job_id = $conn->real_escape_string($data['job_id']);
        $sql = "SELECT * FROM post_job WHERE id = '$job_id' AND user_id = '$user_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $isEdit = true;
        }
    }
    if ($isEdit) {  // edit
        // Insert job into database
        $sql = "UPDATE post_job 
        SET 
            user_id = '$user_id', 
            title = '$title', 
            main_type = '$main_type', 
            sub_type = '$sub_type', 
            options = '$options', 
            job_discription = '$note', 
            created_date = '$current_date', 
            country = '$country',
            location = '$location', 
            latitude = '$latitude', 
            longitude = '$longitude'
        WHERE  id = '$job_id';";

        if ($conn->query($sql)) {
            $insert_id = $job_id;
            //remove if have remove_image_ids
            if (isset($data['remove_image_ids']) && $data['remove_image_ids'] != '') {
                $remove_image_ids = $conn->real_escape_string($data['remove_image_ids']);
                //explode remove_image_ids to array
                $remove_image_ids = explode(',', $remove_image_ids);
                
                $remove_image_ids = array_diff($remove_image_ids, array(''));
                if (count($remove_image_ids) > 0) {
                   foreach ($remove_image_ids as $remove_image_id) {
                        $remove_image_id = (int) $remove_image_id;
                        //select image and unlink the image
                        $sql = "SELECT * FROM jobs_gallery WHERE id = '$remove_image_id'";
                        $result = $conn->query($sql);
                      
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $img_path = $row['img_path'];
                            if (file_exists($img_path)) {
                                unlink($img_path);
                            }
                        }

                        //delete image from db
                        $sql = "DELETE FROM jobs_gallery WHERE id = '$remove_image_id'";
                        $conn->query($sql);
                    }
                }
            }
            // Handle file uploads if files are provided
            if (!empty($_FILES)) {
                $uploadedFiles = $_FILES['files'];
                // dd($uploadedFiles);
                $totalFiles = count($uploadedFiles['name']);

                for ($key = 0; $key < $totalFiles; $key++) {
                    $file_name = $_FILES['files']['name'][$key];
                    $file_tmp = $_FILES['files']['tmp_name'][$key];
                    $file_type = $_FILES['files']['type'][$key];

                    if ($file_type == 'video/mp4' || $file_type == 'video/quicktime' || $file_type == 'MOV') {
                        // For video files, use FFmpeg to compress before moving
                        $type = 'video';
                        $timestamp = time();
                        $target = './jobsUploads/';
                        $file = $timestamp . '-' . $file_name;
                        $upload_to = $target . $file;
                        move_uploaded_file($file_tmp, $upload_to);
                    } else {
                        // For image files, compress before moving
                        $type = 'image';
                        $timestamp = time();
                        $target = './jobsUploads/';
                        $file = $timestamp . '-' . $file_name;
                        $upload_to = $target . $file;

                        move_uploaded_file($file_tmp, $upload_to);

                        // Compress the image with 50% quality (you can adjust the quality as needed)
                        compressImage($upload_to, $upload_to, 25);
                    }

                    // if (move_uploaded_file($file_tmp, $upload_to)) {
                    $sql = "INSERT INTO jobs_gallery (job_id, file_type, img_path) VALUES ('$insert_id', '$type', '$upload_to')";
                    $conn->query($sql);
                    // }
                }
            }
            echo json_encode(array('message' => 'Job updated successfully', 'job_id' => $insert_id), JSON_PRETTY_PRINT);
        }
    } else {  // insert or add new
        // Insert job into database
        $sql = "insert into post_job 
        (user_id, title, post_code, main_type, sub_type, options, job_discription, created_date, `country`,`location`, `latitude`, `longitude`) values 
        ('$user_id', '$title', '$post_code', '$main_type', '$sub_type', '$options', '$note', '$current_date', '$country', '$location','$latitude', '$longitude')";

        if ($conn->query($sql)) {
            $insert_id = $conn->insert_id;

            $sql = "INSERT INTO crone_jobs (job_id) VALUES ('$insert_id')";
            $conn->query($sql);

            // Handle file uploads if files are provided

            if (!empty($_FILES)) {
                $uploadedFiles = $_FILES['files'];
                // dd($uploadedFiles);
                $totalFiles = count($uploadedFiles['name']);

                for ($key = 0; $key < $totalFiles; $key++) {
                    $file_name = $_FILES['files']['name'][$key];
                    $file_tmp = $_FILES['files']['tmp_name'][$key];
                    $file_type = $_FILES['files']['type'][$key];

                    if ($file_type == 'video/mp4' || $file_type == 'video/quicktime' || $file_type == 'MOV') {
                        // For video files, use FFmpeg to compress before moving
                        $type = 'video';
                        $timestamp = time();
                        $target = './jobsUploads/';
                        $file = $timestamp . '-' . $file_name;
                        $upload_to = $target . $file;
                        move_uploaded_file($file_tmp, $upload_to);
                    } else {
                        // For image files, compress before moving
                        $type = 'image';
                        $timestamp = time();
                        $target = './jobsUploads/';
                        $file = $timestamp . '-' . $file_name;
                        $upload_to = $target . $file;

                        move_uploaded_file($file_tmp, $upload_to);

                        // Compress the image with 50% quality (you can adjust the quality as needed)
                        compressImage($upload_to, $upload_to, 25);
                    }

                    // if (move_uploaded_file($file_tmp, $upload_to)) {
                    $sql = "INSERT INTO jobs_gallery (job_id, file_type, img_path) VALUES ('$insert_id', '$type', '$upload_to')";
                    $conn->query($sql);
                    // }
                }
            }

            echo json_encode(array('message' => 'Job posted successfully', 'job_id' => $insert_id), JSON_PRETTY_PRINT);
        }
    }
}

function getJobsByUserId($conn, $userId)
{
    // Ensure that the provided user ID is safe to use in a query
    $userId = $conn->real_escape_string($userId);

    // SQL query to fetch all jobs for the given user ID
    $sql = "SELECT * FROM `post_job` WHERE `user_id` = '$userId' ORDER BY `created_date` DESC";

    $result = $conn->query($sql);

    // Check if there are any results
    if ($result && $result->num_rows > 0) {
        $jobs = array();

        // Fetch each row and add it to the $jobs array
        while ($row = $result->fetch_assoc()) {
            $interested = $conn->query('SELECT COUNT(*) as count FROM apply_job WHERE job_id = ' . $row['id'] . ' AND status = 0')->fetch_assoc()['count'];
            $shortlisted = $conn->query('SELECT COUNT(*) as count FROM apply_job WHERE job_id = ' . $row['id'] . ' AND status = 1')->fetch_assoc()['count'];
            $hired = $conn->query('SELECT COUNT(*) as count FROM apply_job WHERE job_id = ' . $row['id'] . ' AND employer_status = 1')->fetch_assoc()['count'];
            $processing = $conn->query('SELECT COUNT(*) as count FROM apply_job WHERE job_id = ' . $row['id'] . ' AND employer_status= 1 AND worker_status = 1')->fetch_assoc()['count'];
            $completd = $conn->query('SELECT COUNT(*) as count FROM apply_job WHERE job_id = ' . $row['id'] . ' AND status = 2')->fetch_assoc()['count'];
            $leave_feedback = $conn->query('SELECT COUNT(*) as count FROM apply_job WHERE job_id = ' . $row['id'] . ' AND rating = 1')->fetch_assoc()['count'];
            if ($interested > 0 && $shortlisted < 1) {
                $row['status_mean'] = $interested . ' interested';
            } else if ($shortlisted > 0) {
                $row['status_mean'] = $shortlisted . ' shortlisted';
            } else {
                $row['status_mean'] = 'Waiting for applicants';
            }

            if ($hired > 0) {
                $row['status_mean'] = 'Hired';
            }
            if ($processing > 0) {
                $row['status_mean'] = 'Job in processing';
            }

            if ($completd > 0) {
                $row['status_mean'] = 'Leave feedback';
            }
            if ($leave_feedback > 0) {
                $row['status_mean'] = 'Job complete';
            }

            $jobs[] = $row;
        }

        // Convert the $jobs array to JSON format and print
        echo json_encode($jobs, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message' => null), JSON_PRETTY_PRINT);
    }
}

function getAppliedUsersByJobId($conn, $jobId)
{
    // Ensure that the provided job ID is safe to use in a query
    $jobId = $conn->real_escape_string($jobId);

    // SQL query to fetch specific columns from `apply_job` and all from `users`
    $sql = "SELECT 
                apply_job.id as apply_id,
                apply_job.job_id,
                apply_job.job_location,
                apply_job.user_id as apply_user_id,
                apply_job.message,
                apply_job.status as application_status,
                apply_job.worker_status,
                apply_job.employer_status,
                apply_job.rating,
                apply_job.apply_date,
                users.* 
            FROM `apply_job` 
            JOIN `users` ON apply_job.user_id = users.id 
            WHERE apply_job.job_id = '$jobId'";

    $result = $conn->query($sql);

    // Check if there are any results
    if ($result && $result->num_rows > 0) {
        $appliedUsers = array();

        // Fetch each row and add it to the $appliedUsers array
        while ($row = $result->fetch_assoc()) {
            unset($row['password']);  // remove the password column

            // Fetch the average rating for the user
            $userId = $conn->real_escape_string($row['id']);  // using user ID from `users` table
            $ratingSql = "SELECT AVG(ratings) as avg_rating FROM rateuser WHERE user_id=$userId";
            $ratingResult = $conn->query($ratingSql);

            if ($ratingResult && $ratingRow = $ratingResult->fetch_assoc()) {
                $row['average_rating'] = $ratingRow['avg_rating'] !== null ? round($ratingRow['avg_rating'], 2) : 0;
            } else {
                $row['average_rating'] = 0;
            }
            $row['total_reviews'] = $conn->query("SELECT COUNT(*) as count FROM rateuser WHERE user_id = '$userId'")->fetch_assoc()['count'];
            $row['hired_counter'] = $conn->query("SELECT COUNT(*) as count FROM apply_job WHERE user_id = '$userId' AND employer_status = 1")->fetch_assoc()['count'];
            $appliedUsers[] = $row;
        }

        // Convert the $appliedUsers array to JSON format and print
        echo json_encode($appliedUsers, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('jobs' => [0]), JSON_PRETTY_PRINT);
    }
}

function timeAgo($timestamp)
{
    $datetime1 = new DateTime($timestamp);
    $datetime2 = new DateTime();
    $interval = $datetime1->diff($datetime2);
    $output = '';

    if ($interval->y) {
        $output .= $interval->y > 1 ? $interval->format('%y years ago') : '1 year ago';
    } elseif ($interval->m) {
        $output .= $interval->m > 1 ? $interval->format('%m months ago') : ',';
    } elseif ($interval->d) {
        $output .= $interval->d > 1 ? $interval->format('%d days ago') : '1 day ago';
    } elseif ($interval->h) {
        $output .= $interval->h > 1 ? $interval->format('%h hours ago') : '1 hour ago';
    } elseif ($interval->i) {
        $output .= $interval->i > 1 ? $interval->format('%i minutes ago') : '1 minute ago';
    } else {
        $output .= $interval->s > 1 ? $interval->format('%s seconds ago') : '1 second ago';
    }

    return $output;
}

function getChatList($conn, $user_id)
{
    // First, we get chat partners based on their distinct occurrences in the user_chat table.
    $query = 'SELECT DISTINCT 
                  CASE 
                      WHEN sender_id = ? THEN receiver_id 
                      ELSE sender_id 
                  END as chat_partner_id, 
                  job_id 
              FROM user_chat 
              WHERE sender_id = ? OR receiver_id = ?';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iii', $user_id, $user_id, $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $chat_partners = $result->fetch_all(MYSQLI_ASSOC);

    $extendedChats = [];

    // Now we'll iterate through each chat partner and gather their details, and the last message in their chat.
    foreach ($chat_partners as $partner) {
        $partner_id = $partner['chat_partner_id'];

        // Fetching chat partner details.
        $userQuery = 'SELECT id, trading_name, email, fname, lname, company_name, online_status, last_seen, is_typing, typing_for, img_path FROM users WHERE id = ?';
        $userStmt = $conn->prepare($userQuery);
        if (!$userStmt) {
            die ('Failed preparing user query: ' . $conn->error);
        }

        $userStmt->bind_param('i', $partner_id);
        $userStmt->execute();

        $userResult = $userStmt->get_result();
        $userData = $userResult->fetch_assoc();
        if (!$userData) {
            continue;  // If no user data is found, continue to the next iteration.
        }

        // Fetching the latest message for the chat considering the job_id as well.
        $messageQuery = 'SELECT message, create_date FROM chat_messages WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) AND job_id = ? ORDER BY create_date DESC LIMIT 1';
        $messageStmt = $conn->prepare($messageQuery);
        if (!$messageStmt) {
            die ('Failed preparing message query: ' . $conn->error);
        }

        $messageStmt->bind_param('iiiii', $user_id, $partner_id, $partner_id, $user_id, $partner['job_id']);
        $messageStmt->execute();

        $messageResult = $messageStmt->get_result();
        $lastMessage = $messageResult->fetch_assoc();
        if (!$lastMessage) {
            $lastMessage = ['message' => '', 'create_date' => ''];  // Default values if no message is found.
        }

        // Combining user data and the latest message.
        $chatInfo = array_merge(
            $userData,
            [
                'chat_partner_id' => $partner['chat_partner_id'],
                'job_id' => $partner['job_id'],
                'last_message' => $lastMessage['message'],
                'last_message_date' => $lastMessage['create_date']
            ]
        );
        $extendedChats[] = $chatInfo;
    }

    // Sending the combined result as JSON.
    echo json_encode($extendedChats, JSON_PRETTY_PRINT);
}

function getChatMessages($conn, $user_id, $chat_partner_id, $job_id)
{
    $query = 'SELECT 
                  sender_id, 
                  receiver_id, 
                  message, 
                  image_paths, 
                  create_date 
              FROM chat_messages 
              WHERE 
                  ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
                  AND job_id = ? 
              ORDER BY create_date ASC';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiiii', $user_id, $chat_partner_id, $chat_partner_id, $user_id, $job_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);

    // Sending the result as JSON
    echo json_encode($messages, JSON_PRETTY_PRINT);
}

function postChatMessage($conn, $my_id, $touserid, $jobid, $message)
{
    // Clean the inputs
    $touserid = htmlspecialchars(stripslashes($touserid));
    $touserid = $conn->real_escape_string($touserid);

    $jobid = htmlspecialchars(stripslashes($jobid));
    $jobid = $conn->real_escape_string($jobid);

    $message = htmlspecialchars(stripslashes($message));
    $message = $conn->real_escape_string($message);

    $create_date = date('Y-m-d H:i:s');

    // Insert the chat message
    $sql = "INSERT INTO chat_messages (job_id, sender_id, receiver_id, message, create_date) 
            VALUES ('$jobid', '$my_id', '$touserid', '$message', '$create_date')";

    if ($conn->query($sql)) {
        // Update last activity in user_chat
        $sql = "UPDATE user_chat SET last_activity='$create_date' 
                WHERE (sender_id='$my_id' AND receiver_id= '$touserid') OR 
                      (sender_id='$touserid' AND receiver_id= '$my_id')";
        $conn->query($sql);

        // Check for delete status
        $sql = "SELECT * FROM user_chat WHERE (sender_id='$my_id' OR receiver_id = '$my_id') 
                AND (sender_id='$touserid' OR receiver_id = '$touserid') AND (job_id='$jobid')";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $deleteStatus = $result->fetch_assoc();
            if (($deleteStatus['delete1'] == $touserid) || ($deleteStatus['delete2'] == $touserid)) {
                $sql = "UPDATE user_chat SET delete1=0, delete2=0 
                        WHERE (sender_id='$touserid' OR receiver_id = '$touserid') AND (job_id='$jobid')";
                $conn->query($sql);
            }
        }

        echo json_encode(array('status' => 'success', 'message' => 'Message posted successfully!'), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to post the message.'), JSON_PRETTY_PRINT);
    }
}

function getWithdrawsById($conn, $id)
{
    // Clean the user ID input
    $id = htmlspecialchars(stripslashes($id));
    $id = $conn->real_escape_string($id);

    // SQL query to fetch the withdrawals
    $sql = "SELECT * FROM withdraw WHERE user_id = '$id'";

    $result = $conn->query($sql);

    // Check if the query returns any results
    if ($result && $result->num_rows > 0) {
        $withdraws = array();

        // Fetch all rows and add to the withdraws array
        while ($row = $result->fetch_assoc()) {
            $withdraws[] = $row;
        }

        // Return the withdrawals as a JSON response
        echo json_encode(array('status' => 'success', 'withdraws' => $withdraws), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No withdrawals found for this user ID.'), JSON_PRETTY_PRINT);
    }
}

function getUsersByReferralCode($conn, $code)
{
    // Clean the referral code input
    $code = htmlspecialchars(stripslashes($code));
    $code = $conn->real_escape_string($code);

    // SQL query to fetch the users
    $sql = "SELECT id, email,fname,lname,subscription_status  FROM users WHERE from_referral_code='$code'";

    $result = $conn->query($sql);

    // Check if the query returns any results
    if ($result && $result->num_rows > 0) {
        $users = array();

        // Fetch all rows and add to the users array
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        // Return the users as a JSON response
        echo json_encode(array('status' => 'success', 'users' => $users), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No users found for this referral code.'), JSON_PRETTY_PRINT);
    }
}

function homeownerSignup($conn, $data)
{
    $response = array();

    $fname = htmlspecialchars(stripslashes($data['fname']));
    $lname = htmlspecialchars(stripslashes($data['lname']));
    $email = htmlspecialchars(stripslashes($data['email']));
    $pass1 = htmlspecialchars(stripslashes($data['pass1']));
    $haspass = md5($pass1);
    $phone = htmlspecialchars(stripslashes($data['phone']));
    $address = htmlspecialchars(stripslashes($data['address']));
    $address1 = htmlspecialchars(stripslashes($data['address1']));
    $fullAddress = $address . '__' . $address1;
    $post_code = htmlspecialchars(stripslashes($data['post_code']));

    if (CheckEmailExists($conn, $email)) {
        $response['status'] = 'error';
        $response['message'] = 'Email already exists!';
    } else {
        $sql = "INSERT INTO users (user_role, fname, lname, email, phone, password, work_address, post_code) 
                VALUES ('home_owner', '$fname', '$lname', '$email', '$phone', '$haspass', '$fullAddress', '$post_code')";

        if ($conn->query($sql)) {
            $userid = $conn->insert_id;

            $sql = "SELECT * FROM users WHERE id='$userid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();

                unset($user_data['password']);  // Exclude password from the response

                $response['status'] = 'success';
                $response['message'] = 'Registration successful!';
                $response['data'] = $user_data;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Registration successful but failed fetching user.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to register the user.';
        }
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

function CheckEmailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

function applyJob($conn, $job_id, $location, $message, $user_id)
{
    $response = array();

    // Sanitize input variables
    $job_id = $conn->real_escape_string(htmlspecialchars(stripslashes($job_id)));
    $location = $conn->real_escape_string(htmlspecialchars(stripslashes($location)));
    $message = $conn->real_escape_string(htmlspecialchars(stripslashes($message)));
    $user_id = $conn->real_escape_string(htmlspecialchars(stripslashes($user_id)));

    // check if already hired this job
    $sql_hired_check = "SELECT * FROM apply_job WHERE job_id='$job_id' AND employer_status=1 AND worker_status = 1";
    $result_hired_check = $conn->query($sql_hired_check);
    if ($result_hired_check && $result_hired_check->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'Someone already hired this job.';
        echo json_encode($response, JSON_PRETTY_PRINT);
        return;
    }

    // Check if the user has already applied for the job
    $sql = "SELECT * FROM apply_job WHERE user_id='$user_id' AND job_id='$job_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'You have already applied for this job.';
    } else {
        // Insert the application details into the database
        $current_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO apply_job (job_id, job_location, user_id, message,apply_date) VALUES ('$job_id', '$location', '$user_id', '$message','$current_date')";
        if ($conn->query($sql)) {
            $response['status'] = 'success';
            $response['message'] = 'You have successfully applied for the job!';

            ######## NOTIFICATION START ########
            // send notification to tradesperson [username] applied for your job
            $sql = "SELECT users.id,users.fname, users.web_fcm,users.mobile_fcm,post_job.id FROM users
            JOIN post_job ON post_job.user_id = users.id
            WHERE post_job.id = '$job_id' LIMIT 1";
            $result = $conn->query($sql);

            $notify_user_tokens = [];
            $username = '';
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $row['fname'];
                //push web_fcm and mobile_fcm to array
                if ($row['web_fcm'] != '') {
                    $notify_user_tokens[] = $row['web_fcm'];
                }
                if ($row['mobile_fcm'] != '') {
                    $notify_user_tokens[] = $row['mobile_fcm'];
                }
            }
            }
           
            $title = $username. ' applied for your job';
            $body =  $username. ' applied for your job';

            $notification = [
                'title' => $title,
                'body' => $body
            ];
            $Functions = new Functions();
            $Functions->sendNotification($notify_user_tokens, $notification);
            ######## NOTIFICATION END ########


        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to apply for the job. error: ' . $conn->error;
        }
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

function completeJob($conn, $user_id, $job_id)
{
    $response = array();

    // Sanitize the user_id and job_id
    $user_id = $conn->real_escape_string(htmlspecialchars(stripslashes($user_id)));
    $job_id = $conn->real_escape_string(htmlspecialchars(stripslashes($job_id)));

    // Prepare the SQL statement
    $sql = "UPDATE apply_job SET status=2 WHERE user_id='$user_id' AND job_id='$job_id'";

    // Execute the SQL query
    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Job marked as completed successfully!';

            ######## NOTIFICATION START ########
            // send notification to tradesperson [username] applied for your job
            $sql = "SELECT users.id,users.fname, users.web_fcm,users.mobile_fcm FROM users JOIN post_job ON post_job.user_id = users.id WHERE post_job.id = '$job_id' LIMIT 1";
            $result = $conn->query($sql);

            $notify_user_tokens = [];
            $username = '';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $username = $row['fname'];
                    //push web_fcm and mobile_fcm to array
                    if ($row['web_fcm'] != '') {
                        $notify_user_tokens[] = $row['web_fcm'];
                    }
                    if ($row['mobile_fcm'] != '') {
                        $notify_user_tokens[] = $row['mobile_fcm'];
                    }
                }
            }
            
            // $category_name = $conn->query('SELECT category_name FROM main_category WHERE id = ' . $main_type)->fetch_assoc()['category_name'];
            $from_username = $conn->query("SELECT users.fname FROM users WHERE users.id = '$user_id'")->fetch_assoc()['fname'];
            $title = $from_username. 'completed your job.';
            $body =  $from_username. 'completed your job.';

            $notification = [
                'title' => $title,
                'body' => $body
            ];
            $Functions = new Functions();
            $Functions->sendNotification($notify_user_tokens, $notification);
            ######## NOTIFICATION END ########

        } else {
            $response['status'] = 'error';
            $response['message'] = 'No job found with the specified user ID and job ID, or the job is already completed.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to complete the job. error: ' . $conn->error;
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

function startJob($conn, $user_id, $job_id)
{
    $response = array();

    // Sanitize the user_id and job_id
    $user_id = $conn->real_escape_string(htmlspecialchars(stripslashes($user_id)));
    $job_id = $conn->real_escape_string(htmlspecialchars(stripslashes($job_id)));

    // Prepare the SQL statement
    $sql = "UPDATE apply_job SET employer_status=1 WHERE user_id='$user_id' AND job_id='$job_id'";

    // Execute the SQL query
    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Job started successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No job found with the specified user ID and job ID, or the job is already started.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to start the job. error: ' . $conn->error;
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

function deleteUserById($conn, $userId)
{
    if (!$userId) {
        echo json_encode(array('message' => 'User ID is required.'), JSON_PRETTY_PRINT);
        return;
    }

    // Prepare the DELETE statement
    $sql = 'DELETE FROM users WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(array('message' => 'User successfully deleted.'), JSON_PRETTY_PRINT);
        } else {
            echo json_encode(array('message' => 'No user found with the specified ID.'), JSON_PRETTY_PRINT);
        }
    } else {
        echo 'SQL error: ' . $stmt->error;
    }
}

function updateJobDescriptionById($conn, $jobId, $newDescription)
{
    if (!$jobId || !$newDescription) {
        echo json_encode(array('message' => 'Both Job ID and new description are required.'), JSON_PRETTY_PRINT);
        return;
    }

    // Prepare the UPDATE statement
    $sql = 'UPDATE post_job SET job_discription = ? WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $newDescription, $jobId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(array('message' => 'Job description successfully updated.'));
        } else {
            echo json_encode(array('message' => 'No job found with the specified ID or the description was not changed.'));
        }
    } else {
        echo 'SQL error: ' . $stmt->error;
    }
}

function getStripeSubscriptionStatusByUserId($conn, $userId)
{
    // Ensure the provided user ID is safe to use in a query
    $userId = $conn->real_escape_string($userId);

    // Fetch the settings from the database
    $sqlSettings = 'SELECT * FROM settings';
    $resultSettings = $conn->query($sqlSettings);

    $settings = array();
    if ($resultSettings && $resultSettings->num_rows > 0) {
        while ($row = $resultSettings->fetch_assoc()) {
            $settings[] = $row;
        }
    } else {
        echo json_encode(array('message' => 'Failed to retrieve settings.'), JSON_PRETTY_PRINT);
        return;  // Terminate the function if settings couldn't be retrieved
    }

    // Fetch the Stripe private key from settings
    $secret_key = $settings[0]['stripe_private_key'];

    // SQL query to fetch the Stripe ID for the given user ID
    $sqlStripeId = "SELECT stripe_subscription_id FROM users WHERE id = '$userId'";
    $resultStripeId = $conn->query($sqlStripeId);

    if ($resultStripeId && $resultStripeId->num_rows > 0) {
        $rowStripe = $resultStripeId->fetch_assoc();
        $stripeId = $rowStripe['stripe_subscription_id'];

        include './vendor/stripe/stripe-php/init.php';
        \Stripe\Stripe::setApiKey($secret_key);

        try {
            // Fetch the subscription object from Stripe
            $subscription = \Stripe\Subscription::retrieve($stripeId);

            // Get the subscription status and end date
            $sub_status = $subscription->status;
            $end_date = $subscription->current_period_end;

            // Respond with the retrieved settings, Stripe ID, subscription status, and end date
            echo json_encode(array(
                'settings' => $settings,
                'stripe_subscription_id' => $stripeId,
                'subscription_status' => $sub_status,
                'subscription_end_date' => $end_date
            ), JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo json_encode(array(
                'settings' => $settings,
                'error' => 'Error fetching subscription: ' . $e->getMessage()
            ), JSON_PRETTY_PRINT);
        }
    } else {
        echo json_encode(array(
            'message' => 'User not found or failed to retrieve Stripe ID.',
            'settings' => $settings
        ), JSON_PRETTY_PRINT);
    }
}

function getTradespersonRewards($conn)
{
    $sql = 'SELECT * FROM `tradesperson_reward` ORDER BY `reward_date` ASC';
    $result = $conn->query($sql);

    $rewards = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rewards[] = $row;
        }
        echo json_encode(array('tradesperson_rewards' => $rewards), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message' => 'No tradesperson rewards found.'), JSON_PRETTY_PRINT);
    }
}

function getHomeownerRewards($conn)
{
    $sql = 'SELECT * FROM `homeowner_reward` ORDER BY `reward_date` ASC';
    $result = $conn->query($sql);

    $rewards = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rewards[] = $row;
        }
        echo json_encode(array('homeowner_rewards' => $rewards), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message' => 'No homeowner rewards found.'), JSON_PRETTY_PRINT);
    }
}

function shortlist($conn, $userId, $jobId)
{
    // Ensure the provided user ID and job ID are safe to use in a query
    $userId = $conn->real_escape_string($userId);
    $jobId = $conn->real_escape_string($jobId);

    // SQL query to update the status in apply_job table
    $sql = "UPDATE apply_job SET status=1 WHERE user_id='$userId' AND job_id='$jobId'";

    if ($conn->query($sql) === TRUE) {

        ######## NOTIFICATION START ########
        // send notification to tradesperson [username] applied for your job
        $sql = "SELECT users.id,users.fname, users.web_fcm,users.mobile_fcm FROM users
        WHERE users.id = '$userId' LIMIT 1";
        $result = $conn->query($sql);

        $notify_user_tokens = [];
        $username = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $row['fname'];
                //push web_fcm and mobile_fcm to array
                if ($row['web_fcm'] != '') {
                    $notify_user_tokens[] = $row['web_fcm'];
                }
                if ($row['mobile_fcm'] != '') {
                    $notify_user_tokens[] = $row['mobile_fcm'];
                }
            }
        }
        
        // $category_name = $conn->query('SELECT category_name FROM main_category WHERE id = ' . $main_type)->fetch_assoc()['category_name'];
        $from_username = $conn->query("SELECT users.fname FROM users JOIN post_job ON post_job.user_id = users.id WHERE post_job.id = '$jobId'")->fetch_assoc()['fname'];
        $title = $from_username. ' has shortlisted you.';
        $body =  $from_username. ' has shortlisted you.';

        $notification = [
            'title' => $title,
            'body' => $body
        ];
        $Functions = new Functions();
        $Functions->sendNotification($notify_user_tokens, $notification);
        ######## NOTIFICATION END ########

        echo json_encode(array('message' => 'Record updated successfully'), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message' => 'Error updating record: ' . $conn->error), JSON_PRETTY_PRINT);
    }
}

function employerStartJob($conn, $userId, $jobId)
{
    // Ensure the provided user ID and job ID are safe to use in a query
    $userId = $conn->real_escape_string($userId);
    $jobId = $conn->real_escape_string($jobId);

    // SQL query to update the employer_status in the apply_job table
    $sql = "UPDATE apply_job SET worker_status=1 WHERE user_id='$userId' AND job_id='$jobId'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Employer status updated successfully'), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message' => 'Error updating employer status: ' . $conn->error), JSON_PRETTY_PRINT);
    }
}

function ratingUser($conn, $fromUserId, $userId, $jobId, $jobTitle, $stars, $recommends, $message, $userInfo)
{
    // Ensure the provided data is safe to use in a query
    $fromUserId = $conn->real_escape_string($fromUserId);
    $userId = $conn->real_escape_string($userId);
    $jobId = $conn->real_escape_string($jobId);
    $jobTitle = $conn->real_escape_string($jobTitle);
    $stars = $conn->real_escape_string($stars);
    $recommends = $conn->real_escape_string($recommends);
    $message = $conn->real_escape_string($message);
    $escapedUserInfo = $conn->real_escape_string($userInfo);

    // SQL query to insert the rating into the rateuser table
    $sql = "INSERT INTO rateuser (from_user_id, user_id, job_id, job_title, ratings, recommendation, message, user_info)
        VALUES ('$fromUserId', '$userId', '$jobId', '$jobTitle', '$stars', '$recommends', '$message', '$escapedUserInfo')";

    if ($conn->query($sql) === TRUE) {
        $sql = "UPDATE apply_job SET rating=1 WHERE user_id='$userId' AND job_id='$jobId'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array('message' => 'Rating inserted and updated successfully.'), JSON_PRETTY_PRINT);
        } else {
            echo json_encode(array('message' => 'Rating inserted but failed to update apply_job: ' . $conn->error), JSON_PRETTY_PRINT);
        }
    } else {
        echo json_encode(array('message' => 'Error inserting rating: ' . $conn->error));
    }
}

function fetchCategoriesWithoutOther($conn)
{
    $sql = "
        SELECT 
            main.id AS main_category_id,
            main.category_name AS main_category_name,
            sub.id AS sub_category_id,
            sub.category_name AS sub_category_name
        FROM main_category main 
        LEFT JOIN sub_category sub ON main.id = sub.main_category
        WHERE LOWER(main.category_name) NOT LIKE '%other%'
        AND (LOWER(sub.category_name) NOT LIKE '%other%' OR sub.category_name IS NULL)
        ORDER BY main.category_name ASC, sub.category_name ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    $categories = [];
    $processedMainCategories = [];

    foreach ($data as $row) {
        $main_category_id = $row['main_category_id'];

        // Decode any HTML entities in the category names
        $main_category_name = html_entity_decode($row['main_category_name']);
        $sub_category_name = html_entity_decode($row['sub_category_name']);

        // Add main category if not already processed
        if (!in_array($main_category_id, $processedMainCategories)) {
            $categories[] = [
                'main_category_id' => $row['main_category_id'],
                'main_category' => $main_category_name
            ];
            $processedMainCategories[] = $main_category_id;
        }

        // Add sub-category if exists
        if ($row['sub_category_id']) {
            $categories[] = [
                'sub_category_id' => $row['sub_category_id'],
                'main_category' => $sub_category_name
            ];
        }
    }

    echo json_encode($categories);
}

function fetchCategories($conn)
{
    global $base_url;

    $sql = "
        SELECT 
            main.id AS main_category_id,
            main.category_name AS main_category_name,
            main.image AS image,
            sub.id AS sub_category_id,
            sub.category_name AS sub_category_name
        FROM main_category main 
        LEFT JOIN sub_category sub ON main.id = sub.main_category
        WHERE LOWER(main.category_name) NOT LIKE '%other%'
        AND (LOWER(sub.category_name) NOT LIKE '%other%' OR sub.category_name IS NULL)
        ORDER BY main.category_name ASC, sub.category_name ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $executeResult = $stmt->execute();

    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    $categories = [];
    $processedMainCategories = [];

    foreach ($data as $row) {
        $main_category_id = $row['main_category_id'];

        // Decode any HTML entities in the category names
        $main_category_name = html_entity_decode($row['main_category_name']);
        $sub_category_name = html_entity_decode($row['sub_category_name']);

        // Add main category if not already processed
        if (!in_array($main_category_id, $processedMainCategories)) {
            $categories[] = [
                'main_category_id' => $row['main_category_id'],
                'main_category' => $main_category_name,
                'image' => $base_url . '/images/category-image/' . $row['image']
            ];
            $processedMainCategories[] = $main_category_id;
        }

        // Add sub-category if exists
        if ($row['sub_category_id']) {
            $categories[] = [
                'sub_category_id' => $row['sub_category_id'],
                'main_category_id' => $row['main_category_id'],
                'main_category' => $sub_category_name,
                'image' => $base_url . '/images/category-image/' . $row['image']
            ];
        }
    }

    echo json_encode($categories);
}

function userIdExists($conn, $userId)
{
    $userId = $conn->real_escape_string($userId);
    // Prepare the SQL statement to count the number of rows with the given user ID
    $sql = 'SELECT COUNT(*) as count FROM users WHERE id = ?';
    $stmt = $conn->prepare($sql);

    // Check if the statement preparation failed
    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return false;
    }

    // Bind the user ID to the SQL statement and execute it
    $stmt->bind_param('i', $userId);
    $executeResult = $stmt->execute();

    // Check if the execution failed
    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return false;
    }

    // Fetch the result and determine if the user ID exists
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

function updateFcmToken($conn, $data)
{
    // Ensure the provided user ID and FCM token are safe to use in a query
    $userId = $conn->real_escape_string($data['user_id']);
    $fcmToken = $conn->real_escape_string($data['mobile_fcm']);

    // Prepare the SQL statement
    $sql = 'UPDATE users SET mobile_fcm = ? WHERE id = ?';
    $stmt = $conn->prepare($sql);

    // Check if the statement preparation failed
    if (!$stmt) {
        echo json_encode(array('message' => 'Failed to prepare statement.'), JSON_PRETTY_PRINT);
        return;
    }

    // Bind the FCM token and user ID to the SQL statement and execute it
    $stmt->bind_param('si', $fcmToken, $userId);
    $executeResult = $stmt->execute();

    // Check if the execution failed
    if (!$executeResult) {
        echo json_encode(array('message' => 'Failed to execute statement.'), JSON_PRETTY_PRINT);
        return;
    }

    // Check if the user ID exists
    if (userIdExists($conn, $userId)) {
        echo json_encode(array('message' => 'FCM token updated successfully.'), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('message' => 'No user found with the specified ID.'), JSON_PRETTY_PRINT);
    }
}

function compressImage($source, $destination, $compressionPercentage)
{
    // Create Imagick instance
    $imagick = new Imagick($source);

    $imagick->setImageCompression(imagick::COMPRESSION_JPEG);

    // Get original image format
    $imageFormat = $imagick->getImageFormat();
    $imagick->setImageCompressionQuality($compressionPercentage);
    $imagick->setformat('jpg');
    // // Calculate new quality based on the desired percentage

    // Write the compressed image to the destination
    $imagick->writeImage($destination);

    // Destroy the Imagick instance
    $imagick->destroy();
}

?>
