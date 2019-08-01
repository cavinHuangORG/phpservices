<?php
/**
 * URL 相关封装。
 * @author fingerQin
 * @date 2019-08-01
 */

namespace phpservices\Utils;

class YUrl
{
    /**
     * 获取当前页面完整URL地址。
     * 
     * @return string
     */
    public static function getUrl()
    {
        $sysProtocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $phpSelf     = $_SERVER['PHP_SELF'] ? YString::safe_replace($_SERVER['PHP_SELF']) : YString::safe_replace($_SERVER['SCRIPT_NAME']);
        $pathinfo    = isset($_SERVER['PATH_INFO']) ? YString::safe_replace($_SERVER['PATH_INFO']) : '';
        $relateUrl   = isset($_SERVER['REQUEST_URI']) ? YString::safe_replace($_SERVER['REQUEST_URI']) : $phpSelf . (isset($_SERVER['QUERY_STRING']) ? '?' . YString::safe_replace($_SERVER['QUERY_STRING']) : $pathinfo);
        return $sysProtocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relateUrl;
    }

    /**
     * 获取当前域名。
     *
     * @param  bool $isFullFormat 是否完整格式。完整格式是带 http:// 或 https://
     * @return string
     */
    public static function getDomainName($isFullFormat = true)
    {
        $sysProtocal = '';
        if ($isFullFormat) {
            $sysProtocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        }
        return $sysProtocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    }
}