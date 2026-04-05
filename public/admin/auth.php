<?php

declare(strict_types=1);

final class Auth
{
    private const SESSION_KEY = 'crm_admin';
    private const PASSWORD_ENV = 'CRM_ADMIN_PASSWORD';
    private const DEFAULT_PASSWORD = 'ecosystemeimmo2026';

    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function check(): bool
    {
        self::start();

        return !empty($_SESSION[self::SESSION_KEY]);
    }

    public static function attempt(string $password): bool
    {
        self::start();

        $expected = getenv(self::PASSWORD_ENV) ?: self::DEFAULT_PASSWORD;
        if (!hash_equals((string) $expected, $password)) {
            return false;
        }

        $_SESSION[self::SESSION_KEY] = true;

        return true;
    }

    public static function logout(): void
    {
        self::start();
        unset($_SESSION[self::SESSION_KEY]);
    }
}
