<?php

    class Contact
    {
        private $name;
        private $address;
        private $phone;

        function __construct($name, $address, $phone)
        {
            $this->name=$name;
            $this->address=$address;
            $this->phone=$phone;
        }

        function get($property)
        {
            if (property_exists($this, $property)) {
                return $this->$property;
            } else {
                return "That property does not exist.";
            }
        }

        function set($property, $value)
        {
            if (property_exists($this, $property)) {
                $this[$property] = $value;
            } else {
                return "That property does not exist.";
            }
        }

        function save()
        {
            array_push($_SESSION['contact_array'], $this);
        }

        function deleteOne(array $array, $value = TRUE)
        {
            if(($key = array_search($value, $array)) !== FALSE) {
              unset($array[$key]);
            }
            return $array;
        }

        static function getAll()
        {
            return $_SESSION['contact_array'];
        }

        static function delete()
        {
            return $_SESSION['contact_array'] = array();
        }

    }


?>
