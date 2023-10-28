<?php

namespace App\Services;

use App\Entities\Post;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Queendev\PhpFramework\Http\Exceptions\NotFoundException;

class PostService
{
    public function __construct(
        private Connection $db
    )
    {
    }

    /**
     * @param Post $post
     * @return Post
     * @throws Exception
     */
    public function save(Post $post): Post
    {
        $queryBuilder = $this->db->createQueryBuilder();

        $queryBuilder->insert('posts')
            ->values([
                'title' => ':title',
                'content' => ':content',
                'created_at' => ':created_at'
            ])
            ->setParameters([
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')])
            ->executeQuery();

        $post->setId($this->db->lastInsertId());

        return $post;
    }


    /**
     * @param int $id
     * @return Post|null
     * @throws Exception
     * @throws \Exception
     */
    public function findById(int $id): ?Post
    {
        $queryBuilder = $this->getQueryBuilder();

        $result = $queryBuilder->select('*')
            ->from('posts')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $post = $result->fetchAssociative();

        if (empty($post)) {
            return null;
        }

        return Post::create(
            title:     $post['title'],
            content:   $post['content'],
            id:        $post['id'],
            createdAt: new \DateTimeImmutable($post['created_at']),
        );
    }

    /**
     * @throws Exception
     * @throws NotFoundException
     */
    public function findOrFail(int $id): ?Post
    {
        $post = $this->findById($id);

        if (is_null($post)) {
            throw new NotFoundException("Post $id not found");
        }

        return $post;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->db->createQueryBuilder();
    }
}