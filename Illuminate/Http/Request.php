<?php

namespace Illuminate\Http;

class Request
{
    protected array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function validate(array $rules, array $messages = []): array
    {
        return $this->data;
    }

    public function filled($key): bool
    {
        return isset($this->data[$key]) && $this->data[$key] !== '';
    }

    public function only($keys): array
    {
        $result = [];
        foreach ((array) $keys as $key) {
            if (array_key_exists($key, $this->data)) {
                $result[$key] = $this->data[$key];
            }
        }
        return $result;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function session()
    {
        return \session();
    }
}
