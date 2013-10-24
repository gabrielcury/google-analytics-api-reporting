<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = false;

$configuration = array(
    'urls' => array(
        'analytics_api'     => 	'https://www.googleapis.com/auth/analytics.readonly',
    ),
    'auth' => array(
    	'username'			=>	'YOUR_USERNAME',
    	'password'			=>	'YOUR_PASSWORD',
    ),
    'analytics_report' => array(
        'app_name'          => 'YOUR APP NAME',
        'keyfile'           => __DIR__.'/../google.p12',
        'email'             => 'YOUR_APP_EMAIL_ADDRESS',
        'client_id'         => 'YOUR_APP_ID',
        'access_type'       => 'offline_access',
        'view_id'           => 'ga:YOUR_VIEWID',
        'visit_string'      => 'ga:visits',
    ),
    'report_to' => array(
        'YOUR_EMAIL_TO_SEND_TO',
        'ANOTHER_EMAIL_TO_SEND_TO',
    ),
    'email_from'            => 'EMAIL_SENT_FROM',
);

require_once __DIR__.'/inc/authenticator.class.php';
require_once __DIR__.'/inc/helpers.php';
require_once __DIR__.'/inc/helpers.dates.php';

$authenticator = new Authenticator($configuration);

require_once __DIR__.'/doreports.php';

$app->run();