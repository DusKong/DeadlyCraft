<?php

namespace DeadlyCraft\player\job;

class Soldier extends Job{

    const JOB_ID = "soldier";

    public function getName() :string{
        return "ソルジャー";
    }
}