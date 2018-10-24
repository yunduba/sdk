<?php
/**
 * Created by QQ39818148.
 * User: mac-39818148
 * Date: 2018/10/24
 * Time: 下午5:00
 */

namespace yunduba\SDK;

class Grab{
    /**
     * 取得Grab实例
     * @static
     * @return mixed 返回Grab
     */
    public static function getInstance($type)
    {
        $name = ucfirst(strtolower($type)) . 'SDK';
        $class_name = __NAMESPACE__.'\\GrabSDK\\'.$name;
        if (class_exists($class_name)) {
            return new $class_name;
        } else {
            throw new \think\Exception('CLASS_NOT_EXIST:' . $name, 100002);
        }
    }
}
