<?php

namespace Illuminate\Database\Eloquent;

use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * @template TModel of Model
 */
class Paginator implements IteratorAggregate, Countable
{
    protected array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function links(): string
    {
        return '';
    }
}

/**
 * @template TModel of Model
 */
class Builder
{
    /**
     * @var TModel|null
     */
    protected $model;

    /**
     * @param TModel|null $model
     */
    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function where(...$args): self
    {
        return $this;
    }

    public function orWhere(...$args): self
    {
        return $this;
    }

    public function orWhereHas($relation, $callback): self
    {
        return $this;
    }

    public function latest($column = 'created_at'): self
    {
        return $this;
    }

    public function orderBy($column, $direction = 'asc'): self
    {
        return $this;
    }

    public function with($relations): self
    {
        return $this;
    }

    public function paginate($perPage = 15)
    {
        return new Paginator();
    }

    /**
     * @return TModel|null
     */
    public function first()
    {
        return null;
    }

    /**
     * @return array<int, TModel>
     */
    public function get(): array
    {
        return [];
    }

    /**
     * @return TModel
     */
    public function findOrFail($id)
    {
        if ($this->model !== null) {
            $this->model->id = $id;
            return $this->model;
        }

        /** @var TModel $model */
        $model = new Model(['id' => $id]);

        return $model;
    }
}
