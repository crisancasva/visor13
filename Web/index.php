<?php
    session_start();
    include_once '../view/partials/head.php';
    include_once '../lib/helpers.php';
    include_once '../view/partials/scripts.php';

    echo "<body>";
        echo "<div class='wrapper'>";
            include_once '../view/partials/sidebar.php';

            echo "<div class='main-panel'>";
                echo "<div class='main-header'>";
                    include_once '../view/partials/navbar.php';
                echo "</div>";

                echo "<div class='container'>";
                    echo "<div class='page-inner'>";
                        if(isset($_GET['modulo'])){
                            resolve();
                        }else{
                            include_once '../view/Principal/geovisor.php';    
                        }
                    echo "</div>";
                echo "</div>";

                include_once '../view/partials/footer.php';
            echo "</div>";
        echo "</div>";
    echo "</body>";
    echo "</html>";

?>