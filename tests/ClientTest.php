<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function testSave()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $client_name = "Sue";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $stylist_id);
            //
            $executed = $test_client->save();
            //
            $this->assertTrue($executed, "Client not saved to database");
        }

        function testGetStylistId()
      {
           //
           $stylist_name = "Bob";
           $test_stylist = new Stylist($stylist_name);
           $test_stylist->save();
           $stylist_id = $test_stylist->getId();
           $client_name = "Sue";
           $test_client = new Client($client_name, $stylist_id);
           $test_client->save();
           //
           $result = $test_client->getStylistId();
           //
           $this->assertEquals($stylist_id, $result);;
      }

        function testGetClientName()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $client_name = "Sue";
            $test_client = new Client($client_name, $stylist_id);
            $test_client->save();
            //
            $result = $test_client->getClientName();
            //
            $this->assertEquals($client_name, $result);
        }

        function testGetId()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $client_name = "Sue";
            $test_client = new Client($client_name, $stylist_id);
            $test_client->save();
            //
            $result = $test_client->getId();
            //
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
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
           $result = Client::getAll();
           //
           $this->assertEquals([$test_client, $test_client_2], $result);
        }

        function testFind()
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
            $result = Client::find($test_client->getId());
            //
            $this->assertEquals($test_client, $result);
         }

        function testUpdateClientName()
        {
            //
            $stylist_name = "Bob";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();

            $client_name = "Sue";
            $test_client = new Client($client_name, $stylist_id);
            $test_client->save();

            $new_client_name = "Jane";
            //
            $test_client->updateClientName($new_client_name);
            //
            $this->assertEquals("Jane", $test_client->getClientName());
        }

        function testDeleteAll()
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
            Client::deleteAll();
            $result = Client::getAll();
            //
            $this->assertEquals([], $result);
        }

        function testDelete()
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
            $test_client->delete();
            //
            $this->assertEquals([$test_client_2], Client::getAll());
        }
    }
?>
