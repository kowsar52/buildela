<?php 


class Apifunctions {

    private $db;
    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }


    //get lattitude and longitude from postcode
    public static function getLatLong($postcode) {
        $post_code = preg_replace('/\s+/', '', $postcode);
        $apiUrl = "https://api.postcodes.io/postcodes/$post_code";
        $response = @file_get_contents($apiUrl);

        
        // Check if the request was successful
        if ($response === false) {
            return false;
        } else {
            $data = json_decode($response, true);
            $latitude = $data['result']['latitude'];
            $longitude = $data['result']['longitude'];
            $location = $data['result']['admin_district'];
        }
        $latitude_longitude = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location' => $location
        ];
        return $latitude_longitude;
    }


   function setLeadRead($job_id, $user_id, $identifyer = "leads")
   {
       if($identifyer == 'leads') $identifier = 'lead_ids';
       elseif($identifyer == 'interested') $identifier = 'interested_ids';
       elseif($identifyer == 'shortlisted') $identifier = 'shortlisted_ids';
       elseif($identifyer == 'jobswon') $identifier = 'jobswon_ids';

       
       $sql = "SELECT * FROM `read_leads_counter` WHERE `user_id` = '$user_id'";

       if($this->db->sql($sql)){

           $idstrings = $this->db->getResult();

           $leads          = $idstrings[0]['lead_ids'];
           $interested     = $idstrings[0]['interested_ids'];
           $shortlisted    = $idstrings[0]['shortlisted_ids'];
           $jobswon        = $idstrings[0]['jobswon_ids'];
           
           if ($leads || $interested || $shortlisted || $jobswon) {

               $job_ids = $idstrings[0][$identifier];

               $idlist = explode(',', $job_ids);

               $ids = array_filter($idlist, function($value) {
                   return $value !== "";
               });

               if (!in_array($job_id, $ids)) {
                   array_push($ids, $job_id);
               }

               $idlist = implode(',',$ids);
               
               $sql = "update read_leads_counter set $identifier='$idlist' where user_id='$user_id'";
               if ($this->db->sql($sql)) return true;
               else return false;          

           }else {
               $job_id = $job_id.',';
               $sql = "INSERT INTO `read_leads_counter`(`user_id`,`$identifier`) VALUES ('$user_id','$job_id')";
               
               if ($this->db->sql($sql)) return true;
               else  return false;
           } 
       }

   }

    
    public static function DistanceCalculation($postcodes = [], $value = 'mile'){

        // Radius of the Earth in kilometers
        $earthRadius = 6371;
    
        // Radius of Earth in miles
        $earthRadiusMiles = 3959;
        $c = 0;
    
        if(!empty($postcodes)){
    
            $cordinates = [];
            
            $i = 0;
            foreach($postcodes as $code){ $i++;
    
                $apiUrl = "https://api.postcodes.io/postcodes/$code";
                $response = @file_get_contents($apiUrl);
    
                // Check if the request was successful
                if ($response === false) {
                    return false;
                } else {
                    $data = json_decode($response, true);
                    
    
                    if ($data['status'] === 200) {
                        if($i === 1){
                            $cordinates['origin']['latitude'] = $data['result']['latitude'];
                            $cordinates['origin']['longitude'] = $data['result']['longitude'];
                        }else if($i === 2){
                            $cordinates['destination']['latitude'] = $data['result']['latitude'];
                            $cordinates['destination']['longitude'] = $data['result']['longitude'];
                        }
    
                    }
                }
    
            }
    
            if(!empty($cordinates)){
    
                // Convert latitude and longitude from degrees to radians
                $lat1Rad = deg2rad($cordinates['origin']['latitude']);
                $lon1Rad = deg2rad($cordinates['origin']['longitude']);
                $lat2Rad = deg2rad($cordinates['destination']['latitude']);
                $lon2Rad = deg2rad($cordinates['destination']['longitude']);
            
                // Haversine formula to calculate distance between two points on the Earth's surface
                $deltaLat = $lat2Rad - $lat1Rad;
                $deltaLon = $lon2Rad - $lon1Rad;
                $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) * sin($deltaLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            
            }
        
            if($value === 'km')
                $distance = $earthRadius * $c;
            else if ($value === 'mile')
                $distance = $earthRadiusMiles * $c;
            else $distance = false;
        
            return number_format($distance, 2);
    
        }
    
    }
    
    
    public static function PostVerify($code) {
        $apiUrl = "https://api.postcodes.io/postcodes/".$code."/validate";
        $response = file_get_contents($apiUrl);
    
        if ($response === false) {
            return false;
        } else {
            $data = json_decode($response, true);
            if ($data['status'] === 200) {
                if($data['result'] === true) return true;
                else return false;
            }
        }
        
    }


    public static function APIkeyGenerator($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $apiKey = '';
        $charLength = strlen($characters);
        
        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[rand(0, $charLength - 1)];
        }
    
        return $apiKey;
    }



    public static function VerifyApiKey($apiKey) {
        $validKeys = [
            "ONPvGPfFoZxtc3Y4AdUaLBB2z9SMt1MW" => "Mobile App",
            "AZOub5ns1UsQA1GU2ZQ0ZqLOAVAnwGQN" => "Secondary Client",
        ];
    
        return isset($validKeys[$apiKey]);
    }



    function UserInfo($id)
    {
        //single user query
        $query = "SELECT * FROM users WHERE id = '$id'";
        $result = $this->db->sql($query);
        $row = $this->db->getResult($result);
        if(empty($row)){
            return false;
        }else{
            return $row[0];
        }
    }


    function getUserCategoryIds($userId){
        $sql = "SELECT main_category FROM verify_skill WHERE user_id = '$userId' AND status = 1 AND verify = 1";
        $result = $this->db->sql($sql);
        $row = $this->db->getResult($result);
        if(empty($row)){
            return false;
        }else{
            $categories_ids = implode(",", array_map(function ($entry) {
                return $entry['main_category'];
            }, $row));
            return $categories_ids;
        }
    }

    public function sanitizeInput($input) {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->sanitizeInput($value);
            }
        } else {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            
            $input = $this->db->escapeString($input);
        }
        return $input;
    }
    

}