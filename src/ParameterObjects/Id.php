<?php

namespace Davesweb\BrinklinkApi\ParameterObjects;

final class Id
{
    private array $ids = [];

    public function __toString(): string
    {
        return implode(',', $this->ids);
    }

    public static function default(): static
    {
        return new static();
    }

    public static function make(array|int|null $with = null): static
    {
        return $with ? (new static())->with($with) : new static();
    }

    public function with(int|array $id): static
    {
        if (is_array($id)) {
            $this->ids = array_merge($this->ids, $id);
        } else {
            $this->ids[] = $id;
        }

        return $this;
    }

    public function without(int|array $id): static
    {
        if (is_array($id)) {
            $this->ids = array_merge($this->ids, array_map(function (int $id) {
                return '-' . $id;
            }, $id));
        } else {
            $this->ids[] = '-' . $id;
        }

        return $this;
    }
}
