<?php

/**
 * Sends an HTTP request to the specified URL and retrieves the response.
 *
 * @param string $url The URL to send the request to.
 * @param string $httpReq The HTTP request method (default: 'GET').
 * @return array|null The response data as an associative array, or null if an error occurred.
 */
function getPosts($url, $httpReq = 'GET') {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $httpReq,
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
}
