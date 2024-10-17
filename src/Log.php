<?php

class Log {

    public static function write($txt)
    {
        $datetime = date('Y-m-d h:i:s');
        $txt = $datetime . ': ' . $txt . "\r\n";
        $logFilePath = dirname(__FILE__) . '/../logs/log_' . date("Y-m-d") . '.log';
        // $logFilePath = dirname(__FILE__) . '/../../../storage/logs/lumen-' . date("Y-m-d") . '.log';
        file_put_contents($logFilePath, $txt, FILE_APPEND);
        // var_dump($logFilePath);
        // exit;
    }

}