<?php

namespace App\Http;

class SuperGlobalManager
{
    public static function getRequest(string $key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }

    public static function hasRequest(string $key): bool {
        return isset($_REQUEST[$key]);
    }

    public static function getSession(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function setSession(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public static function hasSession(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public static function removeSession(string $key): void {
        unset($_SESSION[$key]);
    }
}