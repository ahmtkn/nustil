<?php

namespace App\Helpers;

use Countable;
use Traversable;
use ArrayAccess;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;


class ArrayNotationHelper implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{

    protected $items = [];

    public function __construct($items = [], $parse = false)
    {
        $items = $this->getArrayItems($items);
        if ($parse) {
            $items = $this->parseItems($items);
        } else {
            $this->items = $items;
        }
    }

    protected function getArrayItems($items)
    {
        return $items instanceof self ? $items->all() : (array)$items;
    }

    public function all()
    {
        return $this->items;
    }

    public function set($keys, $value = null)
    {
        return $this->parseItems($keys, $value);
    }

    protected function parseItems($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $val) {
                $this->parseItems($key, $val);
            }

            return $this;
        }
        $items = &$this->items;
        if (is_string($keys)) {
            foreach (explode('.', $keys) as $key) {
                if (!isset($items[$key]) || !is_array($items[$key])) {
                    $items[$key] = [];
                }
                $items = &$items[$key];
            }
        }
        $items = $value;

        return $this;
    }

    public function add($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $val) {
                $this->add($key, $val);
            }
        } elseif ($this->get($keys) === null) {
            $this->set($keys, $value);
        }
    }

    public function get($key = null, $default = null)
    {
        if ($key == null) {
            return $this->items;
        }

        if ($this->exists($key)) {
            return $this->items[$key];
        }

        if (!is_string($key) || strpos($key, '.') == 'false') {
            return $default;
        }
        $items = $this->items;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($items) || !$this->exists($segment)) {
                return $default;
            }
            $items = &$items[$segment];
        }

        return $items;
    }

    protected function exists($key, $array = null)
    {
        $array = $array ?? $this->items;

        return array_key_exists($key, $array);
    }

    public function flatten($delimiter = '.', $items = null, $prepend = '')
    {
        $flatten = [];
        $items = $items ?? $this->items;
        foreach ($items as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $flatten[] = $this->flatten($delimiter, $value, $prepend.$key.$delimiter);
                continue;
            }
            $flatten[$prepend.$key] = $value;
        }

        return array_merge(...$flatten);
    }

    public function isEmpty($keys = null)
    {
        if ($keys === null) {
            return empty($this->items);
        }

        foreach ((array)$keys as $key) {
            if (!empty($this->get($key))) {
                return false;
            }
        }

        return true;
    }

    public function merge($key, $value = [])
    {
        if (is_array($key)) {
            $this->items = array_merge($this->items, $key);
        } elseif (is_string($key)) {
            $items = (array)$this->get($key);
            $value = array_merge($items, $this->getArrayItems($value));

            $this->set($key, $value);
        } elseif ($key instanceof self) {
            $this->items = array_merge($this->items, $key->all());
        }

        return $this;
    }

    public function mergeRecursive($key, $value = [])
    {
        if (is_array($key)) {
            $this->items = array_merge_recursive($this->items, $key);
        } elseif (is_string($key)) {
            $items = (array)$this->get($key);
            $value = array_merge_recursive($items, $this->getArrayItems($value));

            $this->set($key, $value);
        } elseif ($key instanceof self) {
            $this->items = array_merge_recursive($this->items, $key->all());
        }

        return $this;
    }

    public function mergeRecursiveDistinct($key, $value = [])
    {
        if (is_array($key)) {
            $this->items = $this->arrayMergeRecursiveDistinct($this->items, $key);
        } elseif (is_string($key)) {
            $items = (array)$this->get($key);
            $value = $this->arrayMergeRecursiveDistinct($items, $this->getArrayItems($value));

            $this->set($key, $value);
        } elseif ($key instanceof self) {
            $this->items = $this->arrayMergeRecursiveDistinct($this->items, $key->all());
        }

        return $this;
    }

    protected function arrayMergeRecursiveDistinct(array $array1, array $array2)
    {
        $merged = &$array1;

        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    public function pull($key = null, $default = null)
    {
        if ($key === null) {
            $value = $this->all();
            $this->clear();

            return $value;
        }

        $value = $this->get($key, $default);
        $this->delete($key);

        return $value;
    }

    public function push($key, $value = null)
    {
        if ($value === null) {
            $this->items[] = $key;

            return $this;
        }

        $items = $this->get($key);

        if (is_array($items) || $items === null) {
            $items[] = $value;
            $this->set($key, $items);
        }

        return $this;
    }

    public function replace($key, $value = [])
    {
        if (is_array($key)) {
            $this->items = array_replace($this->items, $key);
        } elseif (is_string($key)) {
            $items = (array)$this->get($key);
            $value = array_replace($items, $this->getArrayItems($value));

            $this->set($key, $value);
        } elseif ($key instanceof self) {
            $this->items = array_replace($this->items, $key->all());
        }

        return $this;
    }

    public function setReference(array &$items)
    {
        $this->items = &$items;

        return $this;
    }

    public function toJson($key = null, $options = 0)
    {
        if (is_string($key)) {
            return json_encode($this->get($key), $options);
        }

        $options = $key === null ? 0 : $key;

        return json_encode($this->items, $options);
    }

    public static function __set_state(array $items): object
    {
        return (object)$items;
    }

    public function has($keys)
    {
        $keys = (array)$keys;

        if (!$this->items || $keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $items = $this->items;

            if ($this->exists($items, $key)) {
                continue;
            }

            foreach (explode('.', $key) as $segment) {
                if (!is_array($items) || !$this->exists($items, $segment)) {
                    return false;
                }

                $items = $items[$segment];
            }
        }

        return true;
    }

    public function delete($keys)
    {
        $keys = (array)$keys;

        foreach ($keys as $key) {
            if ($this->exists($this->items, $key)) {
                unset($this->items[$key]);

                continue;
            }

            $items = &$this->items;
            $segments = explode('.', $key);
            $lastSegment = array_pop($segments);

            foreach ($segments as $segment) {
                if (!isset($items[$segment]) || !is_array($items[$segment])) {
                    continue 2;
                }

                $items = &$items[$segment];
            }

            unset($items[$lastSegment]);
        }

        return $this;
    }

    public function clear($keys = null)
    {
        if ($keys === null) {
            $this->items = [];

            return $this;
        }

        $keys = (array)$keys;

        foreach ($keys as $key) {
            $this->set($key, []);
        }

        return $this;
    }

    public function setArray($items)
    {
        $this->items = $this->getArrayItems($items);

        return $this;
    }

    /*
     * --------------------------------------------------------------
     * ArrayAccess interface
     * --------------------------------------------------------------
     */

    /**
     * Check if a given key exists
     *
     * @param  int|string  $key
     *
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return $this->has($key);
    }

    /**
     * Return the value of a given key
     *
     * @param  int|string  $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a given value to the given key
     *
     * @param  int|string|null  $key
     * @param  mixed  $value
     */
    public function offsetSet($key, $value): void
    {
        if ($key === null) {
            $this->items[] = $value;

            return;
        }

        $this->set($key, $value);
    }

    /**
     * Delete the given key
     *
     * @param  int|string  $key
     *
     * @return void
     */
    public function offsetUnset($key): void
    {
        $this->delete($key);
    }

    /*
     * --------------------------------------------------------------
     * Countable interface
     * --------------------------------------------------------------
     */

    /**
     * Return the number of items in a given key
     *
     * @param  int|string|null  $key
     *
     * @return int
     */
    public function count($key = null): int
    {
        return count($this->get($key));
    }

    /*
     * --------------------------------------------------------------
     * IteratorAggregate interface
     * --------------------------------------------------------------
     */

    /**
     * Get an iterator for the stored items
     *
     * @return ArrayIterator<TKey, TValue>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /*
     * --------------------------------------------------------------
     * JsonSerializable interface
     * --------------------------------------------------------------
     */

    /**
     * Return items for JSON serialization
     *
     * @return array<TKey, TValue>
     */
    public function jsonSerialize(): array
    {
        return $this->items;
    }

}
