<!-- 
    This is what loads and displays the list of library records
    that were entered into "submit_record_page.php" and written to
    memory by "submit_record_script.php".

    It displays nothing at first, since it will be empty, and hence the PHP will
    ensure to indicate that.
    It has a button to add a record, which redirects to the "submit_record_page.php"
    The PHP will also keep track of the number of records entered.

    These records can be clicked, which will redirect to "display_page_script.php".
-->


<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]==FALSE)
        header("Location: ./login_page.php");

    //  Get the Library data from the store
    $file_path = "../data/library/library_records.json";

    /**
     *  If the file does not exist file_get_contents returns false
     *  The return value must be handled like this, with the === false or == false
     *  It should not be handled in the else statement lest the warning persist
     * */
    if (($data_as_json = file_get_contents($file_path)) == false)
    {
        $file_handle = fopen($file_path, "w");
    }
    else{
        $data_array = json_decode($data_as_json,true);
        // print_r($data_array);
    }

?>

<!DOCTYPE HTML><html lang="en">
    <head>
        <title>List Library Records</title>
        <link rel="stylesheet" type="text/css" href="../../../main/_css_styles/Home.css">
        <link rel="stylesheet" type="text/css" href="../../../main/_css_styles/Library.css">
        <script defer>
            var SubmitFormOpen = false;
            var UpdateFormOpen = false;
            function SubmitRecordFormToggle()
            {
                var ref=document.getElementById('submit_record_form');
                SubmitFormOpen = !SubmitFormOpen;
                if (SubmitFormOpen){
                    ref.style.display = 'block';
                    ref.style.position = 'fixed';
                }else{
                    ref.style.display = 'none';
                }
                
            }
            function UpdateRecordFormToggle()
            {
                var ref=document.getElementById('update_record_form');
                UpdateFormOpen = !UpdateFormOpen;
                if (UpdateFormOpen){
                    ref.style.display = 'block';
                    ref.style.position = 'fixed';
                }else{
                    ref.style.display = 'none';
                }
            }
            function CloseSubmitForm()
            {
                var ref=document.getElementById('submit_record_form');
                SubmitFormOpen = false;
                ref.style.display = 'none';
            }
            function CloseUpdateForm()
            {
                var ref=document.getElementById('update_record_form');
                UpdateFormOpen = false;
                ref.style.display = 'none';
            }
            
        </script>
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
        <h2>The Library Records</h2>
        <p>Welcom User, <b><?=ucwords($_SESSION['username'])?></b></p>
        <h4>Records are updated by their ISBN</h4>
        
        <?php

            if (!$data_as_json){
                echo "<h3><b>The List is Empty Right Now.</b></h3>";
            }
            else{
                echo "<div class='list_library_records'>";
                $isbn = "";
                foreach ($data_array as $recisbn=>$record){
                    $isbn = $recisbn;
                    echo "<div class='record_data'>";
                    
                    echo "<p>ISBN: <b>" . strtoupper($recisbn) . "</b></p>";
                    foreach ($record as $k=>$v){
                        echo "<p>" . ucwords(str_replace("_", " ", $k)) . ": <b>" . strtoupper($v) . "</b></p>";
                    }
                    echo "<div class='record_control_buttons'>";
                    // $isbn = $data_array[$recisbn]['isbn'];
                    echo "<a href='./display_page_script.php?isbn=$isbn'>View Record</a>";
                    echo "<a href='../_server-scripts/delete_record_script.php?isbn=$isbn'>Delete Record</a>";
                    echo "<button type='button' onclick='UpdateRecordFormToggle()'>Update Record</button>";
                    // echo "<br><br>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } 
        ?>

        <!-- <a href="./submit_record_page.php" >Add or Update Record</a> -->
        <button class="toggle_button" onclick="SubmitRecordFormToggle()">Add Record</button>

        </article>
        
        <form style='display:none;' id="submit_record_form" class="record_form" method="POST" action="../_server-scripts/submit_record_script.php">
            <div class="form_header">
                <h2>New Record</h2>
                <button type="button" onclick='CloseSubmitForm(this)' title="close form">X</button>
            </div>
            <div class="form_element">
                <label>Title:</label>
                <input type="text" id="title" name="title">
            </div>
            <div class="form_element">
                <label>Description:</label>
                <input type="text" id="description" name="description">
            </div>
            <div class="form_element">
                <label>ISBN:</label>
                <input type="number" id="isbn" name="isbn">
            </div>
            <div class="form_element">
                <label>Category:</label>
                <select class="form-record_select" id="category" name="category">
                    <option value="Visual Arts">Visual Arts</option>
                    <option value="Literature">Literature</option>
                    <option value="Music">Music</option>
                    <option value="Natural Sciences">Natural Sciences</option>
                    <option value="Computing">Computing</option>
                    <option value="Math">Math</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Business">Business</option>
                    <option value="Law">Law</option>
                    <option value="Language">Language</option>
                </select>
            </div>
            <div class="form_element">
                <label>Associated Keele Module Code:</label>
                <select class="form-record_select" id="module_code" name="module_code">
                    <!-- <option value=""> -->
                    <option value="LSC">LSC</option>
                    <option value="CSC">CSC</option>
                    <option value="OTHER">OTHER</option>
                </select>
            </div>
            <br><br>
            <input type="submit" class="form-submit_button">
        </form>

        <form style='display:none;' id="update_record_form" class="record_form" method="POST" action="../_server-scripts/submit_record_script.php">
            <div class="form_header">
                <h2>Update Record</h2>
                <button type="button" onclick='CloseUpdateForm()' title="close form">X</button>
            </div>
            <div class="form_element">
                <label>Title:</label>
                <input type="text" id="title" name="title" value='<?=$data_array[$isbn]['title']?>'>
            </div>
            <div class="form_element">
                <label>Description:</label>
                <input type="text" id="description" name="description" value='<?=$data_array[$isbn]["description"]?>'>
            </div>
            <div class="form_element">
                <label>ISBN:</label>
                <input type="number" id="isbn" name="isbn" value='<?=$isbn?>'>
            </div>
            <div class="form_element">
                <label>Category:</label>
                <select class="form-record_select" id="category" name="category" value='<?=$data_array[$isbn]["category"]?>'>
                    <option value="Visual Arts">Visual Arts</option>
                    <option value="Literature">Literature</option>
                    <option value="Music">Music</option>
                    <option value="Natural Sciences">Natural Sciences</option>
                    <option value="Computing">Computing</option>
                    <option value="Math">Math</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Business">Business</option>
                    <option value="Law">Law</option>
                    <option value="Language">Language</option>
                </select>
            </div>
            <div class="form_element">
                <label>Associated Keele Module Code:</label>
                <select class="form-record_select" id="module_code" name="module_code" value='<?=$data_array[$isbn]["module_code"]?>'>
                    <!-- <option value=""> -->
                    <option value="LSC">LSC</option>
                    <option value="CSC">CSC</option>
                    <option value="OTHER">OTHER</option>
                </select>
            </div>
            <br><br>
            <input type="submit" class="form-submit_button">
        </form>

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