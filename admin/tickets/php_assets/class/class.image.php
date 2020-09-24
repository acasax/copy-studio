<?php
require_once '../../connection.php';

class IMAGE {
    public function move_uploaded_file(){
        $img = $_FILES["image"]["name"];// stores the original filename from the client
        $tmp = $_FILES["image"]["tmp_name"];// stores the name of the designated temporary file
        $errorimg = $_FILES["image"]["error"];// stores any error code resulting from the transfer
    }
}