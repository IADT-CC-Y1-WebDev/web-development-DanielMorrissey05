<?php
    class Student{
        protected $name;
        protected $number;

        public function __construct($name, $number){
            //echo "Creating student for $name...<br>";
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
                echo "Student {$this->name} has left the system <br>";
            }
    }

    $account = new Student("Daniel", "N00253379");
    echo $account;
?>