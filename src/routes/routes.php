<?php

/**
 * Route for the home page.
 *
 * This route handles the GET request for the home page. It retrieves the posts data using the `getPosts()` function
 * and renders the 'pages/home.twig' template with the retrieved data.
 *
 * @param $request The HTTP request object.
 * @param $response The HTTP response object.
 * @param $args The route arguments.
 * @return The rendered view.
 */
$app->get('/', function ($request, $response, $args) {
    $data = getPosts();

    return $this->view->render($response, 'pages/home.twig', [
        'data' => $data
    ]);
});

/**
 * Route for retrieving posts based on category and page number.
 *
 * @param object $request The HTTP request object.
 * @param object $response The HTTP response object.
 * @param array $args The route parameters.
 * @return object The rendered view with the retrieved posts.
 */
$app->get('/{category:films|shows|music|others}[/{page}]', 
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

        $data = getPosts($tag, $perPage, $page); // Get the posts

        return $this->view->render($response, 'pages/category.twig', [
            'data' => $data,
            'pageName' => ucwords($category), // Capitalize the category name (e.g. 'films' to 'Films')
        ]);
});
