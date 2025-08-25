<?php
    session_start();    //  Commences the use of Sessions

    // If already loggedin, go to the "list_page_script.php"
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) header("Location: ./list_page_script.php");
    if (isset($_GET['register_msg']))
    {
        $regmsg = $_GET['register_msg'];
    }
    else{
        $regmsg = "";
    }
?>

<!DOCTYPE HTML><html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="../../../main/_css_styles/Login.css">
    </head>

    <body>
        <div id="login_card">
            <h2>Register Page</h2>
            
            <p>Register With Your Username and Password</p>
    
            <form class="details_form" action="../_server-scripts/register_script.php" method="POST">
                <div class="form_element">
                    <label>Username:</label> 
                    <input type="text" name="username">
                </div>
                <div class="form_element">
                    <label>Password:</label>
                    <input type="password" name="password">
                </div>
                <div class="form_element">
                    <label>Reenter Password:</label>
                    <input type="password" name="re-password">
                </div>
                <?php
                    if ($regmsg){
                        $regmsg = ucwords($regmsg);
                        echo '<p style="font-size:0.8rem">Notice: <b>' . $regmsg . '</b></p>';
                        $_GET['register_msg'] = "";
                        $regmsg = "";
                    }
                ?>
                <input class="details_form_button" type="submit" class="form-submit_button">
            </form>
            <br>
            <br>
            <br>
            <br>
            <br>
            <p>Already have an account? Login <a href="./login_page.php">here</a></p>
        </div>
    </body>
</html>