<?php

namespace App\Controllers;

use App\Entities\Post;
use App\Services\PostService;
use Doctrine\DBAL\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\Exceptions\NotFoundException;
use Queendev\PhpFramework\Http\RedirectResponse;
use Queendev\PhpFramework\Http\Response;

class PostsController extends AbstractController
{
    public function __construct(
        private PostService $service
    )
    {
    }

    /**
     * @param int $id
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws Exception
     */
    public function view(int $id): Response
    {
        try {
            $post = $this->service->findOrFail($id);
        } catch (NotFoundException $e) {
            return $this->render('error', [
                'message' => $e->getMessage()
            ]);
        }

        return $this->render('/post/post', [
            'post' => $post
        ]);
    }

    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(): Response
    {
        return $this->render('/post/post-create');
    }


    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(): Response
    {
        $post = Post::create(
            $this->request->getPostData()['title'],
            $this->request->getPostData()['content']
        );

        try {
            $post = $this->service->save($post);
            $this->session->setFlash('success', 'Post created');
        } catch (\Throwable $e) {
            return $this->render('error', [
                'message' => $e->getMessage()
            ]);
        }

        return new RedirectResponse("/posts/{$post->getId()}");
    }

    /**
     * @throws Exception
     */
    public function all()
    {
        $posts = $this->service->findAll();

        return $this->render('/post/all-posts', [
            'posts' => $posts
        ]);
    }
}