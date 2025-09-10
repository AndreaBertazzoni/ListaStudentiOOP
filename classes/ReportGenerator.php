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

    public function displayStudentsInfo(array $students): void {
        $reportData = $this->reportService->collectStudentsReportData($students);
        echo $this->htmlReportRenderer->renderStudents($reportData);
    }

    public function displayStudentCourseInfo(Student $student): void {
        $reportData = $this->reportService->collectStudentCourseData($student);
        echo $this->htmlReportRenderer->renderStudentCourseReport($reportData);
    }

    public function displayStudentsCoursesInfo(array $students) : void {
        $reportData = $this->reportService->collectStudentsCoursesData($students);
        echo $this->htmlReportRenderer->renderStudentsCoursesReport($reportData);
    }

    public function displayCourseDetails(Course $course): void 
    {
        $reportData = $this->reportService->collectCourseDetails($course);
        echo $this->htmlReportRenderer->renderCourseDetails($reportData);
    }

    public function displayCoursesDetails(array $courses): void
    {
        $reportData = $this->reportService->collectCoursesDetails($courses);
        echo $this->htmlReportRenderer->renderCoursesDetails($reportData);
    }
}