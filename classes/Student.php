<?php

use Carbon\Carbon;

class Student
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private array $subscriptions = [];
    private array $attendances = [];

    public function __construct(int $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function subscribeToCourse(Course $course): void
    {
        foreach ($this->subscriptions as $existingCourse) {
            if ($existingCourse->getId() === $course->getId()) {
                return;
            }
        }
        $this->subscriptions[] = $course;
    }

    public function subscribeToCourses(Course ...$courses): void
    {
        foreach ($courses as $course) {
            $this->subscribeToCourse($course);
        }
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function getCourseById($courseId): ?Course
    {
        foreach ($this->subscriptions as $course) {
            if ($course->getId() === $courseId) {
                return $course;
            }
        }
        return null;
    }

    public function isSubscribedToCourse(int $courseID): bool
    {
        return in_array($courseID, $this->subscriptions);
    }

    public function getSubscriptionsInfo(): void
    {
        foreach ($this->subscriptions as $course) {
            echo $course->getInfo();
        }
    }

    public function addAttendance($attendance): void
    {
        $this->attendances[] = $attendance;
    }

    public function getAttendanceEntryTime($lessonId): ?Carbon{
        foreach($this->attendances as $attendance){
            if($attendance->getLessonId() === $lessonId){
                return $attendance->getEntryTime();
            }
        }
        return null;
    }

    public function getAttendanceExitTime($lessonId): ?Carbon{
        foreach($this->attendances as $attendance){
            if($attendance->getLessonId() === $lessonId){
                return $attendance->getExitTime();
            }
        }
        return null;
    }


    public function getTpForLesson(int $lessonId): float
    {
        $targetLesson = null;
        foreach ($this->subscriptions as $course) {
            foreach ($course->getLessons() as $lesson) {
                if ($lesson->getId() === $lessonId) {
                    $targetLesson = $lesson;
                    break 2;
                }
            }
        }

        if (!$targetLesson) {
            return 0.0;
        }

        $attendance = null;
        foreach ($this->attendances as $att) {
            if ($att->getLessonId() === $lessonId) {
                $attendance = $att;
                break;
            }
        }

        if (!$attendance) {
            return 0.0;
        }

        $lessonStart = $targetLesson->getStartTime();
        $lessonEnd = $targetLesson->getEndTime();
        $totalLessonDuration = $lessonStart->diffInMinutes($lessonEnd);

        $studentEntry = $attendance->getEntryTime();
        $studentExit = $attendance->getExitTime();

        $effectiveStart = $studentEntry->gt($lessonStart) ? $studentEntry : $lessonStart;
        $effectiveEnd = $studentExit->lt($lessonEnd) ? $studentExit : $lessonEnd;

        if ($effectiveStart->gte($effectiveEnd)) {
            return 0.0;
        }

        $attendanceDuration = $effectiveStart->diffInMinutes($effectiveEnd);

        return $totalLessonDuration > 0 ?
            ($attendanceDuration / $totalLessonDuration) * 100 : 0.0;
    }

    public function getAverageTpForCourse(int $courseId): float
    {
        $course = $this->getCourseById($courseId);
        if (!$course) return 0.0;

        $totalTp = 0.0;
        $lessons = $course->getLessons();

        foreach ($lessons as $lesson) {
            $totalTp += $this->getTpForLesson($lesson->getId());
        }

        return count($lessons) > 0 ? $totalTp / count($lessons) : 0.0;
    }

}
