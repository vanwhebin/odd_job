<?php
/**
 * Created by PhpStorm.
 * User: Jourdon
 * Date: 2018/10/24
 * Time: 14:01
 */


//加法
function add($numb1, $numb2, $scale = 2)
{
    return bcadd($numb1, $numb2, $scale);
}

//减法
function sub($numb1, $numb2, $scale = 2)
{
    return bcsub($numb1, $numb2, $scale);
}

//乘法
function mul($numb1, $numb2, $scale = 2)
{
    return bcmul($numb1, $numb2, $scale);
}

//除法
function div($numb1, $numb2, $scale = 2)
{
    return bcdiv($numb1, $numb2, $scale);
}

//求余
function mod($numb1, $numb2, $scale = 0)
{
    return bcmod($numb1, $numb2, $scale);
}

//次方
function square($numb1, $numb2, $scale = 0)
{
    return bcpow($numb1, $numb2, $scale);
}

//保留两位小数
function toPrice($data, $num = 3)
{
    return substr(sprintf("%." . $num . "f", $data), 0, -1);
}

//去除小数点最后的0 如有小数点后面都是0，小数点也一并去除
function _rtrim($num = 0)
{
    $num = str_replace(',', '', number_format($num, 8));
    return preg_replace('/[.]$/', '', preg_replace('/0+$/', '', $num));
}

//修改.env配置代码块
function modifyEnv(array $data)
{
    $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';
    $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));
    $contentArray->transform(function ($item) use ($data) {
        foreach ($data as $key => $value) {
            if (Str::before($item, '=') == Str::upper($key)) {
                return Str::upper($key) . '=' . $value;
            }
        }
        return $item;
    });
    $content = implode("\n", $contentArray->toArray());

    \File::put($envPath, $content);
}

//翻译
function translate($text, $to = 'en')
{
    // 实例化 HTTP 客户端
    $http = new GuzzleHttp\Client();;

// 初始化配置信息
    $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
    $appid = config('services.baidu_translate.appid');
    $key = config('services.baidu_translate.key');
    $salt = time();

    $sign = md5($appid . $text . $salt . $key);

// 构建请求参数
    $query = http_build_query([
        "q" => $text,
        "from" => "zh",
        "to" => $to,
        "appid" => $appid,
        "salt" => $salt,
        "sign" => $sign,
    ]);

// 发送 HTTP Get 请求
    $response = $http->get($api . $query);

    $result = json_decode($response->getBody(), true);
    if (empty($result['trans_result'])) {
        return '';
    }
    // 尝试获取获取翻译结果
    return collect($result['trans_result'])->pluck(['dst'])->implode("\r\n");
}

//百度获取地址信息
function getBDLocation($log, $lat)
{
    $url = config('services.map.geocoding');    //API服务地址
    $ak = config('services.map.ak');    //key

    $http = new \GuzzleHttp\Client();
    // 初始化配置信息
    $response = $http->request('GET', $url, [
        'query' => [
            'ak' => $ak,
            'coordtype' => 'gcj02ll',
            'location' => $lat . ',' . $log,//经纬度
            'output' => 'json',
            'language_auto' => 1,
        ]
    ]);
    $result = json_decode($response->getBody(), true);
    if ($result['status'] != 0) {
        return [];
    }
    return [
        'longitude' => $result['result']['location']['lng'],
        'latitude' => $result['result']['location']['lat'],
        'address' => $result['result']['formatted_address'],
        'province' => $result['result']['addressComponent']['province'],
        'city' => $result['result']['addressComponent']['city'],
        'district' => $result['result']['addressComponent']['district'],
        'street' => $result['result']['addressComponent']['street'],
        'number' => $result['result']['addressComponent']['street_number'],
        'direction' => $result['result']['addressComponent']['direction'],
        'distance' => $result['result']['addressComponent']['distance'],
    ];
}


//高德获取地理信息
function getLocation($log, $lat)
{
    $url = config('services.amap.geocode');    //API服务地址
    $ak = config('services.amap.ak');    //key

    $http = new \GuzzleHttp\Client();
    // 初始化配置信息
    $response = $http->request('GET', $url, [
        'query' => [
            'key' => $ak,
            'location' => $log . ',' . $lat,//经纬度
        ]
    ]);
    $result = json_decode($response->getBody(), true);
    if ($result['status'] != 1 || empty($result['regeocode']['addressComponent'])) {
        return [];
    }
    if (!empty($result['regeocode']['addressComponent']['streetNumber']['location'])) {
        $location = explode(',', $result['regeocode']['addressComponent']['streetNumber']['location']);
        $log = $location[0];
        $lat = $location[1];
    }

    return [
        'longitude' => $log,
        'latitude' => $lat,
        'address' => $result['regeocode']['formatted_address'],
        'province' => $result['regeocode']['addressComponent']['province'],
        'city' => $result['regeocode']['addressComponent']['city'] ?: '',
        'area' => $result['regeocode']['addressComponent']['district'] ?: '',
        'area_id' => $result['regeocode']['addressComponent']['adcode'] ?? '',
    ];
}

