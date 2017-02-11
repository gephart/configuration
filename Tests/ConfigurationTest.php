<?php

require_once __DIR__ . '/../vendor/autoload.php';

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigration()
    {
        $configuration = new \Gephart\Configuration\Configuration();
        $configuration->setDirectory(__DIR__ . "/config");
        $test_configuration = $configuration->get("test");

        $this->assertEquals("value22", $test_configuration["key2"]["key22"]);
    }
}
