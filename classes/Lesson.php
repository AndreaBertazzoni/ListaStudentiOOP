<?php

require_once "vendor/autoload.php";
use Carbon\Carbon;

class Lesson {
    private int $id;
    private int $number;
    private string $title;
    private Carbon $date;
    private Carbon $startTime;
    private Carbon $endTime;
    private int $courseId;
    private int $attendances;

    public function __construct(int $id, int $number, string $title, Carbon $date, Carbon $startTime, Carbon $endTime) 
    {
        $this->id = $id;
        $this->number = $number;
        $this->title = $title;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->attendances = 0;
    }

    public function getId(): int {
        return $this->id;
    }
    
    public function getNumber(): int {
        return $this->number;
    }
    
    public function getTitle(): string {
        return $this->title;
    }
    
    public function getDate(): Carbon {
        return $this->date;
    }
    
    public function getStartTime(): Carbon {
        return $this->startTime;
    }
    
    public function getEndTime(): Carbon {
        return $this->endTime;
    }
    
    public function setCourseId(int $courseId): void {
        $this->courseId = $courseId;
    }

    public function addAttendance(): void 
    {   
        $this->attendances ++;
    }

    public function getAttendances(): int 
    {
        return $this->attendances;
    }
}