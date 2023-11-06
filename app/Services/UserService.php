<?php

namespace App\Services;

use App\Entities\User;
use Doctrine\DBAL\Exception;

class UserService extends AbstractService
{
    /**
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function save(User $user): User
    {
        $this->queryBuilder->insert('users')
            ->values([
                'name' => ':name',
                'email' => ':email',
                'password' => ':password',
                'created_at' => ':created_at'
            ])
            ->setParameters([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')
            ])
            ->executeQuery();

        $user->setId($this->db->lastInsertId());

        return $user;
    }
}