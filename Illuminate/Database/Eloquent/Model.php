<?php

namespace Illuminate\Database\Eloquent;

/**
 * @mixin Builder<static>
 */
class Model
{
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @return Builder<static>
     */
    public static function query(): Builder
    {
        return new Builder(new static());
    }

    public static function create(array $attributes = []): static
    {
        return new static($attributes);
    }

    public static function findOrFail($id): static
    {
        return new static(['id' => $id]);
    }

    /**
     * @return Builder<static>
     */
    public static function where(...$args): Builder
    {
        return self::query()->where(...$args);
    }

    /**
     * @return Builder<static>
     */
    public static function orderBy($column, $direction = 'asc'): Builder
    {
        return self::query()->orderBy($column, $direction);
    }

    /**
     * @return Builder<static>
     */
    public static function latest($column = 'created_at'): Builder
    {
        return self::query()->latest($column);
    }

    /**
     * @return Builder<static>
     */
    public static function with($relations): Builder
    {
        return self::query()->with($relations);
    }

    public function update(array $attributes): bool
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return true;
    }

    public function delete(): bool
    {
        return true;
    }

    public function decrement($column, $amount = 1): bool
    {
        $currentValue = (int) ($this->attributes[$column] ?? 0);
        $this->attributes[$column] = $currentValue - (int) $amount;

        return true;
    }

    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        return new Builder($this);
    }

    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        return new Builder($this);
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value): void
    {
        $this->attributes[$key] = $value;
    }
}
