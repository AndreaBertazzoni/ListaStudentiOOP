<?php

class HtmlReportRenderer
{
    public function __construct() {}

    public function renderLesson(array $lessonData): string
    {
        $html = "<strong>Titolo lezione: " . $lessonData["title"] . "</strong><br>";
        $html .= "N° lezione: " . $lessonData["number"] . "<br>";
        $html .= "Data lezione: " . $lessonData["date"] . "<br>";
        $html .= "Orario di inizio: " . $lessonData["start_time"] . "<br>";
        $html .= "Orario di uscita: " . $lessonData["end_time"] . "<br>";
        $html .= "Entrata studente: " . ($lessonData["student_entry"] ?: "assente") . "<br>";
        $html .= "Uscita studente: " . ($lessonData["student_exit"] ?: "assente") . "<br>";
        $html .= "Tasso di partecipazione: " . number_format($lessonData["student_tp"], 1, ",") . "%<br>";
        $html .= "<br>";

        return $html;
    }

    public function renderCourse(array $courseData): string
    {
        $html = "<p style='font-size: 120%;'><strong>Titolo corso: " . $courseData["name"] . "</strong></p>";
        $html .= "Data inizio: " . $courseData["start_date"] . "<br>";
        $html .= "Data fine: " . $courseData["end_date"] . "<br>";
        $html .= "Stato del corso: " . $courseData["status"] . "<br>";
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
        $html = "<p style='font-size: 120%;'><strong>Studente: " . $studentReportData["student_name"] . "</strong></p>";
        foreach ($studentReportData["courses"] as $course) {
            $html .= "<p style='font-size: 110%;'><strong>Titolo corso: " . $course["course_name"] . "</strong></p>";
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
        $html = "<p style='font-size: 120%;'><strong>Studente: " . $studentCourseData["student_name"] . "</strong></p>";
        foreach ($studentCourseData["courses"] as $course) {
            $html .= "<strong>Titolo corso: " . $course["course_name"] . "</strong><br>";
            $html .= "Numero lezioni :" . $course["lesson_number"] . "<br>";
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
        $html = "<strong>Titolo corso: " . $courseDetails["name"] . "</strong><br>";
        $html .= "Numero studenti iscritti: " . $courseDetails["enrolled"] . "<br><br>";
        foreach ($courseDetails["lessons"] as $lesson) {
            $html .= "Titolo lezione: " . $lesson["lesson_name"] . "<br><br>";
            $html .= "Data lezione: " . $lesson["lesson_date"] . "<br>";
            $html .= "Orario di inizio/fine: " . $lesson["lesson_start"] . "/" . $lesson["lesson_end"] . "<br>";
            $html .= "Studenti presenti: " . $lesson["attendances"] . "<br>";
            $html .= "Studenti assenti: " . $lesson["absents"] . "<br>";
            $html .= "Tasso di partecipazione studenti: <br>";
            foreach ($lesson["lessons_tp"] as $studentName => $tp) {
                $html .= $studentName . ": " . $tp . "%<br>";
            }
            $html .= "<br>";
        }
        $html .= "Tasso di partecipazione medio corso: " . $courseDetails["average_tp"] . "%<hr>";
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
}
