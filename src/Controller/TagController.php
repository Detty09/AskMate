<?php

namespace App\Controller;

use App\Repository\TagRepository;
use eftec\bladeone\BladeOne;

class TagController
{

    private BladeOne $blade;
    private TagRepository $tagRepository;

    public function __construct(BladeOne $blade, TagRepository $tagRepository) {
        $this->blade = $blade;
        $this->tagRepository = $tagRepository;
    }

    public function index(): void {
        $data = $this->tagRepository->findAll();
        $tags = [];

        foreach ($data as $tag) {
            $tags[] = [
                'id' => $tag['id'],
                'name' => $tag['name'],
                'questions' => $tag['questions']
            ];
        }

        echo $this->blade->run('tags', ['tags' => $tags]);

    }
}