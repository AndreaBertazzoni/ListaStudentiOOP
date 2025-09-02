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

    public function addCourses(Course ...$courses){
        foreach($courses as $course){
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

    public function getCoursesInfo(): void
    {
        foreach ($this->courses as $course) {
            echo $course->getInfo();
        }
    }
}
