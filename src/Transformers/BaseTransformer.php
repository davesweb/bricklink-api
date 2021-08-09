<?php

namespace Davesweb\BrinklinkApi\Transformers;

class BaseTransformer
{
    protected static string $dto;
    protected static array $toObject;

    public static function toObject(array $data): object
    {
        $values = [];

        foreach (static::$toObject as $key => $property) {
            if (is_array($property)) {
                $transformer = $property[1];
                $property    = $property[0];

                $values[$property] = call_user_func($transformer.'::toObject', $data[$key] ?? []);
            } else {
                $values[$property] = $data[$key] ?? null;
            }
        }

        return new (static::$dto)(...$values);
    }

    public function fromObject(object $object): array
    {
        $values = [];

        foreach (static::$toObject as $key => $property) {
            if (is_array($property)) {
                $transformer = $property[1];
                $property    = $property[0];

                $values[$key] = call_user_func($transformer.'::fromObject', $object->{$property});
            } else {
                $values[$key] = $object->{$property};
            }
        }

        return $values;
    }
}
