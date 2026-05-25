<?php

class SessionStoreStub
{
    private $store;

    public function __construct(array &$store)
    {
        $this->store =& $store;
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->store);
    }

    public function get($key, $default = null)
    {
        return $this->store[$key] ?? $default;
    }

    public function put($key, $value): void
    {
        $this->store[$key] = $value;
    }

    public function flush(): void
    {
        $this->store = [];
    }
}

class RedirectResponseStub
{
    public function route($name, $params = []): self
    {
        return $this;
    }

    public function withInput($input = []): self
    {
        return $this;
    }

    public function with($key, $value): self
    {
        return $this;
    }
}

class RedirectorStub
{
    public function route($name, $params = []): RedirectResponseStub
    {
        return (new RedirectResponseStub())->route($name, $params);
    }
}

function session($key = null, $value = null)
{
    static $store = [];
    static $sessionObject = null;

    if ($sessionObject === null) {
        $sessionObject = new SessionStoreStub($store);
    }

    if (func_num_args() === 0) {
        return $sessionObject;
    }

    if (is_array($key)) {
        foreach ($key as $sessionKey => $sessionValue) {
            $store[$sessionKey] = $sessionValue;
        }
        return null;
    }

    if (func_num_args() === 1) {
        return $store[$key] ?? null;
    }

    $store[$key] = $value;

    return null;
}

function view($name, $data = [])
{
    return [
        'view' => $name,
        'data' => $data,
    ];
}

function redirect(): RedirectorStub
{
    return new RedirectorStub();
}

function back(): RedirectResponseStub
{
    return new RedirectResponseStub();
}

function route($name, $params = []): string
{
    return '/' . str_replace('.', '/', $name);
}

function old($key, $default = null)
{
    return $default;
}

function csrf_field(): string
{
    return '';
}
