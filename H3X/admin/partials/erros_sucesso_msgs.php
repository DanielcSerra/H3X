<?php
            if (!empty($_SESSION["success"])) {
                echo "<div class='alert alert-success fade-out'>" . $_SESSION["success"] . "</div>";
                unset($_SESSION["success"]);
            }
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger fade-out'>$erro</div>";
                }
                unset($_SESSION["errors"]);
            }
            ?>
