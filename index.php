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

$attendances01_course101 = [
    new Attendance(
        1001,
        Carbon::parse("2025/09/01"),
        Carbon::parse("2025/09/01 10:00"),
        Carbon::parse("2025/09/01 12:00")
    ),
    new Attendance(
        1002,
        Carbon::parse("2025/09/03"),
        Carbon::parse("2025/09/03 10:00"),
        Carbon::parse("2025/09/03 12:00")
    ),
    new Attendance(
        1003,
        Carbon::parse("2025/09/05"),
        Carbon::parse("2025/09/05 10:00"),
        Carbon::parse("2025/09/05 12:00")
    ),
    new Attendance(
        1004,
        Carbon::parse("2025/09/07"),
        Carbon::parse("2025/09/07 10:00"),
        Carbon::parse("2025/09/07 12:00")
    ),
];

// Corso 103 - Matematica
$attendances01_course103 = [
    new Attendance(
        3001,
        Carbon::parse("2025/08/10"),
        Carbon::parse("2025/08/10 15:00"),
        Carbon::parse("2025/08/10 17:00")
    ),
    new Attendance(
        3002,
        Carbon::parse("2025/08/12"),
        Carbon::parse("2025/08/12 15:00"),
        Carbon::parse("2025/08/12 17:00")
    ),
    new Attendance(
        3003,
        Carbon::parse("2025/08/14"),
        Carbon::parse("2025/08/14 15:00"),
        Carbon::parse("2025/08/14 17:00")
    ),
    new Attendance(
        3004,
        Carbon::parse("2025/08/16"),
        Carbon::parse("2025/08/16 15:00"),
        Carbon::parse("2025/08/16 17:00")
    ),
];

foreach (array_merge($attendances01_course101, $attendances01_course103) as $attendance) {
    $student01->addAttendance($attendance);
}

// ATTENDANCES STUDENTE 02 - Federico Verdi (con variazioni)
// Corso 101 - Storia dell'Arte (arriva in ritardo prima lezione, esce prima ultima)
$attendances02_course101 = [
    new Attendance(
        1001,
        Carbon::parse("2025/09/01"),
        Carbon::parse("2025/09/01 10:15"), // 15 min di ritardo
        Carbon::parse("2025/09/01 12:00")
    ),
    new Attendance(
        1002,
        Carbon::parse("2025/09/03"),
        Carbon::parse("2025/09/03 10:00"),
        Carbon::parse("2025/09/03 12:00")
    ),
    new Attendance(
        1003,
        Carbon::parse("2025/09/05"),
        Carbon::parse("2025/09/05 10:00"),
        Carbon::parse("2025/09/05 12:00")
    ),
    new Attendance(
        1004,
        Carbon::parse("2025/09/07"),
        Carbon::parse("2025/09/07 10:00"),
        Carbon::parse("2025/09/07 11:30") // Esce 30 min prima
    ),
];

// Corso 102 - Programmazione PHP (salta una lezione)
$attendances02_course102 = [
    new Attendance(
        2001,
        Carbon::parse("2025/09/10"),
        Carbon::parse("2025/09/10 15:00"),
        Carbon::parse("2025/09/10 17:00")
    ),
    // Salta lezione 2002
    new Attendance(
        2003,
        Carbon::parse("2025/09/14"),
        Carbon::parse("2025/09/14 15:10"), // 10 min di ritardo
        Carbon::parse("2025/09/14 17:00")
    ),
    new Attendance(
        2004,
        Carbon::parse("2025/09/16"),
        Carbon::parse("2025/09/16 15:00"),
        Carbon::parse("2025/09/16 17:00")
    ),
];

