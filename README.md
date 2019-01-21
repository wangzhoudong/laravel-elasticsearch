# laravel-elasticsearch

### 介绍
为 [Laravel Scout](https://laravel-china.org/docs/laravel/5.5/scout/1346) 
开发的 [Elasticsearch](https://baijunyao.com/article/155) 驱动；  

为了方便大家测试，搭建了一个带分词的elasticsearch docker

```
 docker run --name=es -p 9200:9200 -p 9300:9300 -d dongen/elasticsearch:latest
```

### 安装

```
composer require wangzd/laravel-elasticsearch
```


2. Laravel 5.5 以下，`config/app.php`  中添加 `service provider`
```php
'providers' => [

    // ...

    /**
     * Elasticsearch全文搜索
     */
    Wangzd\ScoutES\ESServiceProvider::class,
],
```
3.发布配置项;  

```
```bash
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
```
4. 在 config/scout.php 添加配置

    ```
         'elasticsearch' => [
                'hosts' => [
                    env('ELASTICSEARCH_HOST', 'http://localhost'),
                ],
                'analyzer' => env('ELASTICSEARCH_ANALYZER', 'ik_max_word'),
                'settings' => [],
                'filter' => [
                ]
            ],
    ```

增加配置项；  
.env ;
    ```bash
    
    SCOUT_DRIVER=elasticsearch
    SCOUT_PREFIX=local
    #elasticsearch
    
    ELASTICSEARCH_HOST=127.0.0.1:9200
    ELASTICSEARCH_INDEX=shop_test

    ```
      
5 在你的Model里面引用  Searchable   如
   ```
   namespace App\Models;
   
   use Illuminate\Database\Eloquent\Model;
   use Laravel\Scout\Searchable;
   
   class ShopSearchModel extends Model
   {
       use Searchable;
       /**
        * 数据表名
        */
       protected $table = "shop_search";
   
       /**
        * 主键
        */
       protected $primaryKey = "goods_id";
   }
   
   ```    
 
6. 执行全量索引创建 该操作会自动创建阿里云APP
  ``` 
    php artisan scout:import "App\Models\ShopSearchModel"
 
  ``` 
7.执行搜索

```php
use App\Models\ShopSearchModel;
    
    Route::get('search', function () {
        // 为查看方便都转成数组
        dump(ShopSearchModel::search('搜索关键字')->get()->toArray());
    });
```
