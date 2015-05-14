<?php

class ConnectionTest extends PHPUnit_Framework_Testcase
{
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $mock;

    /** @var Mib\Component\Database\Connection */
    private $connection;

    /**
     * Setup the system under test
     */
    public function setUp()
    {
        /** @var Mib\Component\Database\Driver\Connection $mock */
        $mock = $this->getMock('Mib\Component\Database\Driver\Connection', array(), array(), '', false, false);

        $this->connection = new \Mib\Component\Database\Connection($mock);

        $this->mock = $mock;
    }

    public function tearDown()
    {
        unset($this->connection);
        unset($this->mock);
    }

    public function testPrepareCallPrepareOnConnection()
    {
        $query = "SHOW TABLES";

        $this->mock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo($query));

        $this->connection->prepare($query);
    }

    public function testQueryCallQueryOnConnection()
    {
        $query = "SHOW TABLES";

        $this->mock->expects($this->once())
            ->method('query')
            ->with($this->equalTo($query));

        $this->connection->query($query);
    }

    public function testQueryCallExecOnConnection()
    {
        $query = "SHOW TABLES";

        $this->mock->expects($this->once())
            ->method('exec')
            ->with($this->equalTo($query));

        $this->connection->exec($query);
    }


}