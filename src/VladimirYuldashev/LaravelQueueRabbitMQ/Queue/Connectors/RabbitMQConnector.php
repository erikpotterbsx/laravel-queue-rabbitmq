<?php

namespace VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors;

use Illuminate\Queue\Connectors\ConnectorInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\RabbitMQQueue;

class RabbitMQConnector implements ConnectorInterface
{

	/**
	 * Establish a queue connection.
	 *
	 * @param  array $config
	 *
	 * @return \Illuminate\Contracts\Queue\Queue
	 */
	public function connect(array $config)
	{
        // Detect AMQPS connections
        if (substr($config['host'], 0, 4) == 'amqps') or if ($config['ssl'] = true) {
            $connection = new AMQPSSLConnection($config['host'], $config['port'], $config['login'], $config['password'], $config['vhost'], $config['ssl_options']);
        }

		// create connection with AMQP
        $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['login'], $config['password'], $config['vhost']);

		return new RabbitMQQueue(
			$connection,
			$config
		);
	}

}
