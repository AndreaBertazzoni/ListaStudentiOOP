<?php

class ReportService{
    private CoursesManager $coursesManager;

    public function __construct(CoursesManager $coursesManager){
        $this->coursesManager = $coursesManager;
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
                "average_tp" => $student->getAverageTpForCourse($course->getId())
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
                    "student_tp" => $student->getTpForLesson($lesson->getId())
                ];
            }
            
        $studentReportData["courses"][] = $courseData;

        }
        return $studentReportData;
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
    
}