<?php

$app->get('/', function ($request, $response, $args) {
    $url = "https://thelasallian.com/wp-json/wp/v2/posts?tags=497";
    $data = getPosts($url);

    return $this->view->render($response, 'home.twig', [
        'data' => $data
    ]);
});