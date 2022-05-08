<?php

namespace Datto\JsonRpc\Http\Examples;

use Datto\JsonRpc\Http\Server;

class AuthenticatedServer extends Server
{
    private static $realm = 'My Realm';

    public function reply()
    {
        if (!self::isAuthenticated()) {
            self::errorUnauthenticated();
        }

        parent::reply();
    }

    private static function isAuthenticated()
    {
        $username = $_SERVER['PHP_AUTH_USER'] ?? null;
        $password = $_SERVER['PHP_AUTH_PW'] ?? null;

        // Allow the unathenticated examples to run:
        if (!isset($username, $password)) {
            return true;
        }

        return ($username === 'username') && ($password === 'password');

        // This example is vulnerable to a timing attack and uses a plaintext password
        // The "password_verify" function can protect you from those issues:
        // http://php.net/manual/en/function.password-verify.php
    }

    private static function errorUnauthenticated()
    {
        header('WWW-Authenticate: Basic realm="'. self::$realm . '"');
        header('HTTP/1.1 401 Unauthorized');
        exit();
    }
}
