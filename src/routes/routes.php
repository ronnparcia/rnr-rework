<?php

$app->get('/', function ($request, $response, $args) {
    $data = getPosts();

    return $this->view->render($response, 'home.twig', [
        'data' => $data
    ]);
});