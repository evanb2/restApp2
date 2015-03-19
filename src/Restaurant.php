<?php
    class Restaurant
    {
        private $name;
        private $address;
        private $description;
        private $id;
        private $cuisine_id;

        function __construct($name, $address, $description, $id = null, $cuisine_id)
        {
            $this->name = $name;
            $this->address = $address;
            $this->description = $description;
            $this->id = $id;
            $this->cuisine_id = $cuisine_id;
        }

        //setters
        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setAddress($new_address)
        {
            $this->address = (string) $new_address;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function setCusineId($new_cuisine_id)
        {
            $this->cuisine_id = (int) $new_cuisine_id;
        }

        //getters
        function getName()
        {
            return $this->name;
        }

        function getAddress()
        {
            return $this->address;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getId()
        {
            return $this->id;
        }

        function getCuisine_id()
        {
            return $this->cuisine_id;
        }

        //save
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO restaurant
                (name, address, description, cuisine_id) VALUES ('{$this->getName()}',
                '{$this->getAddress()}', '{$this->getDescription()}', {$this->getCuisine_id()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        //getAll
        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $address = $restaurant['address'];
                $description = $restaurant['description'];
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
                array_push($restaurants, $new_restaurant);
        }

            return $restaurants;
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurant *;");
        }
    }
?>
