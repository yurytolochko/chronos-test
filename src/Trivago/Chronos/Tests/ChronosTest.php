<?php

namespace Trivago\Chronos\Tests;

use Trivago\Chronos\Chronos;

class ChronosTest extends \PHPUnit_Framework_TestCase
{
    protected $host = '192.168.1.51:4400';

    public function testGetJobs()
    {
        $client = new Chronos($this->host);
        var_dump($client->getJobs());
    }
} 