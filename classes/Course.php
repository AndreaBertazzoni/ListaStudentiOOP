<?php


class Course {
    private int $id;
    private string $name;
    private array $lessons = [];

    public function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }
    
    public function getId() : int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function addLesson(Lesson $lesson) : void{
        $lesson->setCourseId($this->id);
        $this->lessons[] = $lesson;
    }
}