<?php

# Single whisky view.
$app->get('/whiskies/', function ($id) use ($app) {
	$c['config'] = require dirname(__FILE__) . '../config/config.php';

	$config = $c['config'];

	$query_factory = new QueryFactory('mysql');
	$select = $query_factory->newSelect();

	$select->cols( array('id','name','distiller_name') )->from('whiskies')->where( "id = $id");

	// a PDO connection
	try {
	    $pdo = new \PDO($config['db.dsn'], $config['db.username'], $config['db.password']);

		$sth = $pdo->prepare($select->__toString());
		// bind the values and execute
		$sth->execute($select->getBindValues());
		// get the results back as an associative array
		$result = $sth->fetch(\PDO::FETCH_ASSOC);
	} catch (\Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}

    $app->render('home.php', array(
		'title' => 'Hello Slim.',
		'body'  => ['id' => $result['id'], 'name' => $result['name'], 'distillery' => $result['distiller_name'] ]
	));
});
