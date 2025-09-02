<?php

class Student {
    private int $id;
    private string $firstName;
    private string $lastName;
    private array $subscriptions = [];
    private array $attendances = [];

    public function __construct(int $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;        
    }

    public function getId(): int{
        return $this->id;
    }

    public function getFirstName(): string{
        return $this->firstName;
    }

    public function getLastName(): string{
        return $this->lastName;
    }

    public function getFullName(): string{
        return $this->firstName . " " . $this->lastName;
    }

    public function subscribeToCourse(int $courseId): void{
        if (!in_array($courseId, $this->subscriptions)){
            $this->subscriptions[] = $courseId;
        }
    }

    public function getSubscriptions(): array{
        return $this->subscriptions;
    }

    public function isSubscribedToCourse(int $courseID): bool{
        return in_array($courseID, $this->subscriptions);
    }
}