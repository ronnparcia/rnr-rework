<?php

/**
 * Route for the home page.
 *
 * This route handles the GET request for the home page. It retrieves the posts data using the `getPosts()` function
 * and renders the 'pages/home.twig' template with the retrieved data.
 *
 * @param  object $request  The HTTP request object.
 * @param  object $response The HTTP response object.
 * @param  array  $args     The route arguments.
 * @return object The rendered view with the retrieved posts
 */
$app->get('/', function ($request, $response, $args) {
    $posts = getPosts();

    return $this->view->render($response, 'pages/home.twig', [
        'posts' => $posts
    ]);
});

/**
 * Route for retrieving posts based on category and page number. 
 * 
 * This route handles the GET request for category pages, such as '/films', '/shows', '/music', 
 * or '/others'. It retrieves the posts data using the `getPosts()` function based on the given
 * category parameter and optional page number, and renders the 'pages/category.twig' template with
 * the retrieved data. The template also receives the current page number, total page count, and
 * the category name.
 * 
 * An optional trailing slash is added to prevent 404 errors when a trailing slash is added to the URL.
 * 
 * @param  object $request The HTTP request object.
 * @param  object $response The HTTP response object.
 * @param  array  $args The route parameters.
 * @return object The rendered view with the retrieved posts.
 */
$app->get('/{category:films|shows|music|others}[/{page}[/]]', 
    function ($request, $response, $args) {
        $category = $args['category']; // Get the category
        $page = isset($args['page']) ? (int)$args['page'] : 1; // If page is not set, default to 1, else convert to integer

        // Map category to tag ID
        $tagMap = [
            'films'  => 2147,
            'shows'  => 2225,
            'music'  => 2107,
            'others' => 2226,
        ];

        $tag = $tagMap[$category]; // Get the tag ID based on the category
        $perPage = 20; // Number of posts to retrieve per page

        $posts = getPosts($tag, $perPage, $page); // Get the posts
        $pageCount = getPageCount($tag, $perPage); // Get the total number of pages

        return $this->view->render($response, 'pages/category.twig', [
            'posts' => $posts,
            'page' => $page,
            'pageCount' => $pageCount,
            'category' => $category
        ]);
})->setName('category');