// Corso 103 - Matematica (presenze buone)
$attendances02_course103 = [
    new Attendance(
        3001,
        Carbon::parse("2025/08/10"),
        Carbon::parse("2025/08/10 15:00"),
        Carbon::parse("2025/08/10 17:00")
    ),
    new Attendance(
        3002,
        Carbon::parse("2025/08/12"),
        Carbon::parse("2025/08/12 15:05"), // 5 min di ritardo
        Carbon::parse("2025/08/12 17:00")
    ),
    new Attendance(
        3003,
        Carbon::parse("2025/08/14"),
        Carbon::parse("2025/08/14 15:00"),
        Carbon::parse("2025/08/14 17:00")
    ),
    new Attendance(
        3004,
        Carbon::parse("2025/08/16"),
        Carbon::parse("2025/08/16 15:00"),
        Carbon::parse("2025/08/16 16:45") // Esce 15 min prima
    ),
];

foreach (array_merge($attendances02_course101, $attendances02_course102, $attendances02_course103) as $attendance) {
    $student02->addAttendance($attendance);
}

// ATTENDANCES STUDENTE 03 - Alessandro Bianchi (solo corso 102, presenze irregolari)
$attendances03_course102 = [
    new Attendance(
        2001,
        Carbon::parse("2025/09/10"),
        Carbon::parse("2025/09/10 15:20"), // 20 min di ritardo
        Carbon::parse("2025/09/10 17:00")
    ),
    new Attendance(
        2002,
        Carbon::parse("2025/09/12"),
        Carbon::parse("2025/09/12 15:00"),
        Carbon::parse("2025/09/12 16:30") // Esce 30 min prima
    ),
    // Salta lezione 2003
    new Attendance(
        2004,
        Carbon::parse("2025/09/16"),
        Carbon::parse("2025/09/16 15:00"),
        Carbon::parse("2025/09/16 17:00")
    ),
];

foreach ($attendances03_course102 as $attendance) {
    $student03->addAttendance($attendance);
}

// ATTENDANCES STUDENTE 04 - Giacomo Leopardi (corsi 102 e 103, presenze mediocri)
// Corso 102 - Programmazione PHP
$attendances04_course102 = [
    // Salta prima lezione
    new Attendance(
        2002,
        Carbon::parse("2025/09/12"),
        Carbon::parse("2025/09/12 15:30"), // 30 min di ritardo
        Carbon::parse("2025/09/12 17:00")
    ),
    new Attendance(
        2003,
        Carbon::parse("2025/09/14"),
        Carbon::parse("2025/09/14 15:00"),
        Carbon::parse("2025/09/14 16:45") // Esce 15 min prima
    ),
    new Attendance(
        2004,
        Carbon::parse("2025/09/16"),
        Carbon::parse("2025/09/16 15:15"), // 15 min di ritardo
        Carbon::parse("2025/09/16 17:00")
    ),
];

// Corso 103 - Matematica
$attendances04_course103 = [
    new Attendance(
        3001,
        Carbon::parse("2025/08/10"),
        Carbon::parse("2025/08/10 15:00"),
        Carbon::parse("2025/08/10 17:00")
    ),
    // Salta lezione 3002
    new Attendance(
        3003,
        Carbon::parse("2025/08/14"),
        Carbon::parse("2025/08/14 15:25"), // 25 min di ritardo
        Carbon::parse("2025/08/14 17:00")
    ),
    new Attendance(
        3004,
        Carbon::parse("2025/08/16"),
        Carbon::parse("2025/08/16 15:00"),
        Carbon::parse("2025/08/16 16:50") // Esce 10 min prima
    ),
];

foreach (array_merge($attendances04_course102, $attendances04_course103) as $attendance) {
    $student04->addAttendance($attendance);
}
$courseManager = new CoursesManager();

$courseManager->addCourses($course101, $course102, $course103);
$courseManager->addStudents($student01, $student02, $student03, $student04);

$reportGenerator = new ReportGenerator($courseManager);

$reportGenerator->displayCoursesInfo($courseManager->getCourses());
$reportGenerator->displayStudentsInfo($courseManager->getStudents());
$reportGenerator->displayStudentsCoursesInfo($courseManager->getStudents());
$reportGenerator->displayCourseDetails($course101);