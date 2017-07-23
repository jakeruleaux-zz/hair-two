<?php
    class Stylist
    {
        private $stylist_name;
        private $id;

        function __construct($stylist_name, $id = null)
        {
            $this->stylist_name = $stylist_name;
            $this->id = $id;
        }

        function setStylistName($new_stylist_name)
        {
            $this->stylist_name = (string) $new_stylist_name;
        }

        function getStylistName()
        {
            return $this->stylist_name;
        }

        function setId()
        {
            $this->id = ($id);
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_name) VALUES ('{$this->getStylistName()}');");
            if ($executed) {
                $this->id= $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach($returned_stylists as $stylist) {
                $stylist_name = $stylist['stylist_name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($stylist_name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function find($search_id)
           {
            $found_stylist = null;
            $returned_stylists = $GLOBALS['DB']->prepare("SELECT * FROM stylists WHERE id = :id");
            $returned_stylists->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_stylists->execute();
            foreach($returned_stylists as $stylist) {
                $stylist_name = $stylist['stylist_name'];
                $stylist_id = $stylist['id'];
                if ($stylist_id == $search_id) {
                $found_stylist = new Stylist($stylist_name, $stylist_id);
                    }
                }
                return $found_stylist;
           }

        function getClients()
        {
            $clients = Array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()};");
            foreach($returned_clients as $client) {
                $client_name = $client['client_name'];
                $stylist_id = $client['stylist_id'];
                $client_id = $client['id'];
                //$stylist_id = $client['stylist_id'];
                $new_client = new Client($client_name, $stylist_id, $client_id);
                array_push($clients, $new_client);
               }
               return $clients;
        }

        function update($new_stylist_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE stylists SET stylist_name = '{$new_stylist_name}' WHERE id = {$this->getId()};");
            if ($executed) {
            $this->setStylistName($new_stylist_name);
                return true;
                } else {
                return false;
                }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
            if (!$executed) {
                return false;
                }
                $executed = $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
                if ($executed) {
                   return false;
                } else {
                   return true;
                }
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }
    }
 ?>
