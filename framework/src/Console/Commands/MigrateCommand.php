<?php

namespace Queendev\PhpFramework\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Types\Types;
use Queendev\PhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    const MIGRATIONS_TABLE_NAME = 'migrations';
    private string $name = 'migrate';

    public function __construct(
        private Connection $connection
    )
    {
    }

    /**
     * @throws SchemaException
     * @throws Exception
     */
    public function execute(array $parameters = []): int
    {
        try {
            $this->createMigrationsTable();

            $this->connection->beginTransaction();

            // TODO: Execute migrations

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }

        return 0; // TODO: Change status code if needed
    }

    /**
     * @throws SchemaException
     * @throws Exception
     */
    private function createMigrationsTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist([self::MIGRATIONS_TABLE_NAME])) {
            $schema = new Schema();

            $table = $schema->createTable(self::MIGRATIONS_TABLE_NAME);
            $table->addColumn('id', Types::INTEGER, [
                'autoincrement' => true,
                'unsigned' => true
            ]);
            $table->addColumn('migration', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
                'default' => 'CURRENT_TIMESTAMP'
            ]);

            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());
            $this->connection->executeQuery(implode(';', $sqlArray));

            echo 'Migrations table created.' . PHP_EOL;
        }
    }
}