<!-- 
    After Logging in, it redirects to Library's "list_page_script.php"
-->

<?php
    session_start();
    function sanitize($str)
    {
        return htmlentities(strip_tags(trim($str)));
    }

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
        header("Location: ../_client-scripts/list_page_script.php");
    }

    /* Process Login Data */
    if (!isset($_POST['username']) || !isset($_POST["password"]))
    {
        $msg = "Please Enter Username and Password";
        header("Location: ../_client-scripts/login_page.php?login_msg=$msg");
    }

    $entered_username = sanitize($_POST['username']);
    $entered_password = sanitize($_POST['password']);

    /**
     *  Now check if the data file exists.
     *  If not, create it with default values of admin:
     *      username: "admin"
     *      password: "admin"
     *  It is a JSON file that should be made.
     * 
     * */ 
    $file_path = "../data/users/users_data.json";
    $users_data = [];
    //  This will be false if file doesn't exist 
    //  If the file didn't exist at first, then create one and populate with standard admin info
    if (($file_contents = file_get_contents($file_path)) === FALSE)
    {
        $standard_admin_details = json_encode([["username" => 'admin', 'password' => 'admin']],
                                     JSON_PRETTY_PRINT);  
        $file_handle = fopen($file_path, "w");
        fwrite($file_handle, $standard_admin_details);
        fclose($file_handle);
        $users_data['username'] = "admin";
        $users_data['password'] = 'admin';
    }
    else{   #   If it does
        $users_data = json_decode(($file_contents), true);
        // Print associative array with
        // var_dump($users_data);
    }

    /**
     *  Now check if loaded data matches the entered data
     * 
     */
    $found = false;
    foreach ($users_data as $user_data)
    {
        if (strcmp($user_data['username'], $entered_username) == 0){
            if (strcmp($user_data['password'], $entered_password) == 0){
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = $user_data['username'];
                $found = true;
                break;
            }
        }
    }
    // print_r($users_data);
    
    if ($found)
    {
        header("Location: ../_client-scripts/list_page_script.php");
        // echo "Found: " . $found;
        // exit;
    }
    else{
        header("Location: ../_client-scripts/login_page.php");
    }
?>