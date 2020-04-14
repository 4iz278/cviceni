<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Caching;

use Nette;


/**
 * Implements the cache for a application.
 */
class Cache
{
	use Nette\SmartObject;

	/** dependency */
	const
		PRIORITY = 'priority',
		EXPIRATION = 'expire',
		EXPIRE = 'expire',
		SLIDING = 'sliding',
		TAGS = 'tags',
		FILES = 'files',
		ITEMS = 'items',
		CONSTS = 'consts',
		CALLBACKS = 'callbacks',
		NAMESPACES = 'namespaces',
		ALL = 'all';

	/** @internal */
	const NAMESPACE_SEPARATOR = "\x00";

	/** @var IStorage */
	private $storage;

	/** @var string */
	private $namespace;


	public function __construct(IStorage $storage, $namespace = null)
	{
		$this->storage = $storage;
		$this->namespace = $namespace . self::NAMESPACE_SEPARATOR;
	}


	/**
	 * Returns cache storage.
	 * @return IStorage
	 */
	public function getStorage()
	{
		return $this->storage;
	}


	/**
	 * Returns cache namespace.
	 * @return string
	 */
	public function getNamespace()
	{
		return (string) substr($this->namespace, 0, -1);
	}


	/**
	 * Returns new nested cache object.
	 * @param  string  $namespace
	 * @return static
	 */
	public function derive($namespace)
	{
		$derived = new static($this->storage, $this->namespace . $namespace);
		return $derived;
	}


	/**
	 * Reads the specified item from the cache or generate it.
	 * @param  mixed  $key
	 * @param  callable  $fallback
	 * @return mixed
	 */
	public function load($key, $fallback = null)
	{
		$data = $this->storage->read($this->generateKey($key));
		if ($data === null && $fallback) {
			return $this->save($key, function (&$dependencies) use ($fallback) {
				return call_user_func_array($fallback, [&$dependencies]);
			});
		}
		return $data;
	}


	/**
	 * Reads multiple items from the cache.
	 * @param  callable  $fallback
	 * @return array
	 */
	public function bulkLoad(array $keys, $fallback = null)
	{
		if (count($keys) === 0) {
			return [];
		}
		foreach ($keys as $key) {
			if (!is_scalar($key)) {
				throw new Nette\InvalidArgumentException('Only scalar keys are allowed in bulkLoad()');
			}
		}
		$storageKeys = array_map([$this, 'generateKey'], $keys);
		if (!$this->storage instanceof IBulkReader) {
			$result = array_combine($keys, array_map([$this->storage, 'read'], $storageKeys));
			if ($fallback !== null) {
				foreach ($result as $key => $value) {
					if ($value === null) {
						$result[$key] = $this->save($key, function (&$dependencies) use ($key, $fallback) {
							return call_user_func_array($fallback, [$key, &$dependencies]);
						});
					}
				}
			}
			return $result;
		}

		$cacheData = $this->storage->bulkRead($storageKeys);
		$result = [];
		foreach ($keys as $i => $key) {
			$storageKey = $storageKeys[$i];
			if (isset($cacheData[$storageKey])) {
				$result[$key] = $cacheData[$storageKey];
			} elseif ($fallback) {
				$result[$key] = $this->save($key, function (&$dependencies) use ($key, $fallback) {
					return call_user_func_array($fallback, [$key, &$dependencies]);
				});
			} else {
				$result[$key] = null;
			}
		}
		return $result;
	}


	/**
	 * Writes item into the cache.
	 * Dependencies are:
	 * - Cache::PRIORITY => (int) priority
	 * - Cache::EXPIRATION => (timestamp) expiration
	 * - Cache::SLIDING => (bool) use sliding expiration?
	 * - Cache::TAGS => (array) tags
	 * - Cache::FILES => (array|string) file names
	 * - Cache::ITEMS => (array|string) cache items
	 * - Cache::CONSTS => (array|string) cache items
	 *
	 * @param  mixed  $key
	 * @param  mixed  $data
	 * @return mixed  value itself
	 */
	public function save($key, $data, array $dependencies = null)
	{
		$key = $this->generateKey($key);

		if ($data instanceof Nette\Callback || $data instanceof \Closure) {
			if ($data instanceof Nette\Callback) {
				trigger_error('Nette\Callback is deprecated, use closure or Nette\Utils\Callback::toClosure().', E_USER_DEPRECATED);
			}
			$this->storage->lock($key);
			try {
				$data = call_user_func_array($data, [&$dependencies]);
			} catch (\Exception $e) {
				$this->storage->remove($key);
				throw $e;
			} catch (\Throwable $e) {
				$this->storage->remove($key);
				throw $e;
			}
		}

		if ($data === null) {
			$this->storage->remove($key);
		} else {
			$dependencies = $this->completeDependencies($dependencies);
			if (isset($dependencies[self::EXPIRATION]) && $dependencies[self::EXPIRATION] <= 0) {
				$this->storage->remove($key);
			} else {
				$this->storage->write($key, $data, $dependencies);
			}
			return $data;
		}
	}


