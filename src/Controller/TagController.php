<?php

namespace App\Controller;

use App\Http\SuperGlobalManager;
use App\Model\Question;
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

            if ($name === '') {
                echo $this->blade->run("question_form", $this->getData($question, 'Cannot add empty tag'));
                exit;
            }

            $name = ucfirst($name);

            $existingTag = $this->tagRepository->findByName($name);

            if (!empty($existingTag)) {
                echo $this->blade->run("question_form", $this->getData($question, 'Tag already exists!'));
                exit;
            }

            $tag = new Tag($name);
            $tagId = $this->tagRepository->save($tag);
        }

        $existingRelation = $this->questionTagRelationRepository->findByQuestionIdAndTagId($questionId,$tagId);
        if (!empty($existingRelation)) {
            echo $this->blade->run("question_form", $this->getData($question, 'Tag already added to this question!'));
            exit;
        }

        $questionTagRelation = new QuestionTagRelation($questionId, $tagId);
        $this->questionTagRelationRepository->save($questionTagRelation);

        echo $this->blade->run("question_form", $this->getData($question));
    }

    private function getData($question, string $errorMessage = null): array
    {
        return [
            'question' => $question,
            'questionTags' => $this->questionTagRelationRepository->findByQuestionId($question->id),
            'tags' => $this->tagRepository->findAll(),
            'error' => $errorMessage ?? null,
        ];
    }

}