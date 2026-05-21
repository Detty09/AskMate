<?php

namespace App\Controller;

use App\Http\SuperGlobalManager;
use App\Repository\QuestionRepository;
use App\Repository\QuestionTagRelationRepository;
use App\Repository\TagRepository;
use eftec\bladeone\BladeOne;

class QuestionTagRelationController
{
    private BladeOne $blade;
    private QuestionTagRelationRepository $questionTagRelationRepository;
    private QuestionRepository $questionRepository;
    private TagRepository $tagRepository;

    public function __construct(BladeOne $blade, QuestionTagRelationRepository $questionTagRelationRepository, QuestionRepository $questionRepository, TagRepository $tagRepository) {
        $this->blade = $blade;
        $this->questionTagRelationRepository = $questionTagRelationRepository;
        $this->questionRepository = $questionRepository;
        $this->tagRepository = $tagRepository;
    }

    public function destroy() {
        $questionId = SuperGlobalManager::getRequest('id_question');
        $tagId = SuperGlobalManager::getRequest('id_tag');

        $this->questionTagRelationRepository->deleteByQuestionAndTagId($questionId, $tagId);

        $data = [
            'question' => $this->questionRepository->find($questionId),
            'questionTags' => $this->questionTagRelationRepository->findByQuestionId($questionId),
            'tags' => $this->tagRepository->findAll(),
            'error' => $error ?? null,
        ];

        header('Location: /edit-question?id='.$questionId);
        echo $this->blade->run("question_form", $data);

    }

}