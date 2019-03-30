<?php
namespace App\Http\Services;

class JHService {
    static public function login($username, $password) {
        if (!$username OR !$password) {
            throw new Exception('用户名或密码为空');
        }
        if (strstr($password, '../') != false) {
            throw new Exception('密码不允许带../');
        }
        $url = 'http://user.jh.zjut.edu.cn/api.php';
        $data = [
            'app' => 'passport',
            'action' => 'login',
            'passport' => $username,
            'password' => $password,
        ];
        if(!$content = http_get($url, $data)) {
            throw new Exception('用户中心服务器错误');
        }
        if(!$value = json_decode($content, true)) {
            throw new Exception('用户中心服务器错误');
        }
        if(isset($value['state']) && $value['state'] == 'success') {
            return true;
        } else {
            throw new Exception('用户名或密码错误');
        }
    }
}