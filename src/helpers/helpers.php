<?php

/**
 * Retrieves posts from the WordPress REST API based on the specified parameters.
 *
 * @param int    $tag      The tag ID to filter the posts by. Default is 497 ('Rant and Rave').
 * @param int    $perPage  The number of posts to retrieve per page. Default is 10.
 * @param int    $page     The page number of the posts to retrieve. Default is 1.
 * @param string $httpReq  The HTTP request method to use. Default is 'GET'.
 *
 * @return array|false     Returns an array of posts if successful, or false on failure.
 */
function getPosts($tag = 497, $perPage = 10, $page = 1, $httpReq = 'GET') {
    // Build the WordPress REST API URL
    $fields = "title,link,jetpack_featured_media_url,date,tags,excerpt,content,authors";
    $domain = "https://thelasallian.com";
    $url = "$domain/wp-json/wp/v2/posts?_fields=$fields&tags=$tag&per_page=$perPage&page=$page";

    // Make the request
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

    // Return the response in array format
    return json_decode($response, true);
}

/**
 * Get the total number of pages for a specific tag using the WordPress REST API Headers
 *
 * @param  string $tag     The tag to filter the posts by.
 * @param  int    $perPage The number of posts to display per page. Default is 10.
 * @return int    The total number of pages.
 */
function getPageCount($tag, $perPage = 10) {
    $domain = "https://thelasallian.com";
    $url = "$domain/wp-json/wp/v2/posts?tags=$tag&per_page=$perPage";

    // Get the headers
    $headers = get_headers($url, true); // true parameter to get associative array
    $pageCount = $headers["X-WP-TotalPages"];

    return $pageCount;
}