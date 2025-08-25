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
        header("Location: ../_client-scripts/login_page.php");
    }

    $entered_username = sanitize($_POST['username']);
    $entered_password = sanitize($_POST['password']);
    $reentered_password = sanitize($_POST['re-password']);

    if (!$entered_username || (!$entered_password && !$reentered_password))
    {
        if (strcmp($entered_password, $reentered_password) !=0)
        {
            $msg = "Passwords do not match";
            header("Location: ../_client-scripts/register_page.php?register_msg=$msg");
            exit;
        }
        $msg = "Must Enter Username and Password";
        header("Location: ../_client-scripts/register_page.php?register_msg=$msg");
        exit;
    }

    // echo "Reached";
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
    if (($file_contents = file_get_contents($file_path)) == FALSE)
    {
        $standard_admin_details = json_encode([
                ["username" => 'admin', "password" => 'admin'],
                ["username"=>$entered_username, "password"=>$entered_password]
            ], JSON_PRETTY_PRINT);  
        $file_handle = fopen($file_path, "w");
        fwrite($file_handle, $standard_admin_details);
        fclose($file_handle);

        $file_contents = file_get_contents($file_path);
        $users_data = json_decode($file_contents, true);
        header("Location: ../_client-scripts/login_page.php");
        exit;
    }
    else
    {   #   If the database file is not empty
        $users_data = json_decode(($file_contents), true);
    }
    print_r($file);
    /**
     *  Now check if that already exists. If not, append entered info to `users_data` and write to memory
    */
    $preexists = false;
    foreach ($users_data as $user_data)
    {
        if ((strcmp($user_data['username'], $entered_username) == 0)
            &&  strcmp($user_data['password'], $entered_password) == 0)
        {
            $preexists = true;
            break;
        }
    }
    if ($preexists){
        $msg = "User already exists";
        header("Location: ../_client-scripts/register_page.php?register_msg=$msg");
        exit;
    }
    else{
        $users_data[] = [
            "username"=>$entered_username,
            "password"=>$entered_password
        ];
        $wfs = fopen($file_path, "w");
        fwrite($wfs, json_encode($users_data, JSON_PRETTY_PRINT));
        fclose($wfs);
        header("Location: ../_client-scripts/login_page.php");
    }
?>