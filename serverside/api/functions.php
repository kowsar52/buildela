<?php 


class Apifunctions {

    private $db;
    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }


    // function batchDistance($origin, $batchcodes, $value = 'mile'){
       
    //     // Radius of the Earth in kilometers
    //     $earthRadius = 6371;

    //     // Radius of Earth in miles
    //     $earthRadiusMiles = 3959;

        
    //     $distances  =	[];
    //     $origins 	=	[
    //         'latitude' 	=> null,
    //         'longitude'	=> null
    //     ];	
    //     $c = 0;
    
    
    //     $apiUrl = "https://api.postcodes.io/postcodes/$origin";
    //     try {
    //         $response = file_get_contents($apiUrl);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return false;
    //     }

    //     if ($response === false) {
    //         return false;
    //     } else {
    
    //         $data = json_decode($response, true);
            
    //         if ($data['status'] === 200) {
    //             $origins['latitude'] = $data['result']['latitude'];
    //             $origins['longitude'] = $data['result']['longitude'];
    //         } 
    
    //     }
    
        
    //     $data = [
    //         "postcodes" => $batchcodes
    //     ];
    //     $jsonData = json_encode($data);    
  
    //     $ch = curl_init();
    
    //     // Set cURL options
    //     curl_setopt($ch, CURLOPT_URL, "https://api.postcodes.io/postcodes/");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Content-Type: application/json',
    //     ]);
    
    //     $response = curl_exec($ch);

    //     if (curl_errno($ch)) {
    //         return false;
    //     }
    
    //     curl_close($ch);
    //     $result = json_decode($response, true);
    
    //     if (!empty($result['result'][0]['result'])) {
    //         foreach ($result["result"] as $postcodeData) {
    
                
    
    //             if($origins['latitude']){
    
    //                 // Convert latitude and longitude from degrees to radians
    //                 $lat1Rad = deg2rad($origins['latitude']);
    //                 $lon1Rad = deg2rad($origins['longitude']);
    //                 $lat2Rad = deg2rad($postcodeData['result']['latitude']);
    //                 $lon2Rad = deg2rad($postcodeData['result']['longitude']);
                
    //                 // Haversine formula to calculate distance between two points on the Earth's surface
    //                 $deltaLat = $lat2Rad - $lat1Rad;
    //                 $deltaLon = $lon2Rad - $lon1Rad;
    //                 $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) * sin($deltaLon / 2);
    //                 $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                
    //             }
            
    //             if($value === 'km')
    //                 $distance = $earthRadius * $c;
    //             else if ($value === 'mile')
    //                 $distance = $earthRadiusMiles * $c;
    
                    
                
    //             array_push($distances, (float) number_format($distance, 2));
    //         }
    
    
    //     } else {
    //         array_push($distances, 'NA');
    //     }
    
    //     return $distances;    
    // }
    
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

}