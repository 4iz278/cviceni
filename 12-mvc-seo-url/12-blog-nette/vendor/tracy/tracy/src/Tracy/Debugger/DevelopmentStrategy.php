<?php

/**
 * This file is part of the Tracy (https://tracy.nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Tracy;

use ErrorException;


/**
 * @internal
 */
final class DevelopmentStrategy
{
	/** @var Bar */
	private $bar;

	/** @var BlueScreen */
	private $blueScreen;

	/** @var DeferredContent */
	private $defer;


	public function __construct(Bar $bar, BlueScreen $blueScreen, DeferredContent $defer)
	{
		$this->bar = $bar;
		$this->blueScreen = $blueScreen;
		$this->defer = $defer;
	}


	public function initialize(): void
	{
	}


	public function handleException(\Throwable $exception, bool $firstTime): void
	{
		if (Helpers::isAjax() && $this->defer->isAvailable()) {
			$this->blueScreen->renderToAjax($exception, $this->defer);

		} elseif ($firstTime && Helpers::isHtmlMode()) {
			$this->blueScreen->render($exception);

		} else {
			Debugger::fireLog($exception);
			$this->renderExceptionCli($exception);
		}
	}


	private function renderExceptionCli(\Throwable $exception): void
	{
		try {
			$logFile = Debugger::log($exception, Debugger::EXCEPTION);
		} catch (\Throwable $e) {
			echo "$exception\nTracy is unable to log error: {$e->getMessage()}\n";
			return;
		}

		if ($logFile && !headers_sent()) {
			header("X-Tracy-Error-Log: $logFile", false);
		}

		if (Helpers::detectColors()) {
			echo "\n\n" . $this->blueScreen->highlightPhpCli($exception->getFile(), $exception->getLine()) . "\n";
		}

		echo "$exception\n" . ($logFile ? "\n(stored in $logFile)\n" : '');
		if ($logFile && Debugger::$browser) {
			exec(Debugger::$browser . ' ' . escapeshellarg(strtr($logFile, Debugger::$editorMapping)));
		}
	}


	public function handleError(
		int $severity,
		string $message,
		string $file,
		int $line,
		array $context = null
	): void {
		if (function_exists('ini_set')) {
			$oldDisplay = ini_set('display_errors', '1');
		}

		if (
			(is_bool(Debugger::$strictMode) ? Debugger::$strictMode : (Debugger::$strictMode & $severity)) // $strictMode
			&& !isset($_GET['_tracy_skip_error'])
		) {
			$e = new ErrorException($message, 0, $severity, $file, $line);
			$e->context = $context;
			$e->skippable = true;
			Debugger::exceptionHandler($e);
			exit(255);
		}

		$message = 'PHP ' . Helpers::errorTypeToString($severity) . ': ' . Helpers::improveError($message, (array) $context);
		$count = &$this->bar->getPanel('Tracy:errors')->data["$file|$line|$message"];

		if (!$count++) { // not repeated error
			Debugger::fireLog(new ErrorException($message, 0, $severity, $file, $line));
			if (!Helpers::isHtmlMode() && !Helpers::isAjax()) {
				echo "\n$message in $file on line $line\n";
			}
		}

		if (function_exists('ini_set')) {
			ini_set('display_errors', $oldDisplay);
		}
	}


	public function sendAssets(): bool
	{
		return $this->defer->sendAssets();
	}


	public function renderLoader(): void
	{
		$this->bar->renderLoader($this->defer);
	}


	public function renderBar(): void
	{
		if (function_exists('ini_set')) {
			ini_set('display_errors', '1');
		}

		if (preg_match('#^Content-Length:#im', implode("\n", headers_list()))) {
			Debugger::log(new \LogicException('Tracy cannot display the Bar because the Content-Length header is being sent'), Debugger::EXCEPTION);
		}

		$this->bar->render($this->defer);
	}
}
