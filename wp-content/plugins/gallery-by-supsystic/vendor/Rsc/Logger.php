<?php


class Rsc_Logger implements Rsc_Logger_Interface
{

    /**
     * @var string
     */
    protected $path;

    /**
     * Constructor
     *
     * @param string $path
     */
    public function __construct($path = null)
    {
        $this->path = $path;
    }

    /**
     * Sets the path to the log files.
     *
     * @param string $path Path to the log files
     * @return Rsc_Logger
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Returns the path to the log files.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        $this->log('alert', $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        $this->log('critical', $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        $this->log('error', $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        $this->log('warning', $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        $this->log('notice', $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        $this->log('info', $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        $this->log('debug', $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @throws Rsc_Logger_Exception_InvalidPathException If path is does not exists or does not writable
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        if (!$this->path) {
            return;
        }

        if (!is_dir($this->path) || !is_writable($this->path)) {
            return;
        }

        $this->write($level, $this->interpolate($message, $context));
    }

    /**
     * Write to the log file
     * @param string $level
     * @param string $message
     */
    protected function write($level, $message)
    {
        $filename = $this->path . '/' . date('Y-m-d') . '.log';
        $message = date('[H:i:s]') . ' [' . $level . '] ' . $message . PHP_EOL;

        @file_put_contents($filename, $message, FILE_APPEND);
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @param string $message
     * @param array $context
     * @return string
     */
    protected function interpolate($message, $context)
    {
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }
}