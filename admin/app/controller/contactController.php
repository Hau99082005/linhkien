<?php

require_once 'app/model/contactModel.php';

class contactController
{
    public function index()
    {
        $contact = new contactModel();
        $contacts = $contact->getAllcontact();

        include_once 'views/pages/contact/contact.php';
    }

    public function create() {
        $err = [];
        $data = $_POST;
        
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $created_at = $_POST['created_at'];
    
            if (empty($err)) {
                $contact = new contactModel();
                $contact->addcontact($email, $created_at);
                header('Location:' . APPURL_ADMIN . 'contact');
            }
        }
        include_once 'views/pages/contact/create.php';
    }
    
    //edit product
    public function edit() {
        $contact_id = $_GET['id'];
        $contact = new contactModel();
        $contactData = $contact->getcontactById($contact_id)->fetch_assoc();
        $err = [];
    
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $created_at = $_POST['created_at'];
    
            if (empty($err)) {
                $contact->editcontact($contact_id, $email,  $created_at);
                header('Location:' . APPURL_ADMIN . 'contact');
            }
        }
        include_once 'views/pages/contact/edit.php';
    }

    //delete product
    public function delete() {
        $contact_id = $_GET['id'];
        $contact = new contactModel();
        $contact->deletecontacts($contact_id);
        header('Location:' . APPURL_ADMIN . 'contact');
    }
}