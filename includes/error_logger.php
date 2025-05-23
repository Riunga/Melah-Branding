<?php
class ErrorLogger {
    private static $logFile = 'logs/error.log';
    
    public static function log($message, $type = 'ERROR') {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$type] $message" . PHP_EOL;
        
        if (!file_exists(dirname(self::$logFile))) {
            mkdir(dirname(self::$logFile), 0777, true);
        }
        
        error_log($logMessage, 3, self::$logFile);
    }
}