<?php
/**
 * Created by PhpStorm.
 * User: wfreiberger
 * Date: 10.11.17
 * Time: 13:00
 */

namespace App\Http\Controllers;

use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Helpers\Cache\FileSystemCacheHandler;

class Auth0Controller extends Controller {

    // protected $token;
    // protected $tokenInfo;
    // https://github.com/AzureAD/active-directory-b2c-wordpress-plugin-openidconnect/blob/master/class-b2c-token-checker.php

    public function setCurrentToken($token) {

        try {

            $verifier = new JWTVerifier([
                'valid_audiences' => getenv('VALID_AUDIENCES'),
                'authorized_iss' => getenv('AUTHORIZED_ISS'),
                'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
                'supported_algs' => ['RS256'],
                'cache' => new FileSystemCacheHandler() // This parameter is optional. By default no cache is used to fetch the Json Web Keys.
            ]);

            $decoded = $verifier->verifyAndDecode($token);
            return $decoded;

        }
        catch(\Auth0\SDK\Exception\CoreException $e) {
            throw $e;
        }

    }

}