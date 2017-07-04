<?php

/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 29.06.17
 * Time: 11:19
 */
namespace Cron;


abstract  class Scheduler
{
	/**
	 * Идентификатор текущего процесса
	 * @var int
	 */
	protected $pid;
	
	/**
	 * Задержка (в секундах) в конце "лупа"
	 * @var int
	 */
	protected $loopDelay;
	
	/**
	 * В режиме "Дебага" есть некоторая отладочная информация по запуску процессов
	 * @var bool
	 */
	protected $isDebug;
	
	public function __construct(array $options = array()) {
		$this->pid              = posix_getpid();
		$this->loopDelay        = isset($options['loop_delay']) ? (int) $options['loop_delay'] : 1;
		$this->isDebug          =  (isset($options['debug']) && $options['debug']);
		
		ini_set('error_reporting', -1);
	}
	
	protected function debugMessage($message) {
		if ($this->isDebug) {
			echo (
				is_array($message) ?
					print_r($message, true) :
					implode(' ', array($this->pid, trim($message)))
				) . PHP_EOL;
		}
	}
	
	protected static function isIterable($var) {
		return (is_array($var) || $var instanceof \Traversable);
	}
	
	/**
	 * Функция возвращающая массив или итератор
	 * на каждой итерации выдающая один элемент данных для обработки,
	 */
	abstract protected function provider();
	
	/**
	 * Метод в котором необходимо реализовать логику обработки одного элемента данных,
	 * который должен передаваться как единственный аргумент
	 *
	 * @param $item - единица обрабатываемых данных
	 * @return mixed
	 */
	abstract protected function handler(&$item);
	
	/**
	 * Главный цикл, в котором вызывается обработчик (метод _handler) для каждого элемента данных
	 *
	 * @throws \Exception
	 */
	final protected function loop() {
		if (!self::isIterable($this->provider())) {
			throw new \Exception('Property "_provider" must be an iterable!');
		}
		$this->debugMessage('- LOOP -');
		//declare (ticks = 1);
		foreach ($this->provider() as $item) {
			$this->handler($item);
		}
		
		if ($this->loopDelay > 0) {
			$this->debugMessage('- LOOP_DELAY -');
			sleep($this->loopDelay);
		}
	}
	
	
	/**
	 * @throws \Exception
	 */
	public function foreverLoop()
	{
		while(true)
		{
			$this->loop();
			sleep(1);
		}
	}
	
	
}