<?php

namespace App\Services;

use App\Exceptions\BizException;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Cast\Object_;

class WeixinService extends BaseService {
    
    public static $tokenCacheKey = "weixinToken:Health";

    public function getToken() {
        $cacheValue = Cache::get(static::$tokenCacheKey);
        if (empty($cacheValue)) {
            $this->refreshToken();
        }

        return Cache::get(static::$tokenCacheKey);
    }

    public function codeToSession($code)
    {
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/sns/jscode2session";
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request("GET", $url, [
            'query' => [
                'appid' => env('NIUNIU_APID'),
                'secret' => env('NIUNIU_SECRET'),
                'js_code' => $code,
                'grant_type' => 'authorization_code',
            ]
        ]);
        $res = json_decode($response->getBody());
        if (empty($res) || $res['code'] != 0) {
            throw new BizException("微信登录校验失败" . ($res['message'] ?? ''));
        }
        return $res;
    }

    public function refreshToken() {
        $url = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s", env("HEALTH_APPID"), env("HEALTH_SECRET"));
        $data = json_decode(file_get_contents($url), true);
        if (isset($data['errcode'])) {
            throw new BizException("weixin Error", 1);
        }
        $token = $data['access_token'];
        $expire = $data['expires_in'];
        Cache::put(static::$tokenCacheKey, $token, now()->addSeconds($expire));
    }

    public function getCollectionList() {
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/tcb/databasecollectionget?access_token=".$token;
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'env' => 'health-5gas3qkl5b12b364',
                'limit' => 20,
                'offset' => 0,
            ]
        ]);
        return json_decode($response->getBody());
    }

    public function addRecord($table, $data) {
        $data = sprintf('db.collection("%s").add({data:%s})', $table, json_encode($data));
        $data = $this->parseSql($data);

        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/tcb/databaseadd?access_token=".$token;
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'env' => 'health-5gas3qkl5b12b364',
                'query' => $data,
            ]
        ]);
        return json_decode($response->getBody());
    }

    public function updateRecord($table, $where, $data) {
        $data = sprintf('db.collection("%s").where(%s).update(%s)', $table, json_encode((Object)$where), json_encode((Object)$data));
        $data = $this->parseSql($data);

        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/tcb/databaseupdate?access_token=".$token;
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'env' => 'health-5gas3qkl5b12b364',
                'query' => $data,
            ]
        ]);
        return json_decode($response->getBody());
    }

    public function listRecord($table, $where, $page, $pageSize) {
        $offset = max(0, ($page-1)*$pageSize);
        $data = sprintf('db.collection("%s").where(%s).limit(%d).skip(%d).get()', $table, json_encode((Object)$where), $pageSize, $offset);
        $data = addslashes($data);

        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/tcb/databasequery?access_token=".$token;
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'env' => 'health-5gas3qkl5b12b364',
                'query' => $data,
            ]
        ]);
        return json_decode($response->getBody());
    }

    public function removeRecord($table, $where) {
        $data = sprintf('db.collection("%s").where(%s).remove()', $table, json_encode((Object)$where));
        $data = addslashes($data);

        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/tcb/databasedelete?access_token=".$token;
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'env' => 'health-5gas3qkl5b12b364',
                'query' => $data,
            ]
        ]);
        return json_decode($response->getBody());
    }

    private function parseSql($sql) {
        $data = addslashes($sql);
        $data = str_replace('\"db.serverDate()\"', "db.serverDate()", $data);
        return $data;
    }
}