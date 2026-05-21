<?php

namespace App\Model;

class Image
{
    public ?int $id=null;
    public string $directory;
    public string $filename;

    public function __construct(string $directory, string $filename) {
        $this->directory = $directory;
        $this->filename = $filename;
    }

}