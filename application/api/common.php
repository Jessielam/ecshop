<?php
//api 模块公共函数

/**
 * 返回显示信息
 * @param int $status
 * @param string @message
 * @param array $data
 */
function show($status, $message='' , $data=[]) {
    return [
        'status' => intval($status),
        'message' => $message,
        'data' => $data,
    ];
} 