<?php
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
if(isset($_SESSION['user_id'])){

}else{
    //header('Location: sign-in');
    ?>
    <script type="text/javascript">
        window.location.href="index";
    </script>
    <?php
    exit();
}