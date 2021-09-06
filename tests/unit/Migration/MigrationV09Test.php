<?php

namespace Appwrite\Tests;

use ReflectionClass;
use Appwrite\Database\Database;
use Appwrite\Database\Document;
use Appwrite\Migration\Version\V09;

class MigrationV09Test extends MigrationTest
{
    public function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->migration = new V09($this->pdo);
        $reflector = new ReflectionClass('Appwrite\Migration\Version\V09');
        $this->method = $reflector->getMethod('fixDocument');
        $this->method->setAccessible(true);
    }

    public function testMigration()
    {
        $document = $this->fixDocument(new Document([
            '$id' => 'project',
            '$collection' => Database::SYSTEM_COLLECTION_PROJECTS,
            'version' => '0.9.0'
        ]));

        $this->assertEquals($document->getAttribute('version', '0.9.0'), '0.10.0');
    }
}