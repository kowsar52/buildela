<?php 


class Cache {

    public static function addCache($key, $data, $expiration = 3600) {
        $cacheFile = '../cache/' . md5($key) . '.cache';
        $cacheData = [
            'data' => $data,
            'expiration' => time() + $expiration,
        ];

        $cacheContent = json_encode($cacheData);
        file_put_contents($cacheFile, $cacheContent);
    }

    public static function readCache($key) {
        $cacheFile = '../cache/' . md5($key) . '.cache';

        if (file_exists($cacheFile)) {
            $cacheContent = file_get_contents($cacheFile);
            $cacheData = json_decode($cacheContent, true);

            if ($cacheData['expiration'] > time()) {
                return $cacheData['data'];
            } else {
                // Cache has expired, delete it
                deleteCache($key);
            }
        }

        return false;
    }

    public static function deleteCache($key) {
        $cacheFile = '../cache/' . md5($key) . '.cache';

        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }



}