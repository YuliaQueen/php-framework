<?php

namespace App\Services;

use App\Entities\Post;
use Doctrine\DBAL\Exception;
use Queendev\PhpFramework\Http\Exceptions\NotFoundException;

class PostService extends AbstractService
{
    /**
     * @param Post $post
     * @return Post
     * @throws Exception
     */
    public function save(Post $post): Post
    {
        $this->queryBuilder->insert('posts')
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

        $id = $this->entityService->save($post);
        $post->setId($id);

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
        $queryBuilder = $this->queryBuilder;

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
            title: $post['title'],
            content: $post['content'],
            id: $post['id'],
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
     * @throws Exception
     * @throws \Exception
     */
    public function findAll()
    {
        $result = $this->queryBuilder
            ->select('*')
            ->from('posts')
            ->orderBy('created_at', 'DESC')
            ->setMaxResults(10)
            ->executeQuery()
            ->fetchAllAssociative();

        $posts = [];
        foreach ($result as $post) {
            $posts[] = Post::create(
                title: $post['title'],
                content: $post['content'],
                id: $post['id'],
                createdAt: new \DateTimeImmutable($post['created_at']),
            );
        }

        return $posts;
    }
}