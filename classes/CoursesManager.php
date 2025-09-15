<?php

require_once "vendor/autoload.php";

use Carbon\Carbon;

class CoursesManager
{
    private array $courses = [];
    private array $students = [];

    public function __construct(array $courses = [], array $students = [])
    {
        $this->courses = $courses;
        $this->students = $students;
    }

    public function addCourse(Course $course): void
    {
        foreach ($this->courses as $existingCourse) {
            if ($existingCourse->getId() === $course->getId()) {
                return;
            }
        }
        $this->courses[] = $course;
    }

    public function getCourses(): array
    {
        return $this->courses;
    }

    public function addCourses(Course ...$courses)
    {
        foreach ($courses as $course) {
            $this->addCourse($course);
        }
    }

    public function addStudent(Student $student): void
    {
        foreach ($this->students as $existingStudent) {
            if ($existingStudent->getId() === $student->getId()) {
                return;
            }
        }
        $this->students[] = $student;
    }

    public function addStudents(Student ...$students)
    {
        foreach ($students as $student) {
            $this->addStudent($student);
        }
    }

    public function getStudents(): array
    {
        return $this->students;
    }

    public function setAttendances(): void
    {
        foreach ($this->students as $student) {
            foreach ($student->getSubscriptions() as $course) {
                foreach ($course->getLessons() as $lesson) {
                    if ($student->getTpForLesson($lesson->getId())) {
                        $lesson->addAttendance();
                    }
                }
            }
        }
    }

    public function getCourseTotalAttendances(Course $course): int
    {
        $result = 0;
        $lessons = $course->getLessons();
        foreach ($lessons as $lesson) {
            $result += $lesson->getAttendances();
        }
        return $result;
    }

    public function getCourseMaxAttendeces(Course $course, array $students): int
    {
        $maxAttendances = 0;

        foreach ($students as $student) {
            if ($student->isSubscribedToCourse($course->getId())) {
                $maxPossibleAttendances = $student->getCourseAttendances($course);
                if ($maxPossibleAttendances > $maxAttendances) {
                    $maxAttendances = $maxPossibleAttendances;
                }
            }
        }
        return $maxAttendances;
    }

    public function getCourseMostAttendedStudent(Course $course, array $students): array
    {
        $result = [];
        $maxAttendances = $this->getCourseMaxAttendeces($course, $students);

        foreach ($students as $student) {
            if ($student->isSubscribedToCourse($course->getId())) {
                $attendances = $student->getCourseAttendances($course);
                if ($attendances >= $maxAttendances) {
                    $result[] = $student;
                }
            }
        }
        return $result;
    }

    public function getLessonsMaxAttendaces(Course $course): int
    {
        $maxAttendances = 0;
        $lessons = $course->getLessons();
        foreach ($lessons as $lesson) {
            $maxPossibleAttendances = $lesson->getAttendances();
            if ($maxPossibleAttendances > $maxAttendances) {
                $maxAttendances = $maxPossibleAttendances;
            }
        }

        return $maxAttendances;
    }

    public function getMostAttendedLessons(Course $course): array
    {
        $maxAttendances = $this->getLessonsMaxAttendaces($course);
        $result = [];

        $lessons = $course->getLessons();
        foreach ($lessons as $lesson) {
            if ($lesson->getAttendances() === $maxAttendances) {
                $result[] = $lesson;
            }
        }
        return $result;
    }

    public function getCourseOverallTp(Course $course, array $students): float
    {
        $overallTp = 0.0;
        $enrolledCount = 0;

        foreach ($students as $student) {
            if ($student->isSubscribedToCourse($course->getId())) {
                $overallTp += $student->getAverageTpForCourse($course->getId());
                $enrolledCount++;
            }
        }

        if ($enrolledCount === 0) {
            return 0.0;
        }

        return round($overallTp / $enrolledCount, 1);
    }
}
