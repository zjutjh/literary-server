<?php
/**
 * 响应json数据
 * @param  integer    $code
 * @param  mixed  $data
 * @param  string   $error
 * @return \Symfony\Component\HttpFoundation\Response
 */
function RJM($code, $data = null, $error = '')
{
    return response([
        'code' => $code,
        'error' => $error,
        'data' => $data
    ]);
}

/**
 * 使用CURL的POST请求资源
 * @param  string   $url        资源路径
 * @param  array    $post_data  请求参数
 * @param  int      $timeout    超时时间，毫秒级
 * @return mixed
 */
function http_post($url, $post_data = null, $timeout = 500, $type = 'default'){//curl
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt ($ch, CURLOPT_TIMEOUT_MS, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, false);
    if($post_data){
        if ($type === 'json') {
            $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($post_data))
            );
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    $file_contents = curl_exec($ch);
    curl_close($ch);
    if (env('APP_DEBUG') === true) {
        logger(json_encode([
            'url' => $url,
            'data' => $post_data,
            'result' => $file_contents
        ]));
    }
    return $file_contents;
}
/**
 * 使用CURL的GET请求资源
 * @param  string   $url        资源路径
 * @param  array    $post_data  请求参数
 * @param  int      $timeout    超时时间，毫秒级
 * @return mixed
 */
function http_get($url, $data = null, $timeout = 10000){//curl
    $ch = curl_init();
    if($data){
        if(strpos($url, '?') == false) {
            $url .= '?';
        } else {
            $url .= '&';
        }
        $url .= http_build_query($data);
    }
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt ($ch, CURLOPT_TIMEOUT_MS, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    if (env('APP_DEBUG') === true) {
        logger(json_encode([
            'url' => $url,
            'data' => $data,
            'result' => $file_contents
        ]));
    }
    return $file_contents;
}