//百度坐标系（GCJ-02) 获取地址信息
function BDipToLocation($ip)
{
    $url = config('services.map.ip_url');    //API服务地址
    $ak = config('services.map.ak');    //key

    $http = new \GuzzleHttp\Client();
    // 初始化配置信息
    $response = $http->request('GET', $url, [
        'query' => [
            'ak' => $ak,
            'coor' => 'gcj02',
            'ip' => $ip,//经纬度
        ]
    ]);
    $result = json_decode($response->getBody(), true);
    if ($result['status'] != 0) {
        return [];
    }
    return [
        'longitude' => $result['content']['point']['x'],
        'latitude' => $result['content']['point']['y'],
        'address' => $result['content']['address'],
        'province' => $result['content']['address_detail']['province'],
        'city' => $result['content']['address_detail']['city'],
        'area' => $result['content']['address_detail']['district'],
        'area_id' => $result['content']['address_detail']['adcode']??'',
    ];
}

// 高德IP获取地址信息
function ipToLocation($ip)
{
    $url = config('services.amap.ip_url');    //API服务地址
    $ak = config('services.amap.ak');    //key

    $http = new \GuzzleHttp\Client();
    // 初始化配置信息

    $response = $http->request('GET', $url, [
        'query' => [
            'key' => $ak,
            'ip' => $ip,//经纬度
        ]
    ]);
    $result = json_decode($response->getBody(), true);
    if ($result['status'] != 0) {
        return [];
    }
    return [
        'longitude' => $result['content']['point']['x'],
        'latitude' => $result['content']['point']['y'],
        'address' => $result['content']['address'],
    ];
}

//高德获取地理信息
function addressToLocation($address, $code = '')
{
    $url = config('services.amap.geo');    //API服务地址
    $ak = config('services.amap.ak');    //key

    $http = new \GuzzleHttp\Client();
    // 初始化配置信息
    $response = $http->request('GET', $url, [
        'query' => [
            'key' => $ak,
            'address' => $address,//经纬度
            'city' => $code,//adcode 城市编码表
        ]
    ]);
    $result = json_decode($response->getBody(), true);
    if ($result['status'] != 1 || $result['count'] < 1 || empty($result['geocodes'][0]['location'])) {
        return [];
    }
    $location = explode(',', $result['geocodes'][0]['location']);
    return [
        'longitude' => $location[0],
        'latitude' => $location[1],
    ];
}

/**
 * 计算两个坐标之间的距离(km)
 * @param float $fP1Lat 起点(纬度)
 * @param float $fP1Lon 起点(经度)
 * @param float $fP2Lat 终点(纬度)
 * @param float $fP2Lon 终点(经度)
 * @return int
 **/
function getDistance($longitude1, $latitude1, $longitude2, $latitude2)
{

    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI / 180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    $distance = $distance / 1000;
    return round($distance, 2);
}


//驾车路线规划
function getRoutePlanning($longitude1, $latitude1, $longitude2, $latitude2)
{
    $url = config('services.amap.driving');    //API服务地址
    $ak = config('services.amap.ak');    //key

    $http = new \GuzzleHttp\Client();
    // 初始化配置信息

    $response = $http->request('GET', $url, [
        'query' => [
            'key' => $ak,
            'origin' => $longitude1.','.$latitude1,//经纬度
            'destination' => $longitude2.','.$latitude2,//经纬度
        ]
    ]);
    $result = json_decode($response->getBody(), true);
    dd($result);
    if ($result['status'] != 0) {
        return [];
    }
    return [
        'longitude' => $result['content']['point']['x'],
        'latitude' => $result['content']['point']['y'],
        'address' => $result['content']['address'],
    ];
}

//生成商城小程序码
function createQRcode($filename, $dir, $scene, $page)
{
    //判断二维码文件是否存在，
    if (!\Storage::exists($dir . '/' . $filename)) {
        $app = app('wechat.mini_program.default');
        $response = $app->app_code->getUnlimit($scene, [
            'page' => $page,
            'width' => 300,
        ]);
        //临时目录
        $directory = storage_path('app/public/' . $dir);
        // 保存小程序码到文件
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $response->saveAs($directory, $filename);
        } else {
            if (app()->environment('production')) {
                return [
                    'err_msg' => '小程序码生成失败，请稍候再试',
                    'url' => '',

                ];
            } else {
                return [
                    'url' => config('app.default_mall_qr'),
                    'err_msg' => ''
                ];
            }
        }
    }
    //拿到二维码的 url
    $url = asset(\Storage::url($dir . '/' . $filename));
    //5分钟后删除文件
    dispatch(new \App\Jobs\DeleteFile($dir . '/' . $filename));
    return [
        'url' => $url,
        'err_msg' => ''
    ];
}
