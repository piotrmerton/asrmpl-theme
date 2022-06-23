<?php

namespace Theme;

use GuzzleHttp\Client;
use GuzzleHttp\Client\Request;



class Api {

	//api key moved to Global Options
	private static $api_host = 'v3.football.api-sports.io';

	public static function request($endpoint) {


		$client = new Client();

		$response = $client->request(
			'GET', 
			$endpoint,
			[
				'verify' => false, //https://stackoverflow.com/questions/35638497/curl-error-60-ssl-certificate-prblm-unable-to-get-local-issuer-certificate
				'headers' => [
		    		'x-rapidapi-host' => self::$api_host,
		    		'x-rapidapi-key' => API_FOOTBALL_KEY,
				]
			]
		);
		
		
		if($response->getStatusCode() == 200) {
			return $response->getBody()->getContents();
		} else {
			return false;
		}


	}

	/**
	 * API Request with simple custom caching
	 * 
	 * Use server-side caching to store API request's as JSON file 
	 * 
	 * @param string	$endpoint	request url
	 * @param int 		$ttl 		time until cached request expires
	 * 
	 * @return mixed	API response (object, array or false)
	 * 
	 * @todo use https://github.com/Kevinrob/guzzle-cache-middleware instead? Example implementation: https://stackoverflow.com/a/37379482/17192641
	 * 
	 **/
	public static function getData($endpoint, $ttl = 86400) {

		$cache_dir = self::getCacheDir();

		$key = self::getCacheKey($endpoint);

		$cache_file = $cache_dir . $key . '.json';
		$expires = time() - $ttl;
	
		if( !file_exists($cache_file) || filemtime($cache_file) < $expires ) {

			// if(!file_exists($cache_file)) die('cache file doesnt exist');
			// if(filemtime($cache_file) < $expires) die('cache file expired');

			//die('API request stopped in debug '.$cache_file);
			$data = self::request($endpoint);

			if($data) {

                $json_data = json_decode($data);
				
                //don't store data when there are no results?
                //if($json_data->results == 0) 
                
                file_put_contents($cache_file, $data);

				return json_decode($data);

			} else {

				if(file_exists($cache_file)) unlink($cache_file);
				
				return false;

			}

		} else {

			$json_from_file = file_get_contents($cache_file);
			return json_decode($json_from_file);

		}



	}

	public static function getCacheKey($string) {

		return md5($string);
	}


	public static function getCacheDir() {

		return get_stylesheet_directory() . '/cache/api/';

	}   

	/**
	 * 
	 * Download Image from API only if it doesn't already exists in cache
	 * 
	 * @param string	$url		url to remote image
	 * @param string	$filename	new filename for downloaded file
	 * @param string	$extension	image extension	
	 * 
	 * @return path to image
	 * 
	 * @todo detect extension based on url
	 * 
	 **/
	public static function getImage($url, $filename, $extension = 'png') : string {

		
		$cache_images_dir = self::getCacheDir().'images/';

		$filename .= '.'. $extension;

		$image_file = $cache_images_dir . $filename;

		// file doesn't exists, so let's save it
		// https://stackoverflow.com/a/57606637/17192641
		if( !file_exists($image_file) ) {

            $client = new Client();

			$resource = fopen($image_file, 'w');

			$response = $client->request(
				'GET', 
				$url,
				[
					'verify' => false,
					'sink' => $resource
				]
			);			

		}
		
        
		return get_template_directory_uri() . '/cache/api/images/'.$filename;


	}

}