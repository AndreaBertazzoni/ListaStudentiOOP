<?php
require_once "vendor/autoload.php";
use Carbon\Carbon;

class Attendance{
    private int $lessonId;
    private Carbon $date;
    private Carbon $entryTime;
    private Carbon $exitTime;

    public function __construct(int $lessonId, Carbon $date, Carbon $entryTime, Carbon $exitTime){
        $this->lessonId = $lessonId;
        $this->date = $date;
        $this->entryTime = $entryTime;
        $this->exitTime = $exitTime;
    }

    public function getLessonId(): int{
        return $this->lessonId;
    }

    public function getDate(): Carbon{
        return $this->date;
    }

    public function getEntryTime(): Carbon{
        return $this->entryTime;
    }

    public function getExitTime(): Carbon{
        return $this->exitTime;
    }

}