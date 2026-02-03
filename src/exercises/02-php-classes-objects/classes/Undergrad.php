<?php

require_once __DIR__ . '/Student.php';

    class Undergrad extends Student{
        protected $name;
        protected $number;
        protected $course;
        protected $year;

        public function __construct($name, $number, $course, $year) {
            
            $this->name = $name;
            $this->number = $number;
        }

        public function getName() {
            return $this->name;
            }

        public function getNumber() {
            return $this->number;
            }

            public function __toString(){
                return "Student: {$this->name} ({$this->number})";
            }

            public function __destruct(){
                echo "Undergrad: {$this->name} ";
            }
    }
?>