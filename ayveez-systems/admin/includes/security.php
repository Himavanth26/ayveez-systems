<?php

/*
|--------------------------------------------------------------------------
| SECURITY CONFIGURATION
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/

if (empty($_SESSION["csrf_token"])) {

    $_SESSION["csrf_token"] =
        bin2hex(
            random_bytes(32)
        );

}


/*
|--------------------------------------------------------------------------
| GENERATE CSRF TOKEN
|--------------------------------------------------------------------------
*/

function csrf_token()
{
    return $_SESSION["csrf_token"];
}


/*
|--------------------------------------------------------------------------
| VERIFY CSRF TOKEN
|--------------------------------------------------------------------------
*/

function verify_csrf_token($token)
{

    if (
        empty($token) ||
        empty($_SESSION["csrf_token"])
    ) {

        return false;

    }

    return hash_equals(
        $_SESSION["csrf_token"],
        $token
    );

}

?>