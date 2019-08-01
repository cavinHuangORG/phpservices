<?php
/**
 * 基于主流 PHP 框架的 Session 操作兼容封装。
 * @author fingerQin
 * @date 2019-08-01
 */

namespace phpservices\Library;

class Session
{
    /**
     * 设置。
     *
     * @param  string        $Key    名称。
     * @param  string|array  $value  值。
     *
     * @return bool
     */
    public static function set($key, $value)
    {
    }

    /**
     * 读取 SESSION。
     *
     * @param  string  $key  名称。
     * 
     * @return bool
     */
    public static function get($key)
    {
    }

    /**
     * 删除 SESSION。
     *
     * @param  string  $key  名称。
     * @return bool
     */
    public static function delete($key)
    {
    }

    /**
     * 清空 SESSION。
     *
     * @param  string  $key  名称。
     * @return bool
     */
    public static function destroy()
    {
    }
}