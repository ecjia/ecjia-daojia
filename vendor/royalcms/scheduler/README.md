# Royalcms Scheduler 
PHP基于yiled实现的并行RPC调度器

### 适用场景 ###

同时请求多个Api，而且响应时间比较长，并行化调用是个很好的方案。

### 版本要求 ###

PHP >= 5.6.0

CURL扩展

## 使用示例 ##

### 并行化调用 ###

```php
use Royalcms\Component\Scheduler\Scheduler;
use Royalcms\Component\Scheduler\Curl;

$time = microtime(true);

$scheduler = new Scheduler;
/**
 *  第一个参数接受一个迭代生成器
 *  第二个参数接收一个回调函数，会把请求的内容返回
 */
$scheduler->newTask(Curl::request("http://demo.royalcms.cn/sleep.php"), function($data, Scheduler $scheduler){
	//输出请求返回内容
	var_dump($data);
});//3秒
$scheduler->newTask(Curl::request("http://www.royalcms.cn/"));//0.1秒
$scheduler->newTask(Curl::request("http://www.royalcms.cn/"));//0.1秒
$scheduler->newTask(Curl::request("http://demo.royalcms.cn/sleep.php"));//3秒
$scheduler->newTask(Curl::request("http://demo.royalcms.cn/sleep.php"));//3秒
//运行
$scheduler->run();

//输出运行时间
echo "run time:".bcsub(microtime(true),$time,2); //3.1秒
```
上面的请求并行化调用耗时在3.1秒左右，下面我们看看串行化调用

### 串行化调用 ###

```php
use Royalcms\Component\Scheduler\Scheduler;
use Royalcms\Component\Scheduler\Curl;

$time = microtime(true);

//平常的串行调用
$curl = new Curl();
$result = $curl->callWebServer("http://demo.royalcms.cn/sleep.php"); //3秒
var_dump($result);
$curl->callWebServer("http://www.royalcms.cn/"); //0.1秒
$curl->callWebServer("http://www.royalcms.cn/"); //0.1秒
$curl->callWebServer("http://demo.royalcms.cn/sleep.php"); //3秒
$curl->callWebServer("http://demo.royalcms.cn/sleep.php"); //3秒

//输出运行时间
echo "run time:".bcsub(microtime(true),$time,2); //9.3秒
```

一共耗时9.3秒，可见对于响应时间较长的接口并行化调用带来的提升是巨大的

### 并行化同时加入生成器 ###

```php
use Royalcms\Component\Scheduler\Scheduler;
use Royalcms\Component\Scheduler\Curl;

$time = microtime(true);

$scheduler = new Scheduler;
/**
 *  第一个参数接受一个迭代生成器
 *  第二个参数接收一个回调函数，会把请求的内容返回
 */
$scheduler->newTask(Curl::request("http://demo.royalcms.cn/sleep.php"), function($data, Scheduler $scheduler){
	//输出请求返回内容
	var_dump($data);
});
$scheduler->newTask(Curl::request("http://www.royalcms.cn/"));
$scheduler->newTask(Curl::request("http://www.royalcms.cn/"));
$scheduler->newTask(Curl::request("http://demo.royalcms.cn/sleep.php"));
//加入2个生成器
$scheduler->newTask(generator());
$scheduler->newTask(generator());
//运行
$scheduler->run();

//输出运行时间
echo "run time:".bcsub(microtime(true), $time, 2); //3.4秒

/**
 *	生成器:执行完需要1秒
 */
function generator(){
	for ($i=0; $i < 10; $i++) {
		//这里可以是业务逻辑，假设每次需要0.1秒
		usleep(100000);
		yield;
	}
}
```

加入2个需要运行1秒的生成器后运行时间是3.4秒，比之前多了0.3秒，相当于节省了1.7秒时间。




