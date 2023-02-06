- composer update

#### 后台安装
- php artisan admin:publish
- php artisan admin:install

#### jwt
- php artisan jwt:secret

#### 钉钉推送机器人
- php artisan vendor:publish --provider="DingNotice\DingNoticeServiceProvider"

#### Telescope
- php artisan telescope:install
- php artisan migrate

####  Hashids
- composer require vinkla/hashids
- php artisan vendor:publish --provider="Vinkla\Hashids\HashidsServiceProvider" 

####  错误提示
- 10001    前无代理商,非法请求,请从代理商处获取链接
- 10002    
