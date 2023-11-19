<?php

namespace App\Services;

use Doctrine\DBAL\Query\QueryBuilder;
use Queendev\PhpFramework\Dbal\EntityService;

abstract class AbstractService
{
    public function __construct(
        protected EntityService $entityService,
        protected QueryBuilder  $queryBuilder
    )
    {
        $this->queryBuilder = $this->entityService->getConnection()->createQueryBuilder();
    }
}