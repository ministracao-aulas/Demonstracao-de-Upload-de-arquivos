<?php

if (!isset($_SESSION)) {
    session_start();
}

function sessionPut(string $key, $value, bool $append = false): void
{
    $key = trim($key);

    if (!$key) {
        return;
    }

    if ($append) {
        $_SESSION[$key][] = $value;

        return;
    }

    $_SESSION[$key] = $value;
}

function sessionGet(string $key, mixed $defaultValue = null): mixed
{
    $key = trim($key);

    if (!$key) {
        return $defaultValue;
    }

    return $_SESSION[$key] ?? $defaultValue;
}

function sessionForget(string $key): void
{
    if (!$key || !trim($key)) {
        return;
    }

    unset($_SESSION[$key]);
    unset($_SESSION[trim($key)]);
}

function flashPut(string $key, string $value): void
{
    $key = trim($key);
    $value = trim($value);

    if (!$key || !$value) {
        return;
    }

    $key = "flash_{$key}";
    sessionPut($key, $value, false);
}

function flashAppend(string $key, string $value): void
{
    $key = trim($key);
    $value = trim($value);

    if (!$key || !$value) {
        return;
    }

    $key = "flash_{$key}";
    sessionPut($key, $value, false);
}

function flashGet(
    string $key,
    ?string $defaultValue = null,
    bool $reflash = false
): ?string {
    $key = trim($key);
    $defaultValue = trim((string) $defaultValue);

    if (!$key) {
        return $defaultValue;
    }

    $key = "flash_{$key}";
    $value = $_SESSION[$key] ?? $defaultValue;

    if (!$reflash) {
        unset($_SESSION[$key]);
    }

    if (!$value || !is_string($value)) {
        return $defaultValue;
    }

    return trim((string) $value);
}
