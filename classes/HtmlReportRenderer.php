<?php

class HtmlReportRenderer {
    public function __construct(){
    }       
    
    public function renderLesson(array $lessonData): string {
        $html = "Titolo lezione: " . $lessonData["title"] . "<br>";
        $html .= "N° lezione: " . $lessonData["number"] . "<br>";
        $html .= "Tenuta in data: " . $lessonData["date"] . "<br>";
        $html .= "Orario di inizio: " . $lessonData["start_time"] . "<br>";
        $html .= "Orario di uscita: " . $lessonData["end_time"] . "<br>";
        $html .= "Entrata studente: " . $lessonData["student_entry"] . "<br>";
        $html .= "Uscita studente: " . $lessonData["student_exit"] . "<br>";
        $html .= "Tasso di partecipazione: " . $lessonData["student_tp"] . "<br>";
        $html .= "<br>";

        return $html;
    }

    public function renderCourse(array $courseData): string{
        $html = "Titolo corso: " . $courseData["name"] . "<br>";
        $html .= "Data inizio: " . $courseData["start_date"] . "<br>";
        $html .= "Data fine: " . $courseData["end_date"] . "<br>";
        $html .= "Stato del corso: " . $courseData["status"] . "<br>";
        $html .= "<br>";

        return $html;
    }
}