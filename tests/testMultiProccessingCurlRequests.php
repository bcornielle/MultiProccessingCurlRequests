<?php
/**
 * Created by PhpStorm.
 * User: elminsondeoleobaez
 * Date: 10/3/18
 * Time: 1:52 PM
 */

namespace Elminson\MultiProccessingCurlRequests;

require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class testMultiProccessingCurlRequests extends TestCase
{

	function testCallTestCase()
	{

		$data = [
			['url' => 'https://www.google.com']
		];
		$call = new MultiProccessingCurlRequests();
		$r = $call->multiRequest($data);
		$result = strip_tags($r[0]);
		$this->assertEquals("Google", substr($result, 0, 6));
	}

	function testCallJsonTestCase()
	{

		$data = [
			['url' => 'https://jsonplaceholder.typicode.com/todos/1'],
			['url' => 'https://jsonplaceholder.typicode.com/users']
		];
		$call = new MultiProccessingCurlRequests();
		$call->setIsJson(true);
		$r = $call->multiRequest($data);
		$this->assertEquals("1", $r[0]['userId']);
		$this->assertEquals("1", $r[1][0]['id']);

	}

	function testSendJsonTestCase()
	{

		$payloadArray = array("name" => "John", "phone" => "555-555-5555");
		$data = [
			['url' => 'https://jsonplaceholder.typicode.com/todos/1', 'payload' => json_encode($payloadArray)],
			['url' => 'https://jsonplaceholder.typicode.com/users', 'payload' => json_encode($payloadArray)]
		];
		$call = new MultiProccessingCurlRequests();
		$call->setIsJson(true);
		$r = $call->multiRequest($data);
		$this->assertEquals("1", $r[0]['userId']);
		$this->assertEquals("1", $r[1][0]['id']);

	}

	function testCallAndSendJsonTestCase()
	{

		$payloadArray = array("name" => "John", "phone" => "555-555-5555");
		$data = [
			['url' => 'https://jsonplaceholder.typicode.com/todos/1', 'payload' => json_encode($payloadArray)],
			['url' => 'https://jsonplaceholder.typicode.com/users', 'payload' => json_encode($payloadArray)],
			['url' => 'https://jsonplaceholder.typicode.com/todos/1', 'post' => $payloadArray],
			['url' => 'https://jsonplaceholder.typicode.com/users', 'post' => $payloadArray]
		];
		$call = new MultiProccessingCurlRequests();
		$call->setIsJson(true);
		$r = $call->multiRequest($data);
		$this->assertEquals("1", $r[0]['userId']);
		$this->assertEquals("1", $r[1][0]['id']);

	}

}
