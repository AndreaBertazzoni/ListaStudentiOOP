<?php
require_once "vendor/autoload.php";
use Carbon\Carbon;

class Course {
    private int $id;
    private string $name;
    private array $lessons;
    private int $enrolled;

    public function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
        $this->lessons = [];
        $this->enrolled = 0;
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

    public function addLessons(Lesson ...$lessons){
        foreach($lessons as $lesson){
            $this->addLesson($lesson);
        }
    }

        public function getLessons(): array{
        return $this->lessons;
    }

    public function addEnrolled(): void 
    {
        $this->enrolled ++;
    }

    public function getEnrolled(): int 
    {
        return $this->enrolled;
    }

    public function getStartDate(): Carbon{
        $dates = [];
        foreach($this->lessons as $lesson){
            $dates[] = $lesson->getDate();
        }
        return min($dates);
    }

    public function getEndDate(): Carbon{
        $dates = [];
        foreach($this->lessons as $lesson){
            $dates[] = $lesson->getDate();
        }
        return max($dates);
    }

    public function getStatus(): string
    {
        $now = Carbon::now();
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        if($now->lt($startDate)){
            return "In attesa di inizio";
        }elseif($now->gt($endDate)){
            return "Concluso";
        }else {
            return "In corso"; 
        }
    }

    public function getMaxAttendance(): int 
    {
        $result = 0;
        foreach($this->lessons as $lesson){
            if($lesson->getAttendances() > $result){
                $result = $lesson->getAttendances();
            }
        }
        return $result;
    }

    public function getMostAttendedLessons(): array 
    {
        $target = $this->getMaxAttendance();
        $mostAttendedLessons = [];
        foreach($this->lessons as $lesson){
            if($lesson->getAttendances() >= $target){
                $mostAttendedLessons[] = $lesson;
            }
        }
        return $mostAttendedLessons;
    }
}