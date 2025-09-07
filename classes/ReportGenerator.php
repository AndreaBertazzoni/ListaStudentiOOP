<?php

class ReportGenerator{
    private ReportService $reportService;
    private HtmlReportRenderer $htmlReportRenderer;

    public function __construct(CoursesManager $coursesManager){
        $this->reportService = new ReportService($coursesManager);
        $this->htmlReportRenderer = new HtmlReportRenderer();
    }
         
    public function displayCourseInfo(Course $course){
        $reportData = $this->reportService->collectCourseReportData($course);
        echo $this->htmlReportRenderer->renderCourse($reportData);
    }

    public function displayCoursesInfo(array $courses){
        $reportData = $this->reportService->collectCoursesReportData($courses);
        echo $this->htmlReportRenderer->renderCourses($reportData);
    }

    public function displayStudentInfo(Student $student){
        $reportData = $this->reportService->collectStudentReportData($student);
        echo $this->htmlReportRenderer->renderStudent($reportData);
    }

}