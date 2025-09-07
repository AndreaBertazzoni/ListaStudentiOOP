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
        $html .= "Tasso di partecipazione: " . $lessonData["student_tp"] . "%<br>";
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
        return $html;
    }

    public function renderStudent(array $studentReportData): string
    {
        $html = "<p style='font-size: 120%;'><strong>Studente: " . $studentReportData["student_name"] . "</strong></p>";
        foreach ($studentReportData["courses"] as $course) {
            $html .= "<p style='font-size: 110%;'><strong>Titolo corso: " . $course["course_name"] . "</strong></p>";
            foreach ($course["lessons"] as $lesson) {
                $html .= $this->renderLesson($lesson);
            }
            $html .= "<p><strong>Tasso di partecipazione medio: " . $course["average_tp"] . "%</strong></p><br>";
        }
        return $html;
    }
}
