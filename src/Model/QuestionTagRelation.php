<?php

namespace App\Model;

class QuestionTagRelation
{
    private int $questionId;
    private int $tagId;

    public function __construct(int $questionId, int $tagId) {
        $this->questionId = $questionId;
        $this->tagId = $tagId;
    }

    public function getQuestionId(): int {
        return $this->questionId;
    }

    public function getTagId(): int {
        return $this->tagId;
    }
}