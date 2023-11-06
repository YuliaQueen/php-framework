<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class AbstractService
{
    public function __construct(
        protected Connection   $db,
        protected QueryBuilder $queryBuilder
    )
    {
        $this->queryBuilder = $this->db->createQueryBuilder();
    }
}