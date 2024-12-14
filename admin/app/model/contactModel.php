<?php

require_once '../config/connect.php';


class contactModel {

    // get all product
    public function getAllcontact() {
        $sql = "SELECT * FROM contacts";
        $result = Database::query($sql);
        return $result;
    }

    // get product by id
    public function getcontactById($id) {
        $sql = "SELECT * FROM contacts WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
    public function addcontact($email, $created_at) {
        $sql = "INSERT INTO contacts (email,created_at) VALUES ('$email','$created_at')";
        $result = Database::query($sql);
        return $result;
    }
    

    // edit product
    public function editcontact($id, $email, $created_at) {
        $sql = "UPDATE contacts SET email = '$email', created_at = '$created_at' WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
    

    // delete product
    public function deletecontacts($id) {
        $sql = "DELETE FROM contacts WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
}