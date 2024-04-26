<?php

$app->get('/', function ($request, $response, $args) {
    $data = getPosts();

    return $this->view->render($response, 'pages/home.twig', [
        'data' => $data
    ]);
});

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
