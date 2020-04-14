<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Forms\Controls;

use Nette;
use Nette\Forms\Form;


/**
 * Single line text input control.
 */
class TextInput extends TextBase
{

	/**
	 * @param  string|object
	 * @param  int
	 */
	public function __construct($label = null, $maxLength = null)
	{
		parent::__construct($label);
		$this->control->maxlength = $maxLength;
		$this->setOption('type', 'text');
	}


	/**
	 * Loads HTTP data.
	 * @return void
	 */
	public function loadHttpData()
	{
		$this->setValue($this->getHttpData(Form::DATA_LINE));
	}


	/**
	 * Changes control's type attribute.
	 * @param  string
	 * @return static
	 */
	public function setHtmlType($type)
	{
		return $this->setType($type);
	}


	/**
	 * Alias for setHtmlType()
	 * @param  string
	 * @return static
	 */
	public function setType($type)
	{
		$this->control->type = $type;
		return $this;
	}


	/**
	 * Generates control's HTML element.
	 * @return Nette\Utils\Html
	 */
	public function getControl()
	{
		return parent::getControl()->addAttributes([
			'value' => $this->control->type === 'password' ? $this->control->value : $this->getRenderedValue(),
			'type' => $this->control->type ?: 'text',
		]);
	}


	/**
	 * @return static
	 */
	public function addRule($validator, $errorMessage = null, $arg = null)
	{
		if ($this->control->type === null && in_array($validator, [Form::EMAIL, Form::URL, Form::INTEGER], true)) {
			static $types = [Form::EMAIL => 'email', Form::URL => 'url', Form::INTEGER => 'number'];
			$this->control->type = $types[$validator];

		} elseif (
			in_array($validator, [Form::MIN, Form::MAX, Form::RANGE], true)
			&& in_array($this->control->type, ['number', 'range', 'datetime-local', 'datetime', 'date', 'month', 'week', 'time'], true)
		) {
			if ($validator === Form::MIN) {
				$range = [$arg, null];
			} elseif ($validator === Form::MAX) {
				$range = [null, $arg];
			} else {
				$range = $arg;
			}
			if (isset($range[0]) && is_scalar($range[0])) {
				$this->control->min = isset($this->control->min) ? max($this->control->min, $range[0]) : $range[0];
			}
			if (isset($range[1]) && is_scalar($range[1])) {
				$this->control->max = isset($this->control->max) ? min($this->control->max, $range[1]) : $range[1];
			}

		} elseif (
			$validator === Form::PATTERN
			&& is_scalar($arg)
			&& in_array($this->control->type, [null, 'text', 'search', 'tel', 'url', 'email', 'password'], true)
		) {
			$this->control->pattern = $arg;
		}

		return parent::addRule($validator, $errorMessage, $arg);
	}
}
