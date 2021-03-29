<?php

error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

    $path = "uploads/"; //set your folder path
    //set the valid file extensions 
    //$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload
    $valid_formats = array("sqlite", "sqlite3", "csv", "db", "db3", "sql", "zip", "rar", "7z");
    $name = $_FILES['browse_button']['name']; //get the name of the file
    
    $size = $_FILES['browse_button']['size']; //get the size of the file
    $file_name = "";

    $can_upload = false;

    // CHECK IF FILE EXISTS.. IF NOT, THEN CONTINUE UPLOADING
   
    $backup_name_temp = $_POST['backupname'];
    list($fname, $fext) = explode(".", $name);

    if (!file_exists("uploads/".$backup_name_temp. "." . $fext))
    {
        if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
            list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
            if (in_array($ext, $valid_formats)) { //if the file is valid go on.
                if ($size < 1073741824){//2098888) { // check if the file size is more than 2 mb
                    $file_name = $_POST['backupname']; //get the file name
                    $tmp = $_FILES['browse_button']['tmp_name'];
                    if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) 
                    { //check if it the file move successfully.
                        echo "File Uploaded Successfully";
                    } else {
                        echo "Upload Failed";
                    }
                } else {
                    echo "Maximum file size allowed is 100 MB!";
                }
            } else {
                echo "Invalid File Format!";
            }
        } else {
            echo "Please select a valid file!";
        }
    }
    else
    {
        echo "A file named \"" . $backup_name_temp . "\" already exists! Please provide a new filename.";
    }
}

// browse_button