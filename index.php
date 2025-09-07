<?php
require_once "vendor/autoload.php";
require_once "autoloader.php";

use Carbon\Carbon;

$student01 = new Student(01, "Andrea", "Rossi");
$student02 = new Student(02, "Federico", "Verdi");
$student03 = new Student(03, "Alessandro", "Bianchi");
$student04 = new Student(04, "Giacomo", "Leopardi");

$course101 = new Course(101, "Storia dell'Arte");

$lesson1001 = new Lesson(
    1001,
    1,
    "Introduzione",
    Carbon::parse("2025/09/01"),
    Carbon::parse("2025/09/01 10:00"),
    Carbon::parse("2025/09/01 12:00")
);

$lesson1002 = new Lesson(
    1002,
    2,
    "Rinascimento",
    Carbon::parse("2025/09/03"),
    Carbon::parse("2025/09/03 10:00"),
    Carbon::parse("2025/09/03 12:00")
);

$lesson1003 = new Lesson(
    1003,
    3,
    "Futurismo",
    Carbon::parse("2025/09/05"),
    Carbon::parse("2025/09/05 10:00"),
    Carbon::parse("2025/09/05 12:00")
);

$lesson1004 = new Lesson(
    1004,
    4,
    "Rinascimento",
    Carbon::parse("2025/09/07"),
    Carbon::parse("2025/09/07 10:00"),
    Carbon::parse("2025/09/07 12:00")
);

$course101->addLessons($lesson1001, $lesson1002, $lesson1003, $lesson1004);

$course102 = new Course(102, "Programmazione PHP");

$lesson2001 = new Lesson(
    2001,
    1,
    "Introduzione",
    Carbon::parse("2025/09/10"),
    Carbon::parse("2025/09/10 15:00"),
    Carbon::parse("2025/09/10 17:00")
);

$lesson2002 = new Lesson(
    2002,
    2,
    "Variabili",
    Carbon::parse("2025/09/12"),
    Carbon::parse("2025/09/12 15:00"),
    Carbon::parse("2025/09/12 17:00")
);

$lesson2003 = new Lesson(
    2003,
    3,
    "Logica if/else",
    Carbon::parse("2025/09/14"),
    Carbon::parse("2025/09/14 15:00"),
    Carbon::parse("2025/09/14 17:00")
);

$lesson2004 = new Lesson(
    2004,
    4,
    "Array",
    Carbon::parse("2025/09/16"),
    Carbon::parse("2025/09/16 15:00"),
    Carbon::parse("2025/09/16 17:00")
);

$course102->addLessons($lesson2001, $lesson2002, $lesson2003, $lesson2004);

$course103 = new Course(103, "Matematica");

$lesson3001 = new Lesson(
    3001,
    1,
    "Introduzione",
    Carbon::parse("2025/08/10"),
    Carbon::parse("2025/08/10 15:00"),
    Carbon::parse("2025/08/10 17:00")
);

$lesson3002 = new Lesson(
    3002,
    2,
    "Calcoli semplici",
    Carbon::parse("2025/08/12"),
    Carbon::parse("2025/08/12 15:00"),
    Carbon::parse("2025/08/12 17:00")
);

$lesson3003 = new Lesson(
    3003,
    3,
    "Equazioni",
    Carbon::parse("2025/08/14"),
    Carbon::parse("2025/08/14 15:00"),
    Carbon::parse("2025/08/14 17:00")
);

$lesson3004 = new Lesson(
    3004,
    4,
    "Algebra",
    Carbon::parse("2025/08/16"),
    Carbon::parse("2025/08/16 15:00"),
    Carbon::parse("2025/08/16 17:00")
);

$course103->addLessons($lesson3001, $lesson3002, $lesson3003, $lesson3004);

$student01->subscribeToCourses($course101, $course103);
$student02->subscribeToCourses($course101, $course102, $course103);
$student03->subscribeToCourses($course102);
$student04->subscribeToCourses($course102, $course103);

$attendances01 = [
    $attendance1001 = new Attendance(
        1001,
        Carbon::parse("2025/09/01"),
        Carbon::parse("2025/09/01 10:00"),
        Carbon::parse("2025/09/01 12:00")
    ),
    $attendances1002 = new Attendance(
        1002,
        Carbon::parse("2025/09/03"),
        Carbon::parse("2025/09/03 10:00"),
        Carbon::parse("2025/09/03 12:00")
    ),
    $attendances1003 = new Attendance(
        1003,
        Carbon::parse("2025/09/05"),
        Carbon::parse("2025/09/05 10:00"),
        Carbon::parse("2025/09/05 12:00")
    ),
    $attendances1004 = new Attendance(
        1004,
        Carbon::parse("2025/09/07"),
        Carbon::parse("2025/09/07 10:00"),
        Carbon::parse("2025/09/07 12:00")
    ),
];

foreach ($attendances01 as $attendance) {
    $student01->addAttendance($attendance);
}

$courseManager = new CoursesManager();

$courseManager->addCourses($course101, $course102, $course103);
$courseManager->addStudents($student01);

$reportGenerator = new ReportGenerator($courseManager);

$reportGenerator->displayCoursesInfo($courseManager->getCourses());
$reportGenerator->displayStudentInfo($student01);
