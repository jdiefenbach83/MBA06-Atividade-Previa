<?php

require_once 'vendor/autoload.php'; //autoload do composer

use Dotenv\Dotenv;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $fb = new Facebook([
        'app_id' => $_ENV['FACEBOOK_APP_ID'],
        'app_secret' => $_ENV['FACEBOOK_APP_SECRET'],
        'default_graph_version' => 'v2.10',
    ]);

    // Returns a `FacebookFacebookResponse` object
    $response = $fb->get(
        '/me?fields=id,name,birthday,email',
        $_ENV['FACEBOOK_ACCESS_TOKEN']
    );

    $graphNode = $response->getGraphNode();
    $response = json_decode($graphNode);

    echo 'id: ', $response->id . PHP_EOL;
    echo 'name: ', $response->name . PHP_EOL;
    echo 'birthday: ', $response->birthday . PHP_EOL;
    echo 'email: ', $response->email . PHP_EOL;

} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
