<?php

namespace Illuminate\Http;

class Session
{
    public function has($key): bool
    {
        return false;
    }

    public function flush(): void
    {
    }
}
