<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function testSave()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            //
            $executed = $test_stylist->save();
            //
            $this->assertTrue($executed, "Stylist not saved to database");
        }

        function testGetStylistName()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            //
            $result = $test_stylist->getStylistName();
            //
            $this->assertEquals($stylist_name, $result);
        }

        function testSetStylistName()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            //
            $test_stylist->setStylistName("Bill");
            $result = $test_stylist->getStylistName();
            //
            $this->assertEquals("Bill", $result);
        }

        function testGetStylistId()
        {
            //
            $stylist_id = "Bob";
            $test_stylist = new Stylist($stylist_id);
            $test_stylist->save();
            //
            $result = $test_stylist->getId();
            //
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_name_2 = "Bill";
            $test_stylist_2 = new Stylist($stylist_name_2);
            $test_stylist_2->save();
            //
            $result = Stylist::getAll();
            //
            $this->assertEquals([$test_stylist, $test_stylist_2], $result);
        }

        function testFind()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_name_2 = "Bill";
            $test_stylist_2 = new Stylist($stylist_name_2);
            $test_stylist_2->save();
            //
            $result = Stylist::find($test_stylist->getId());
            //
            $this->assertEquals($test_stylist, $result);
        }

        function testGetClients()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $client_name = "Sue";
            $test_client = new Client($client_name, $stylist_id);
            $test_client->save();
            $client_name_2 = "Jane";
            $test_client_2 = new Client($client_name_2, $stylist_id);
            $test_client_2->save();
            //
            $result = $test_stylist->getClients();
            //
            $this->assertEquals([$test_client, $test_client_2], $result);
        }

        function testUpdate()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $new_stylist_name = "Bill";
            //
            $test_stylist->update($new_stylist_name);
            //
            $this->assertEquals("Bill", $test_stylist->getStylistName());
        }

        function testDeleteAll()
        {
            //
            $stylist_name = "Bob";
            $stylist_name_2 = "Bill";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $test_stylist_2 = new Stylist($stylist_name_2);
            $test_stylist_2->save();
            //
            Stylist::deleteAll();
            $result = Stylist::getAll();
            //
            $this->assertEquals([], $result);
        }

        function testDelete()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_name_2 = "Bill";
            $test_stylist_2 = new Stylist($stylist_name_2);
            $test_stylist_2->save();
            //
            $test_stylist->delete();
            //
            $this->assertEquals([$test_stylist_2], Stylist::getAll());
        }

        function testDeleteCategoryClients()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $client_name = "Sue";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $stylist_id);
            $test_client->save();
            //
            $test_stylist->delete();
            //
            $this->assertEquals([], Client::getAll());
        }
    }
?>
