<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
      'firebase' => [
        'apiKey' => env('FB_apiKey'),
        'authDomain' => env('FB_authDomain'),
        'databaseURL' => env('FB_databaseURL'),
        'projectId' => env('FB_projectId'),
        'storageBucket' => env('FB_storageBucket'),
         'messagingSenderId' => env('FB_messagingSenderId'),
          'appId' => env('FB_appId'),
           'measurementId' => env('FB_measurementId'),
    ],
    
    /*  apiKey: "AIzaSyCe2zbc_F0mh3NCaq2tH1Xw4IgDA0mKYIg",
  authDomain: "bestnet-93cc9.firebaseapp.com",
  databaseURL: "https://bestnet-93cc9.firebaseio.com",
  projectId: "bestnet-93cc9",
  storageBucket: "bestnet-93cc9.appspot.com",
  messagingSenderId: "655570748144",
  appId: "1:655570748144:web:77ca5b6c92b42445b77835",
  measurementId: "G-6PTLMMN0XB"*/
    
    




];
