<?php
require 'Predis/Autoloader.php';
Predis\Autoloader::register();
// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
    $client = new Predis\Client();
		$client->set('foo', 'bar');
		$value = $client->get('foo');
/*
    $redis = new PredisClient(array(
        "scheme" => "tcp",
        "host" => "127.0.0.1",
        "port" => 6379));
*/
    echo "Successfully connected to Redis\n";
    echo $value;
}
catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
}