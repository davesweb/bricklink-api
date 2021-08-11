<?php

namespace Davesweb\BrinklinkApi\Transformers;

use DateTime;
use Illuminate\Support\Str;

class BaseTransformer
{
    protected static string $dto;

    protected static array $mapping = [];

    protected static string $dateTimeFormat = 'Y-m-d\TH:i:s';

    public static function toObject(array $data): object
    {
        $values = [];

        foreach ($data as $key => $value) {
            $property = static::$mapping[$key] ?? (string) Str::of($key)->camel();

            if (is_array($property)) {
                $listTransformer = $property[2] ?? null;
                $transformer     = $property[1];
                $property        = $property[0];

                if ('datetime' === $transformer) {
                    $values[$property] = new DateTime($value);
                } elseif ('array' === $transformer) {
                    if (null === $listTransformer) {
                        $values[$property] = (array) $value;
                    } else {
                        $values[$property] = [];
                        foreach ($value as $subValue) {
                            $values[$property][] = call_user_func($listTransformer.'::toObject', $subValue);
                        }
                    }
                } else {
                    $values[$property] = call_user_func($transformer.'::toObject', $valye ?? []);
                }
            } else {
                $values[$property] = $value;
            }
        }

        return new (static::$dto)(...$values);
    }

    public static function toArray(object $object): array
    {
        $values = [];

        $data = get_object_vars($object);

        foreach ($data as $property => $value) {
            // todo This probably doesn't work correctly with the array values, create custom getter
            $key = array_search($property, static::$mapping, true) ? array_search($property, static::$mapping, true) : (string) Str::of($property)->snake();

            if (is_array(static::$mapping[$key])) {
                $transformer = static::$mapping[$key][1];

                if ('datetime' === $transformer) {
                    $values[$key] = $value->format(static::$dateTimeFormat);
                } else {
                    $values[$key] = call_user_func($transformer.'::fromObject', $value);
                }
            } else {
                $values[$key] = $value;
            }
        }

        return $values;
    }
}
