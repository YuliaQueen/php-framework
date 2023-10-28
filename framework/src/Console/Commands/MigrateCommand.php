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
        private Connection $connection,
        private string     $migrationsPath
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
            $this->connection->setAutoCommit(false);

            $this->createMigrationsTable();

            $this->connection->beginTransaction();

            $appliedMigrations = $this->getAppliedMigrations();

            $migrationFiles = $this->getMigrationFiles();

            $migrationToApply = array_values(array_diff($migrationFiles, $appliedMigrations));

            $schema = new Schema();

            foreach ($migrationToApply as $migration) {
                $migrationInstance = require $this->migrationsPath . '/' . $migration;

                $migrationInstance->up($schema);

                $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

                foreach ($sqlArray as $sql) {
                    $this->connection->executeQuery($sql);
                }

                $this->addMigration($migration);
            }

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }

        $this->connection->setAutoCommit(true);

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


    /**
     * @return array
     * @throws Exception
     */
    private function getAppliedMigrations(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder->select('migration')->from(self::MIGRATIONS_TABLE_NAME)
            ->executeQuery()
            ->fetchFirstColumn();
    }

    /**
     * @return array
     */
    private function getMigrationFiles(): array
    {
        $files = array_filter(scandir($this->migrationsPath), fn($file) => $file !== '.' && $file !== '..');

        return array_values($files);
    }

    /**
     * @param string $name
     * @return void
     * @throws Exception
     */
    private function addMigration(string $name): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert(self::MIGRATIONS_TABLE_NAME)->values(['migration' => ':migration'])
            ->setParameter('migration', $name)
            ->executeQuery();
    }
}