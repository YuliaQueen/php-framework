<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class {
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', Types::BIGINT, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('name', Types::STRING, ['length' => 255]);
        $table->addColumn('email', Types::STRING, ['notnull' => true, 'length' => 255]);
        $table->addColumn('password', Types::STRING, ['notnull' => true, 'length' => 60]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);

        $table->setPrimaryKey(['id']);
    }
};