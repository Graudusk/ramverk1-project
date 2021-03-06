<?php
/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
 *
 * Example for SQLite.
 *  "dsn" => "sqlite:memory::",
 *"dsn" => "sqlite:" . ANAX_INSTALL_PATH . "/data/db.sqlite",
 */
if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
    return [
        // "dsn"             => "mysql:host=lokalhost;dbname=oophp;",
        "dsn"             => "mysql:host=blu-ray.student.bth.se;dbname=erjh17;",
        "username"        => "erjh17",
        "password"        => "H9QrCp2Cqg52",
        "driver_options"  => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ],
        "fetch_mode"      => \PDO::FETCH_OBJ,
        "table_prefix"    => null,
        "session_key"     => "Anax\Database",

        // True to be very verbose during development
        "verbose"         => false,

        // True to be verbose on connection failed
        "debug_connect"   => true,
    ];
}
return [
    "dsn" => "mysql:host=localhost;dbname=travel;",
    "username" => "user",
    "password" => "user",
    "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    // "dsn" => "sqlite:" . ANAX_INSTALL_PATH . "/data/db.sqlite",
    // "username"         => null,
    // "password"         => null,
    // "driver_options"   => null,
    "fetch_mode"       => \PDO::FETCH_OBJ,
    "table_prefix"     => null,
    "session_key"      => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => null,

    // True to be verbose on connection failed
    "debug_connect"   => true,
];