	private function completeDependencies($dp)
	{
		// convert expire into relative amount of seconds
		if (isset($dp[self::EXPIRATION])) {
			$dp[self::EXPIRATION] = Nette\Utils\DateTime::from($dp[self::EXPIRATION])->format('U') - time();
		}

		// make list from TAGS
		if (isset($dp[self::TAGS])) {
			$dp[self::TAGS] = array_values((array) $dp[self::TAGS]);
		}

		// make list from NAMESPACES
		if (isset($dp[self::NAMESPACES])) {
			$dp[self::NAMESPACES] = array_values((array) $dp[self::NAMESPACES]);
		}

		// convert FILES into CALLBACKS
		if (isset($dp[self::FILES])) {
			foreach (array_unique((array) $dp[self::FILES]) as $item) {
				$dp[self::CALLBACKS][] = [[__CLASS__, 'checkFile'], $item, @filemtime($item) ?: null]; // @ - stat may fail
			}
			unset($dp[self::FILES]);
		}

		// add namespaces to items
		if (isset($dp[self::ITEMS])) {
			$dp[self::ITEMS] = array_unique(array_map([$this, 'generateKey'], (array) $dp[self::ITEMS]));
		}

		// convert CONSTS into CALLBACKS
		if (isset($dp[self::CONSTS])) {
			foreach (array_unique((array) $dp[self::CONSTS]) as $item) {
				$dp[self::CALLBACKS][] = [[__CLASS__, 'checkConst'], $item, constant($item)];
			}
			unset($dp[self::CONSTS]);
		}

		if (!is_array($dp)) {
			$dp = [];
		}
		return $dp;
	}


	/**
	 * Removes item from the cache.
	 * @param  mixed  $key
	 * @return void
	 */
	public function remove($key)
	{
		$this->save($key, null);
	}


	/**
	 * Removes items from the cache by conditions.
	 * Conditions are:
	 * - Cache::PRIORITY => (int) priority
	 * - Cache::TAGS => (array) tags
	 * - Cache::ALL => true
	 * @return void
	 */
	public function clean(array $conditions = null)
	{
		$conditions = (array) $conditions;
		if (isset($conditions[self::TAGS])) {
			$conditions[self::TAGS] = array_values((array) $conditions[self::TAGS]);
		}
		$this->storage->clean($conditions);
	}


	/**
	 * Caches results of function/method calls.
	 * @param  callable  $function
	 * @return mixed
	 */
	public function call($function)
	{
		$key = func_get_args();
		if (is_array($function) && is_object($function[0])) {
			$key[0][0] = get_class($function[0]);
		}
		return $this->load($key, function () use ($function, $key) {
			return call_user_func_array($function, array_slice($key, 1));
		});
	}


	/**
	 * Caches results of function/method calls.
	 * @param  callable  $function
	 * @return \Closure
	 */
	public function wrap($function, array $dependencies = null)
	{
		return function () use ($function, $dependencies) {
			$key = [$function, func_get_args()];
			if (is_array($function) && is_object($function[0])) {
				$key[0][0] = get_class($function[0]);
			}
			$data = $this->load($key);
			if ($data === null) {
				$data = $this->save($key, call_user_func_array($function, $key[1]), $dependencies);
			}
			return $data;
		};
	}


	/**
	 * Starts the output cache.
	 * @param  mixed  $key
	 * @return OutputHelper|null
	 */
	public function start($key)
	{
		$data = $this->load($key);
		if ($data === null) {
			return new OutputHelper($this, $key);
		}
		echo $data;
	}


	/**
	 * Generates internal cache key.
	 * @param  mixed  $key
	 * @return string
	 */
	protected function generateKey($key)
	{
		return $this->namespace . md5(is_scalar($key) ? (string) $key : serialize($key));
	}


	/********************* dependency checkers ****************d*g**/


	/**
	 * Checks CALLBACKS dependencies.
	 * @return bool
	 */
	public static function checkCallbacks(array $callbacks)
	{
		foreach ($callbacks as $callback) {
			if (!call_user_func_array(array_shift($callback), $callback)) {
				return false;
			}
		}
		return true;
	}


	/**
	 * Checks CONSTS dependency.
	 * @param  string  $const
	 * @param  mixed  $value
	 * @return bool
	 */
	private static function checkConst($const, $value)
	{
		return defined($const) && constant($const) === $value;
	}


	/**
	 * Checks FILES dependency.
	 * @param  string  $file
	 * @param  int|null  $time
	 * @return bool
	 */
	private static function checkFile($file, $time)
	{
		return @filemtime($file) == $time; // @ - stat may fail
	}
}
