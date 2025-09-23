<?php

namespace App\Controller;

use App\Http\SuperGlobalManager;
use App\Model\QuestionTagRelation;
use App\Model\Tag;
use App\Repository\QuestionRepository;
use App\Repository\QuestionTagRelationRepository;
use App\Repository\TagRepository;
use eftec\bladeone\BladeOne;

class TagController
{

    private BladeOne $blade;
    private TagRepository $tagRepository;
    private QuestionRepository $questionRepository;
    private QuestionTagRelationRepository $questionTagRelationRepository;

    public function __construct(BladeOne $blade, TagRepository $tagRepository, QuestionRepository $questionRepository, QuestionTagRelationRepository $questionTagRelationRepository) {
        $this->blade = $blade;
        $this->tagRepository = $tagRepository;
        $this->questionRepository = $questionRepository;
        $this->questionTagRelationRepository = $questionTagRelationRepository;
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

    public function store(): void {
        $questionId = SuperGlobalManager::getRequest("question-id");
        $question = $this->questionRepository->find($questionId);

        $tagId = SuperGlobalManager::getRequest("tag-id");

        if ($tagId === null) {
            $name = strtolower(SuperGlobalManager::getRequest('tag'));
            $name = ucfirst($name);

            $existingTag = $this->tagRepository->findByName($name);

            if (!empty($existingTag)) {
                SuperGlobalManager::setSession('error', 'Tag already exists!');
                header("Location: /edit-question?id=" . $questionId);
                exit;
            }

            $tag = new Tag($name);
            $tagId = $this->tagRepository->save($tag);
        }

        $existingRelation = $this->questionTagRelationRepository->findByQuestionIdAndTagId($questionId,$tagId);
        if (!empty($existingRelation)) {
            SuperGlobalManager::setSession('error', 'Tag already added to this question!');
            header("Location: /edit-question?id=" . $questionId);
            exit;
        }

        $questionTagRelation = new QuestionTagRelation($questionId, $tagId);
        $this->questionTagRelationRepository->save($questionTagRelation);

        header("Location: /edit-question?id=" . $questionId);
        echo $this->blade->run("question_form", ["question" => $question]);
    }
}