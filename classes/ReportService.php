<?php

class ReportService{
    private CoursesManager $coursesManager;

    public function __construct(CoursesManager $coursesManager){
        $this->coursesManager = $coursesManager;
        $this->coursesManager->setAttendances();
    }
    
    public function collectStudentReportData(Student $student): array {
        $studentReportData = [
            "student_name" => $student->getFullName(),
            "courses" => []
        ];

        $courses = $student->getSubscriptions();
        foreach($courses as $course){
            $courseData = [
                "course_name" => $course->getName(),
                "lessons" => [],
                "average_tp" => round($student->getAverageTpForCourse($course->getId()), 1)
            ];
            
            $lessons = $course->getLessons();
            foreach($lessons as $lesson){
                $studentEntry = $student->getAttendanceEntryTime($lesson->getId());
                $studentExit = $student->getAttendanceExitTime($lesson->getId());

                $courseData["lessons"][] = [
                    "number" => $lesson->getNumber(),
                    "title" => $lesson->getTitle(),
                    "date" => $lesson->getDate()->format("d/m/Y"),
                    "start_time" => $lesson->getStartTime()->format("H:i"),
                    "end_time" => $lesson->getEndTime()->format("H:i"),
                    "student_entry" => $studentEntry ? $studentEntry->format("H:i") : null,
                    "student_exit" => $studentExit ? $studentExit->format("H:i") : null,
                    "student_tp" => round($student->getTpForLesson($lesson->getId()), 1)
                ];
            }
        $studentReportData["courses"][] = $courseData;
        }
        return $studentReportData;
    }

    public function collectStudentsReportData(array $students): array {
        $studentsReportData = [];
        foreach($students as $student){
            $studentsReportData[] = $this->collectStudentReportData($student);
        }
        return $studentsReportData;
    }

    public function collectStudentCourseData(Student $student): array{
        $studentCourseData = [
            "student_name" => $student->getFullName(),
            "courses" => [],
            "average_tp" => round($student->getAverageTpForCourses($student->getSubscriptions()), 1),
        ];
        

        $courses = $student->getSubscriptions();
        foreach($courses as $course){
            $courseData = [
                "course_name" => $course->getName(),
                "lesson_number" => count($course->getLessons()),
                "student_presence" => $student->getAttendancesForCourse($course->getId()),
                "always_present" => $student->isAlwaysPresent($course->getId()),
                "course_tp" => round($student->getAverageTpForCourse($course->getId()), 1),
            ];
            $studentCourseData["courses"][] = $courseData;
        }
        return $studentCourseData;
    }
    
    public function collectStudentsCoursesData(array $students): array {
        $studentdsCoursesData = [];
        foreach($students as $student){
            $studentdsCoursesData[] = $this->collectStudentCourseData($student);
        }
        return $studentdsCoursesData;
    }

    public function collectCourseReportData(Course $course): array {
        $courseReportData = [
            "name" => $course->getName(),
            "start_date" => $course->getStartDate()->format("d/m/Y"),
            "end_date" => $course->getEndDate()->format("d/m/Y"),
            "status" => $course->getStatus()
        ];
        return $courseReportData;
    }  

    public function collectCoursesReportData(array $courses): array {
        $coursesReportData = [];
        foreach($courses as $course){
            $coursesReportData[] = $this->collectCourseReportData($course);
        }
        return $coursesReportData;
    }
    

    public function collectCourseDetails(Course $course): array 
    {
        $courseDetails = [
            "name" => $course->getName(),
            "lessons" => [],
            "enrolled" => $course->getEnrolled(),
            "average_tp" => $this->coursesManager->getCourseOverallTp($course, $this->coursesManager->getStudents()),
        ];
        $lessons = $course->getLessons();
        foreach($lessons as $lesson){
            $lessonDetails = [
                "lesson_name" => $lesson->getTitle(),
                "lesson_date" => $lesson->getDate(),
                "lesson_start" => $lesson->getStartTime(),
                "lesson_end" => $lesson->getEndTime(),
                "attendances" => $lesson->getAttendances(),
                "absents" => ($course->getEnrolled() - $lesson->getAttendances()),
                "lessons_tp" => [],
            ];
            $students = $this->coursesManager->getStudents();
            foreach ($students as $student) {
                if($student->isSubscribedToCourse($course->getId())){

                    $lessonDetails["lessons_tp"][$student->getFullName()] = $student->getTpForLesson($lesson->getId());
                }
        }

        $courseDetails["lessons"][] = $lessonDetails;
        }

        return $courseDetails;
    }

    public function collectCoursesDetails(array $courses): array 
    {
        $coursesDetailsData = [];
        foreach($courses as $course){
            $coursesDetailsData[] = $this->collectCourseDetails($course);
        }
        return $coursesDetailsData;
    }
}