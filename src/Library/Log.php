<?php
/**
 * 日志。
 * 
 * @author fingerQin
 * @date 2019-08-01
 */

namespace phpservices\Library;

class Log
{
    /**
     * 当前对象实例。
     *
     * @var phpservices\Library\Log
     */
    private static $_instance;

    /**
     * 日志内容。
     * 
     * -- 因为日志会存放多个目录下的文件里面。所以，用数组来区分不同目录与文件。
     *
     * @var array
     */
    private $logCtx = [];

    private function __construct() {}

    /**
     * 防止克隆导致单例失败。
     * 
     * @return void
     */
    private function __clone() {}

    /**
     * 获取当前对象实例。
     * 
     * @return phpservices\Library\Log
     */
    public static function getInstance()
    {
        if(!(self::$_instance instanceof self)) {    
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 写日志(只是暂存,不会直接写入)。
     *
     * @param  string  $log           日志内容。
     * @param  string  $logPath       日志保存路径。
     * @param  bool    $isForceWrite  是否强制写入硬盘。默认值：false。设置为 true 则日志立即写入硬盘而不是等待析构函数回收再执行。
     *
     * @return void
     */
    public function write($log, $logPath, $isForceWrite = false)
    {
        if (PHP_SAPI == 'cli' || $isForceWrite) { // Cli 模式立即写入硬盘。
            file_put_contents($logPath, $log, FILE_APPEND);
        } else {
            $arrLogKey = md5($logPath);
            if (isset($this->logCtx[$arrLogKey])) {
                $this->logCtx[$arrLogKey]['log'] = $this->logCtx[$arrLogKey]['log'] . $log;
            } else {
                $this->logCtx[$arrLogKey] = [
                    'logPath' => $logPath,
                    'log'     => $log
                ];
            }
        }
    }

    /**
     * 对象销毁时写入日志到文件。
     */
    public function __destruct()
    {
        // [1]
        $openedFileHandle = []; // 保存已经打开的文件句柄。
        foreach($this->logCtx as $key => $logObj) {
            if (isset($openedFileHandle[$key])) { // 已打开了文件，则直接写入。
                fwrite($openedFileHandle[$key], $logObj['logPath']);
            } else {
                \Utils\YDir::create(dirname($logObj['logPath']));
                $handle = fopen($logObj['logPath'], 'a');
                $openedFileHandle[$key] = $handle;
                fwrite($handle, $logObj['log']);
            }
        }
        // [2] 关闭已打开的文件句柄。
        foreach($openedFileHandle as $hd) {
            fclose($hd);
        }
    }
}