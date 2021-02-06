<?php

namespace DeadlyCraft\player\job;

abstract class Job{

    public static function getId() {
        return static::JOB_ID;
    }

    abstract public function getName() :string;

    public static function getDefaultData() :array{
        return [
            "level" => 1,
            "exp" => 0
        ];
    }

    public static function getClassByName(string $jobName) :Job{
        switch($jobName) {
            case Soldier::JOB_ID: return new Soldier();
            //case Witch::JOB_NAME: return new Witch();
            //case Archer::JOB_NAME: return new Archer();
        }
        return null;
    }
}