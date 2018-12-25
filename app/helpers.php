<?php
/**
 * Created by PhpStorm.
 * User: Marc LAW: zunly@hotmail.com
 * Date: 2018/12/25
 * Time: 16:10
 */

function get_db_config()
{
    if (getenv('IS_IN_HEROKU')) {
        $url = parse_url(getenv("DATABASE_URL"));

        return $db_config = [
            'driver' => 'pgsql',
            'host' => $url["host"],
            'port' => $url["port"],
            'database' => ltrim($url["path"], "/"),
            'username' => $url["user"],
            'password' => $url["pass"],
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'require',
//            'driver' => 'pgsql',
//            'connection' => 'pgsql',
//            'host' => $url["host"],
//            'database'  => substr($url["path"], 1),
//            'username'  => $url["user"],
//            'password'  => $url["pass"],
        ];
    } else {
        return $db_config = [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'homestead'),
            'username' => env('DB_USERNAME', 'homestead'),
            'password' => env('DB_PASSWORD', 'secret'),
        ];
    }
}