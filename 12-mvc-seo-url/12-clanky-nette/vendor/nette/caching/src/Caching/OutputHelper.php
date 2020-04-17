<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Caching;

use Nette;


/**
 * Output caching helper.
 */
class OutputHelper
{
	use Nette\SmartObject;

	/** @var array */
	public $dependencies;

	/** @var Cache|null */
	private $cache;

	/** @var string */
	private $key;


	public function __construct(Cache $cache, $key)
	{
		$this->cache = $cache;
		$this->key = $key;
		ob_start();
	}


	/**
	 * Stops and saves the cache.
	 * @return void
	 */
	public function end(array $dependencies = null)
	{
		if ($this->cache === null) {
			throw new Nette\InvalidStateException('Output cache has already been saved.');
		}
		$this->cache->save($this->key, ob_get_flush(), (array) $dependencies + (array) $this->dependencies);
		$this->cache = null;
	}
}
