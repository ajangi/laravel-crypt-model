<?php


namespace LaravelCryptModel\Logger;


use Exception;
use Illuminate\Support\Facades\Log;

class LaravelCryptLogger
{
    private const LOG_PREFIX = 'LaravelCryptModel::Log::';

    /**
     * @param Exception $exception
     */
    public static function makeExceptionLog(Exception $exception)
    {
        Log::error(self::LOG_PREFIX.'Error Message: ' . $exception->getMessage());
        Log::error(self::LOG_PREFIX.'Error File: ' . $exception->getFile());
        Log::error(self::LOG_PREFIX.'Error Line: ' . $exception->getLine());
        Log::error(self::LOG_PREFIX.'Error Trace: ' . $exception->getTraceAsString());
    }
}