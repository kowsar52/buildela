<?php 


class Apifunctions {


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
                $response = file_get_contents($apiUrl);
    
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
}