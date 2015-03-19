<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $DB = new PDO('pgsql:host=localhost;dbname=test_restapp');

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);

            //Act
            $result = $test_cuisine->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Italian";
            $id = 1;
            $test_cuisine = new Cuisine($name, $id);

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);

            //Act
            $test_cuisine->setId(2);

            //Assert
            $result = $test_cuisine->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $name2 = "American";
            $id2 = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($name2, $id2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $name2 = "American";
            $id2 = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($name2, $id2);
            $test_cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Italian";
            $id = 1;
            $name2 = "American";
            $id2 = 2;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($name2, $id2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::find($test_cuisine->getId());

            //Assert
            $this->assertEquals($test_cuisine, $result);
        }

        function test_getRestaurants()
        {
            //Arrange
            $name = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();

            $restaurant_name = "Olive Garden";
            $address = "123 Mason St.";
            $description = "A fine Italian dining experience.";
            $test_restaurant = new Restaurant($restaurant_name, $address, $description, $id, $test_cuisine_id);
            $test_restaurant->save();

            $name2 = "Little Big Burger";
            $address2 = "345 NW 23rd Ave";
            $description2 = "A fine burger eating experience.";
            $test_restaurant2 = new Restaurant($name2, $address2, $description2, $id, $test_cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

    }
?>
