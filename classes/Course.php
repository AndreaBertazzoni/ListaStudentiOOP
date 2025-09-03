<?php
require_once "vendor/autoload.php";
use Carbon\Carbon;

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

    public function addLessons(Lesson ...$lessons){
        foreach($lessons as $lesson){
            $this->addLesson($lesson);
        }
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

    public function getStatus(): string{
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

    public function getLessons(): array{
        return $this->lessons;
    }

    public function getInfo(): string{
        return "Titolo corso: " . $this->getName() . "<br>" . 
        "Data inizio: " . $this->getStartDate()->format("d/m/Y") . "<br>" . 
        "Data fine: " . $this->getEndDate()->format("d/m/Y") . "<br>" .
        "Stato: " . $this->getStatus() . "<br><br>";
        
    }
}