<?php


class Rsc_Common_Collection implements Countable, IteratorAggregate, Serializable, ArrayAccess
{

    /** @var  array */
    protected $collection;

    /**
     * Constructor
     * @param array $collection An array of collection elements
     */
    public function __construct(array $collection = array())
    {
        $this->collection = $collection;
    }

    /**
     * Return data for the key
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Set data on the key
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if ($this->has($key)) {
            $this->set($key, $value);
        } else {
            $this->add($key, $value);
        }
    }

    /**
     * Checks whether a specified key if the collection
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * Removes the element with the specified key
     * @param $key
     */
    public function __unset($key)
    {
        $this->delete($key);
    }

    /**
     * Checks whether a specified key if the collection
     * @param string $key Key to verify
     * @return bool TRUE if the key exists, FALSE otherwise
     */
    public function has($key)
    {
        return isset($this->collection[$key]);
    }

    /**
     * Checks whether a specified value if the collection
     * @param string $value Value to verify
     * @param bool $strict If set TRUE then method use strict check, FALSE means non-strict
     * @return bool
     */
    public function hasValue($value, $strict = true)
    {
        foreach ($this->collection as $collectionValue) {
            if ($strict) {
                if ($value === $collectionValue) {
                    return true;
                }
            } else {
                if (strtolower($value) == strtolower($collectionValue)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns all items in the collection
     * @return array
     */
    public function all()
    {
        return $this->collection;
    }

    /**
     * Adds a new item to the collection
     * @param string $key Key to add
     * @param mixed $value Value of the element
     * @return Rsc_Common_Collection
     */
    public function add($key, $value)
    {
        if (!$this->has($key)) {
            $this->collection[$key] = $value;
        }

        return $this;
    }

    /**
     * Change the value of an existing key
     * @param string $key The key to be edited
     * @param mixed $value The new value
     * @return Rsc_Common_Collection
     */
    public function set($key, $value)
    {
        if ($this->has($key)) {
            $this->collection[$key] = $value;
        }

        return $this;
    }

    /**
     * Get the value of the specified key
     * @param string|array $key The key whose value you want to get
     * @param mixed $default Value that returns method if the specified key is not in the collection
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return array_combine($key, array_map(array($this, 'get'), $key));
        }

        if ($this->has($key)) {
            return $this->collection[$key];
        }

        return $default;
    }

    /**
     * Removes the element with the specified key
     * @param string $key Name of the key to be deleted
     * @return bool TRUE if the key exists and removed, FALSE otherwise
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            unset ($this->collection[$key]);
            return true;
        }

        return false;
    }

    /**
     * Change the current collection to the specified
     * @param array $collection Array elements of the new collection
     * @return Rsc_Common_Collection
     */
    public function replace(array $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Merge the specified array with the current collection
     * @param array $collection Array elements
     * @return Rsc_Common_Collection
     */
    public function merge(array $collection)
    {
        $this->collection = array_merge($this->collection, $collection);

        return $this;
    }

    /**
     * Applies the callback to the elements of the collection
     * @param callable $callback Callback function to run for each element in the collection
     * @return Rsc_Common_Collection
     */
    public function map(Callable $callback)
    {
        $this->collection = array_map($callback, $this->collection);

        return $this;
    }

    /**
     * Returns collection keys
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->collection);
    }

    /**
     * Returns collection values
     * @return array
     */
    public function getValues()
    {
        return array_values($this->collection);
    }

    /**
     * Checks whether the collection is empty
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this->collection) < 1);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->collection);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->collection = unserialize($serialized);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset, null);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }
}