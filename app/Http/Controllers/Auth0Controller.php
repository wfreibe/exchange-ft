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
use Log;

class Auth0Controller extends Controller {

    public function setCurrentToken($token) {

        try {

            $verifier = new JWTVerifier([
                'valid_audiences' => explode(",", getenv('VALID_AUDIENCES')),
                'authorized_iss' => explode(",", getenv('AUTHORIZED_ISS')),
                'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
                'supported_algs' => explode(",", getenv('SUPPORTED_ALGS')),
                'cache' => new FileSystemCacheHandler() // This parameter is optional. By default no cache is used to fetch the Json Web Keys.
            ]);

            $decoded = $verifier->verifyAndDecode($token);
            // Log::info('Token: '.$token);

            return $decoded;

        }
        catch(\Auth0\SDK\Exception\CoreException $e) {
            throw $e;
        }

    }

}