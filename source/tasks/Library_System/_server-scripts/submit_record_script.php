<!--
    This is where the data from 'submit_record_page.php'
    is sent. It will store this data and redirect back to
    'library_list_page.php', which will load the data that has been stored.

    VERY IMPORTANT: Each record is given an ID that simply counts it.
    In the end, didn't use IDs but used titles.

    Also, records can be deleted. In this case, since the whole data store has to be re-written, their IDs
    are also re-ordered.
    It is the "delete_record_script.php" that takes care of this.
-->


<?php
    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]==FALSE)
        header("Location: ../_client-scripts/login_page.php");

        
    function sanitize($str)
    {
        return htmlentities(strip_tags(trim($str)));
    }
    /**
     *  First, check if file exists. If it does not, create it.
     *  This file is an array of associative arrays.
     *   check if all record details were entered.
     *  Then, get record details that have been posted.
    **/
    // echo $_POST['category'];

    // $arr = [
    //     "first"=>["one", "two", "three"],
    //     "next"=>["four", "five", "six"],
    // ];
    // // echo "Array:\n";
    // print_r($arr);
    // echo "<br>";
    // echo "Count: " . count($arr);
    
    // foreach ($_POST as $key => $value){
        //     echo "Key: " . $key . "\n";
        //     echo "Val: " . $value . "\n";
        //     // if ($key === null ){
            //     //     header("Location: ../_client-scripts/submit_record_page.php");
            //     // }
    // }

    $file_path = "../data/library/library_records.json";
    //  Check if file exists and create if it doesn't
    $file_contents = file_get_contents($file_path);
    $file_data = [];
    if ($file_contents == FALSE){
        //  Create file
        $file_handle = fopen($file_path, "w");
        // fwrite($file_handle, json_encode([]));
        // fclose($file_handle);
        // $file_data = json_decode(file_get_contents($file_path), true);
    }
    else{
        $file_data = json_decode(file_get_contents($file_path), true);
    }

    //  Then initialize again
    // echo "<br/>";
    // echo "Size of File Data: " . count($file_data);
    
    // echo "<br>";
    // print_r($file_contents);

    //  Get record details and store them in array
    $new_record = [];

    foreach ($_POST as $k => $v){
        $k = sanitize($k);
        $v = sanitize($v);
        if ($k != "isbn"){
            $new_record[$k] = $v;
        }
    }

    $file_data[$_POST["isbn"]] = $new_record;

    //  then convert file_data array to JSON and write to memory as JSON file.
    $record_as_json = json_encode($file_data, JSON_PRETTY_PRINT);

    //  Write into file
    $file_handle = fopen($file_path, "w");
    fwrite($file_handle, $record_as_json);
    fclose($file_handle);

    // exit;
    header("Location: ../_client-scripts/list_page_script.php");
?>