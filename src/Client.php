
<?php
    class Client
    {
        private $client_name;
        private $stylist_id;
        private $id;

        function __construct($client_name, $stylist_id, $id = null)
        {
            $this->client_name = $client_name;
            $this->stylist_id = $stylist_id;
            $this->id = $id;
        }

        function setClientName($new_client_name)
        {
            $this->client_name = (string)$new_client_name;
        }

        function getClientName()
        {
            return $this->client_name;
        }

        function setId()
        {
            $this->id = ($id);
        }

        function getId()
        {
            return $this->id;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO clients (client_name, stylist_id) VALUES ('{$this->getClientName()}', {$this->getStylistId()})");
            if ($executed) {
                 $this->id= $GLOBALS['DB']->lastInsertId();
                 return true;
            } else {
                 return false;
            }
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client) {
               $client_name = $client['client_name'];
               $stylist_id = $client['stylist_id'];
               $id = $client['id'];
               $new_client = new Client($client_name, $stylist_id, $id);
               array_push($clients, $new_client);
           }
            return $clients;
        }

        static function find($search_id)
        {
            $returned_clients = $GLOBALS['DB']->prepare("SELECT * FROM clients WHERE id = :id");
            $returned_clients->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_clients->execute();
            foreach($returned_clients as $client) {
                $client_name = $client['client_name'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                if ($id == $search_id) {
                $found_client = new Client($client_name, $stylist_id, $id);
                }
              }
            return $found_client;
          }

        function update($new_client_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE clients SET client_name = '{$new_client_name}' WHERE id = {$this->getId()};");
            if ($executed) {
            $this->setClientName($new_client_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
            // if ($executed) {
            //     return false;
            // }
            // $executed = $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
               return false;
            }
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }
    }
 ?>
