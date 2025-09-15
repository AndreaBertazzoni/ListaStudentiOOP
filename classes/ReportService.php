<?php

use Carbon\Carbon;

class ReportService
{
    private CoursesManager $coursesManager;

    public function __construct(CoursesManager $coursesManager)
    {
        $this->coursesManager = $coursesManager;
        $this->coursesManager->setAttendances();
    }

    public function collectStudentReportData(Student $student): array
    {
        $studentReportData = [
            "student_name" => $student->getFullName(),
            "courses" => []
        ];

        $courses = $student->getSubscriptions();
        foreach ($courses as $course) {
            $courseData = [
                "course_name" => $course->getName(),
                "lessons" => [],
                "average_tp" => round($student->getAverageTpForCourse($course->getId()), 1)
            ];

            $lessons = $course->getLessons();
            foreach ($lessons as $lesson) {
                $studentEntry = $student->getAttendanceEntryTime($lesson->getId());
                $studentExit = $student->getAttendanceExitTime($lesson->getId());

                $courseData["lessons"][] = [
                    "number" => $lesson->getNumber(),
                    "title" => $lesson->getTitle(),
                    "date" => $lesson->getDate(),
                    "start_time" => $lesson->getStartTime(),
                    "end_time" => $lesson->getEndTime(),
                    "student_entry" => $studentEntry ? $studentEntry : null,
                    "student_exit" => $studentExit ? $studentExit : null,
                    "student_tp" => round($student->getTpForLesson($lesson->getId()), 1)
                ];
            }
            $studentReportData["courses"][] = $courseData;
        }
        return $studentReportData;
    }

    public function collectStudentsReportData(array $students): array
    {
        $studentsReportData = [];
        foreach ($students as $student) {
            $studentsReportData[] = $this->collectStudentReportData($student);
        }
        return $studentsReportData;
    }

    public function collectStudentCourseData(Student $student): array
    {
        $studentCourseData = [
            "student_name" => $student->getFullName(),
            "courses" => [],
            "average_tp" => round($student->getAverageTpForCourses($student->getSubscriptions()), 1),
        ];


        $courses = $student->getSubscriptions();
        foreach ($courses as $course) {
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

    public function collectStudentsCoursesData(array $students): array
    {
        $studentdsCoursesData = [];
        foreach ($students as $student) {
            $studentdsCoursesData[] = $this->collectStudentCourseData($student);
        }
        return $studentdsCoursesData;
    }

    public function collectCourseReportData(Course $course): array
    {
        $courseReportData = [
            "name" => $course->getName(),
            "start_date" => $course->getStartDate(),
            "end_date" => $course->getEndDate(),
            "status" => $this->getStatus($course),
        ];
        return $courseReportData;
    }

    public function collectCoursesReportData(array $courses): array
    {
        $coursesReportData = [];
        foreach ($courses as $course) {
            $coursesReportData[] = $this->collectCourseReportData($course);
        }
        return $coursesReportData;
    }


    public function collectCourseDetails(Course $course): array
    {
        $averageTp = $this->coursesManager->getCourseOverallTp($course, $this->coursesManager->getStudents());
        $mostAttStud = $this->coursesManager->getCourseMostAttendedStudent($course, $this->coursesManager->getStudents());
        $tpStatus = $this->getParticipationLevel($averageTp);
        $mostAttDays = $this->coursesManager->getMostAttendedLessons($course);
        $totalAtt = $this->coursesManager->getCourseTotalAttendances($course);

        $courseDetails = [
            "name" => $course->getName(),
            "lessons" => [],
            "enrolled" => $course->getEnrolled(),
            "average_tp" => $averageTp,
            "tp_status" => $tpStatus,
            "most_attended_students" => $mostAttStud,
            "most_attended_days" => $mostAttDays,
            "total_attendances" => $totalAtt,
        ];
        $lessons = $course->getLessons();
        foreach ($lessons as $lesson) {
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
                if ($student->isSubscribedToCourse($course->getId())) {

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
        foreach ($courses as $course) {
            $coursesDetailsData[] = $this->collectCourseDetails($course);
        }
        return $coursesDetailsData;
    }

    public function getStatus(Course $course): string
    {
        $now = Carbon::now();
        $startDate = $course->getStartDate();
        $endDate = $course->getEndDate();

        if ($now->lt($startDate)) {
            return "In attesa di inizio";
        } elseif ($now->gt($endDate)) {
            return "Concluso";
        } else {
            return "In corso";
        }
    }

    function getParticipationLevel($averageTp)
    {
        $levels = [
            25 => "Scarsa",
            50 => "Moderata",
            75 => "Buona",
            101 => "Ottima"
        ];

        foreach ($levels as $threshold => $level) {
            if ($averageTp < $threshold) {
                return $level;
            }
        }

        return "Ottima";
    }
}
