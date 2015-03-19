<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $DB = new PDO('pgsql:host=localhost;dbname=rest_app_test');

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getCuisine_id()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getCuisine_id();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_setId()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
            $test_restaurant->save();

            //Act
            $test_restaurant->setId(2);

            //Assert
            $result = $test_restaurant->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);

            //Act
            $test_restaurant->save();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Little Big Burger";
            $address2 = "345 NW 23rd Ave";
            $description2 = "A fine burger eating experience.";
            $test_restaurant2 = new Restaurant($name2, $address2, $description2, $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Little Big Burger";
            $address2 = "345 NW 23rd Ave";
            $description2 = "A fine burger eating experience.";
            $test_restaurant2 = new Restaurant($name2, $address2, $description2, $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            Restaurant::deleteAll();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $address, $description, $id, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Little Big Burger";
            $address2 = "345 NW 23rd Ave";
            $description2 = "A fine burger eating experience.";
            $test_restaurant2 = new Restaurant($name2, $address2, $description2, $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::find($test_restaurant->getId());

            //Assert
            $this->assertEquals($test_restaurant, $result);

        }
    }
?>
