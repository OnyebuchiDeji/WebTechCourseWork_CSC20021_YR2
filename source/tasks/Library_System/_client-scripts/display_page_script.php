<!--
    This will receive by POST or GET the details of which
-->


<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]==FALSE)
        header("Location: ./login_page.php");

    
    if (!isset($_GET['isbn']))
    header("Location: ./list_page_script.php");

    $target_isbn = $_GET['isbn'];
    
    //  Read data
    $file_path = "../data/library/library_records.json";
    $file_contents = file_get_contents($file_path);
    
    if (!$file_contents){
        header("Location: ./list_page_script.php");
    }

    //  If there are indeed contents
    $data_as_array = json_decode($file_contents, true);
    $found = false;
    $index = 0;
    $isbn = "";
    foreach ($data_as_array as $recisbn=>$record)
    {
        if ($recisbn == $target_isbn){
            $isbn = $recisbn;
            $found = true;
            break;
        }
        $index += 1;
    }

    //  If it didn't exist, just return.
    if (!$found){
        header("Location: ./list_page_script.php");
    }
?>

<!DOCTYPE HTML><html lang="en">
    <head>
        <title>Display Library Record</title>
        <link rel="stylesheet" type="text/css" href="../../../main/_css_styles/Home.css">
        <link rel="stylesheet" type="text/css" href="../../../main/_css_styles/Library.css">
    </head>

    <body>
        <nav id="headerbar">
            <div id="website_icon"><a href="../../../main/Home.html">Web Technology Project|22021699</a></div>
            <div id="navlinks">
                <a href="../../../main/Home.html">Home</a>
                <a href="../../../main/About.html">About</a>
                <a href="../../../main/Project_Tasks.html">Project Tasks</a>
                <a href="../_server-scripts/logout_script.php">Logout</a>
            </div>
        </nav>
        <article>
            <a class="back_link" href="./list_page_script.php">Back to List</a>

            <div id="library_record_details">
                <h2><b><?=$data_as_array[$isbn]['title']?></b></h2>
                
                <h4>ISBN:</h4>
                <p><?=strtoupper($isbn)?></p>
                
                <h4>Description:</h4>
                <p><?=strtoupper($data_as_array[$isbn]['description'])?></p>

                <h4>Category:</h4>
                <p><?=strtoupper($data_as_array[$isbn]['category'])?></p>

                <h4>Associated Module Code:</h4>
                <p><?=strtoupper($data_as_array[$isbn]['module_code'])?></p>
            </div>

        </article>
        
        
        <nav id="footerbar">
            <a href="../../../main/Home.html">Home</a>
            <a href="../../../main/About.html">About</a>
            <a href="../../../main/Project_Tasks.html">Project Tasks</a>
            <p>
                <strong>Email:</strong> x7e30@students.keele.ac.uk|
                <a href="https://www.linkedin.com/in/ebenezer-ayo-metibemu-93392626b">
                    LinkedIn
                </a>
            </p>
            <p>
                @2023 Deji Projects. All rights reserved.
                Website built using HTML, CSS, JS, PHP.
            </p>

        </nav>
    </body>

</html>