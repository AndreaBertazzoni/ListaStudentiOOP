<?php
require_once "vendor/autoload.php";
require_once "classes/Student.php";

use Carbon\Carbon;

$student1 = new Student(01, "Andrea", "Bertazzoni");

echo $student1->getFullName();
echo "<br>";


$student1->subscribeToCourse(100);
$student1->subscribeToCourse(101);

echo implode(", ", $student1->getSubscriptions());
echo "<br>";

echo $student1->isSubscribedToCourse(103);