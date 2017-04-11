<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 11/04/2017
 * Time: 2:58 PM
 */
if (! function_exists('user')){
    /**
     * @param null $driver
     * @return mixed
     */
    function user($driver = null){
        if ($driver){
            return app('auth')->guard('api')->user();
        }
        return app('auth')->user();
    }
}