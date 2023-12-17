<?php

namespace Presentation\Http\Helpers;

use Primitives\Models\RoleName;

class Session
{
    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;
    private bool $sessionState = self::SESSION_NOT_STARTED;
    private static Session $instance;

    private function __construct()
    {
    }

    public static function getInstance(): Session
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }

    public function startSession(): bool
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }

    public function destroy(): bool
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return FALSE;
    }

    public function getRole(): RoleName|null
    {
        if (!isset($this->user['role'])) {
            return null;
        }
        return $this->user['role'];
    }

    public function isSessionStarted(): bool
    {
        return $this->sessionState == self::SESSION_STARTED;
    }
}