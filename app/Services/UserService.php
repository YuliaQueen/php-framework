<?php

namespace App\Services;

use App\Entities\User;
use Doctrine\DBAL\Exception;
use Queendev\PhpFramework\Authentication\AuthUserInterface;
use Queendev\PhpFramework\Authentication\UserServiceInterface;

class UserService extends AbstractService implements UserServiceInterface
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

        $id = $this->entityService->save($user);
        $user->setId($id);

        return $user;
    }

    /**
     * @param string $email
     * @return AuthUserInterface|null
     * @throws \Exception
     */
    public function findByEmail(string $email): ?AuthUserInterface
    {
        $query = $this->queryBuilder
            ->select('*')
            ->from('users')
            ->where('email = :email')
            ->setParameter('email', $email)
            ->executeQuery();

        $user = $query->fetchAssociative();

        if (empty($user)) {
            return null;
        }

        return User::create(
            email:     $user['email'],
            password:  $user['password'],
            name:      $user['name'],
            createdAt: new \DateTimeImmutable($user['created_at']),
            id:        $user['id']
        );
    }
}