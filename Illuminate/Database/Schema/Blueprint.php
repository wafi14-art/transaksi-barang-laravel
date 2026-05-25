<?php

namespace Illuminate\Database\Schema;

class Blueprint
{
    public function id(): self
    {
        return $this;
    }

    public function foreignId(string $column): self
    {
        return $this;
    }

    public function constrained(?string $table = null): self
    {
        return $this;
    }

    public function onDelete(string $action): self
    {
        return $this;
    }

    public function string(string $column, int $length = 255): self
    {
        return $this;
    }

    public function integer(string $column): self
    {
        return $this;
    }

    public function decimal(string $column, int $precision = 8, int $scale = 2): self
    {
        return $this;
    }

    public function text(string $column): self
    {
        return $this;
    }

    public function enum(string $column, array $values): self
    {
        return $this;
    }

    public function timestamps(): self
    {
        return $this;
    }

    public function unique($columns): self
    {
        return $this;
    }

    public function nullable(): self
    {
        return $this;
    }
}
