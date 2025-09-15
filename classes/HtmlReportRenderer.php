<?php

class HtmlReportRenderer
{
    private $dateFormat = "d/m/Y";
    private $timeFormat = "H:i";
    private $dateTimeFormat = "d/m/Y H:i";

    public function __construct($dateFormat = null, $timeFormat = null, $dateTimeFormat = null)
    {
        if ($dateFormat !== null) {
            $this->dateFormat = $dateFormat;
        }
        if ($timeFormat !== null) {
            $this->timeFormat = $timeFormat;
        }
        if ($dateTimeFormat !== null) {
            $this->dateTimeFormat = $dateTimeFormat;
        }
    }

    private function formatDate($date)
    {
        if ($date instanceof DateTime || $date instanceof Carbon\Carbon) {
            return $date->format($this->dateFormat);
        }
        return $date;
    }

    private function formatTime($time)
    {
        if ($time instanceof DateTime || $time instanceof Carbon\Carbon) {
            return $time->format($this->timeFormat);
        }
        return $time;
    }

    private function formatDateTime($dateTime)
    {
        if ($dateTime instanceof DateTime || $dateTime instanceof Carbon\Carbon) {
            return $dateTime->format($this->dateTimeFormat);
        }
        return $dateTime;
    }

    public function renderLesson(array $lessonData): string
    {
        $html = "<strong>Titolo lezione: " . htmlspecialchars($lessonData["title"]) . "</strong><br>";
        $html .= "N° lezione: " . htmlspecialchars($lessonData["number"]) . "<br>";
        $html .= "Data lezione: " . $this->formatDate($lessonData["date"]) . "<br>";
        $html .= "Orario di inizio: " . $this->formatTime($lessonData["start_time"]) . "<br>";
        $html .= "Orario di uscita: " . $this->formatTime($lessonData["end_time"]) . "<br>";
        $html .= "Entrata studente: " . ($lessonData["student_entry"] ? $this->formatTime($lessonData["student_entry"]) : "assente") . "<br>";
        $html .= "Uscita studente: " . ($lessonData["student_exit"] ? $this->formatTime($lessonData["student_exit"]) : "assente") . "<br>";
        $html .= "Tasso di partecipazione: " . number_format($lessonData["student_tp"], 1, ",") . "%<br>";
        $html .= "<br>";

        return $html;
    }

    public function renderCourse(array $courseData): string
    {
        $html = "<p style='font-size: 120%;'><strong>Titolo corso: " . htmlspecialchars($courseData["name"]) . "</strong></p>";
        $html .= "Data inizio: " . $this->formatDate($courseData["start_date"]) . "<br>";
        $html .= "Data fine: " . $this->formatDate($courseData["end_date"]) . "<br>";
        $html .= "Stato del corso: " . htmlspecialchars($courseData["status"]) . "<br>";
        $html .= "<br>";

        return $html;
    }

    public function renderCourses(array $coursesData): string
    {
        $html = "";
        foreach ($coursesData as $courseData) {
            $html .= $this->renderCourse($courseData);
        }
        return $html . "<hr>";
    }

    public function renderStudent(array $studentReportData): string
    {
        $html = "<p style='font-size: 120%;'><strong>Studente: " . htmlspecialchars($studentReportData["student_name"]) . "</strong></p>";
        foreach ($studentReportData["courses"] as $course) {
            $html .= "<p style='font-size: 110%;'><strong>Titolo corso: " . htmlspecialchars($course["course_name"]) . "</strong></p>";
            foreach ($course["lessons"] as $lesson) {
                $html .= $this->renderLesson($lesson);
            }
            $html .= "<p><strong>Tasso di partecipazione medio: " . number_format($course["average_tp"], 1, ",") . "%</strong></p><br>";
        }
        return $html . "<hr>";
    }

    public function renderStudents(array $studentsData): string
    {
        $html = "";
        foreach ($studentsData as $studentData) {
            $html .= $this->renderStudent($studentData);
        }
        return $html;
    }

    public function renderStudentCourseReport(array $studentCourseData): string
    {
        $html = "<p style='font-size: 120%;'><strong>Studente: " . htmlspecialchars($studentCourseData["student_name"]) . "</strong></p>";
        foreach ($studentCourseData["courses"] as $course) {
            $html .= "<strong>Titolo corso: " . htmlspecialchars($course["course_name"]) . "</strong><br>";
            $html .= "Numero lezioni :" . htmlspecialchars($course["lesson_number"]) . "<br>";
            $html .= "Presente a tutte le lezioni: " . ($course["always_present"] ? "Si" : "No") . "<br>";
            $html .= "Tasso di partecipazione medio al corso: " . number_format($course["course_tp"], 1, ",") . "%<br><br>";
        }
        $html .= "<strong>Tasso di partecipazione totale: " . number_format($studentCourseData["average_tp"], 1, ",") . "%</strong><hr>";
        return $html;
    }

    public function renderStudentsCoursesReport(array $studentsCoursesData): string
    {
        $html = "";
        foreach ($studentsCoursesData as $studentCourseData) {
            $html .= $this->renderStudentCourseReport($studentCourseData);
        }
        return $html;
    }

    public function renderCourseDetails(array $courseDetails): string
    {
        $html = "<strong>Titolo corso: " . htmlspecialchars($courseDetails["name"]) . "</strong><br>";
        $html .= "Numero studenti iscritti: " . htmlspecialchars($courseDetails["enrolled"]) . "<br><br>";
        foreach ($courseDetails["lessons"] as $lesson) {
            $html .= "Titolo lezione: " . htmlspecialchars($lesson["lesson_name"]) . "<br><br>";
            $html .= "Data lezione: " . $this->formatDate($lesson["lesson_date"]) . "<br>";
            $html .= "Orario di inizio/fine: " . $this->formatTime($lesson["lesson_start"]) . "/" . $this->formatTime($lesson["lesson_end"]) . "<br>";
            $html .= "Studenti presenti: " . htmlspecialchars($lesson["attendances"]) . "<br>";
            $html .= "Studenti assenti: " . htmlspecialchars($lesson["absents"]) . "<br>";
            $html .= "Tasso di partecipazione studenti: <br>";
            foreach ($lesson["lessons_tp"] as $studentName => $tp) {
                $html .= htmlspecialchars($studentName) . ": " . htmlspecialchars($tp) . "%<br>";
            }
            $html .= "<br>";
        }
        $html .= "Tasso di partecipazione medio corso: " . htmlspecialchars($courseDetails["average_tp"]) . "%<br><br>";
        $html .= "Studenti con più presenze: <br>";
        $mostAttStud = $courseDetails["most_attended_students"];
        foreach($mostAttStud as $student){
            $html .= $student->getFullName() . "<br>";
        }
        $html .= "<br><hr><br>";
        return $html;
    }

    public function renderCoursesDetails(array $coursesDetails): string
    {
        $html = "";
        foreach ($coursesDetails as $courseDetails) {
            $html .= $this->renderCourseDetails($courseDetails);
        }
        return $html;
    }

    public function setDateFormat($format)
    {
        $this->dateFormat = $format;
    }

    public function setTimeFormat($format)
    {
        $this->timeFormat = $format;
    }

    public function setDateTimeFormat($format)
    {
        $this->dateTimeFormat = $format;
    }
}
