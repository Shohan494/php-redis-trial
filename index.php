<?php
require 'Predis/Autoloader.php';
Predis\Autoloader::register();
// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
    $redis = new Predis\Client();
		$redis->set('foo', 'bar');
		$value = $redis->get('foo');
/*
    $redis = new PredisClient(array(
        "scheme" => "tcp",
        "host" => "127.0.0.1",
        "port" => 6379));
*/
    echo "Successfully connected to Redis\n";
    echo "value = ", $value;

		$redis->set("hello_world", "Hi from php!");
		$value2 = $redis->get("hello_world");
		var_dump($value2);

		echo ($redis->exists("Santa Claus")) ? "true" : "false";

		$redis->set("I 2 love Php!", "Also Redis now!");
		$value3 = $redis->get("I 2 love Php!");
		var_dump($value3);

		$redis->hset("taxi_car", "brand", "Toyota");
		$redis->hset("taxi_car", "model", "Yaris");
		$redis->hset("taxi_car", "license number", "RO-01-PHP");
		$redis->hset("taxi_car", "year of fabrication", 2010);
		$redis->hset("taxi_car", "nr_starts", 0);
		/*
		$redis->hmset("taxi_car", array(
		    "brand" => "Toyota",
		    "model" => "Yaris",
		    "license number" => "RO-01-PHP",
		    "year of fabrication" => 2010,
		    "nr_stats" => 0)
		);
		*/
		echo "License number: " . 
		    $redis->hget("taxi_car", "license number") . "<br>";

		// remove license number
		$redis->hdel("taxi_car", "license number");

		// increment number of starts
		$redis->hincrby("taxi_car", "nr_starts", 1);

		$taxi_car = $redis->hgetall("taxi_car");
		echo "All info about taxi car";
		echo "<pre>";
		var_dump($taxi_car);
		echo "</pre>";

		$list = "PHP Frameworks List";
		$redis->rpush($list, "Symfony 2");
		$redis->rpush($list, "Symfony 1.4");
		$redis->lpush($list, "Zend Framework");

		echo "Number of frameworks in list: " . $redis->llen($list) . "<br>";

		$arList = $redis->lrange($list, 0, -1);
		echo "<pre>";
		print_r($arList);
		echo "</pre>";

		// the last entry in the list
		echo $redis->rpop($list) . "<br>";

		// the first entry in the list
		echo $redis->lpop($list) . "<br>";


		// set the expiration for next week
		$redis->set("expire in 1 week", "I have data for a week");
		$val = $redis->get("expire in 1 week");
		echo $val;
		$redis->expireat("expire in 1 week", strtotime("+1 week"));
		$val2 = $redis->get("expire in 1 week");
		echo $val2;
		$ttl = $redis->ttl("expire in 1 week"); // will be 604800 seconds
		$val3 = $redis->get("expire in 1 week");
		echo $val3;
		echo $ttl;

		// never expires
		$redis->set("never expire", "I want to leave forever!");
		$val4 = $redis->get("never expire");
		echo $val4;
}
catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
}