<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">

        <script>
            (function () {
                const themes = {
                    default: "../themes/styleForest.css",
                    ocean: "../themes/styleOcean.css",
                    spring: "../themes/styleSpring.css",
                    coffee: "../themes/styleCoffee.css"
                };
                const saved = localStorage.getItem("diceTheme") || "default";
                const file = themes[saved] || themes.default;

                const link = document.createElement("link");
                link.rel = "stylesheet";
                link.id = "themeCSS";
                link.href = file;
                document.head.appendChild(link);
            })();
        </script>

        <title>Dice rolling</title>
    </head>
    <body>
        <h1>Play with Friend</h1>

        <?php
            session_start();
            $winPoints = $_SESSION["winPointsPVP"] ?? 25;

            if (!isset($_SESSION["score1"])) {
                $_SESSION["score1"] = 0;
            }

            if (!isset($_SESSION["score2"])) {
                $_SESSION["score2"] = 0;
            }

            if (!isset($_SESSION["gameStarted"])) {
                $_SESSION["gameStarted"] = false;
                $_SESSION["score1"] = 0;
                $_SESSION["score2"] = 0;
                $_SESSION["currentTurn"] = 1;
            }

            if (isset($_POST["newgame"])) {
                $_SESSION["score1"] = 0;
                $_SESSION["score2"] = 0;
                $_SESSION["freshGame"] = true;
                $_SESSION["gameStarted"] = true;
                $_SESSION["currentTurn"] = rand(1, 2);

                unset($_SESSION["lastDice1"]);
                unset($_SESSION["lastDice2"]);
                unset($_SESSION["winCounted"]);
                unset($_SESSION["animate"]);

                unset($_SESSION["playerscore"], $_SESSION["pcscore"]);
                unset($_SESSION["lastPlayerDice"], $_SESSION["lastPCDice"]);
                unset($_SESSION["pcWaiting"], $_SESSION["loseCounted"]);

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            if (isset($_POST["roll1"]) || isset($_POST["roll2"])) {
                $_SESSION["freshGame"] = false;
                $now = microtime(true);

                if (isset($_SESSION["lastRoll"])) {
                    if ($now - $_SESSION["lastRoll"] < 0.5) {
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit;
                    }
                }
                $_SESSION["lastRoll"] = $now;

                $dice = rand(1, 6);

                if (isset($_POST["roll1"])) {
                    if ($_SESSION["currentTurn"] === 1) {
                        if ($_SESSION["score1"] + $dice <= $winPoints) {
                            $_SESSION["score1"] = $_SESSION["score1"] + $dice;
                        }

                        $_SESSION["lastDice1"] = $dice;
                        $_SESSION["currentTurn"] = 2;
                    }
                }

                if (isset($_POST["roll2"])) {
                    if ($_SESSION["currentTurn"] === 2) {
                        if ($_SESSION["score2"] + $dice <= $winPoints) {
                            $_SESSION["score2"] = $_SESSION["score2"] + $dice;
                        }

                        $_SESSION["lastDice2"] = $dice;
                        $_SESSION["currentTurn"] = 1;
                    }
                }

                $_SESSION["animate"] = true;

                if ($_SESSION["score1"] == $winPoints || $_SESSION["score2"] == $winPoints) {
                    # code...
                }

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }
        ?>

        <?php
            if ($_SESSION["gameStarted"]) {
                if ($_SESSION["score1"] == $winPoints) {
                    echo ("<div class=\"result PVP\">Player 1 wins</div>");
                } elseif ($_SESSION["score2"] == $winPoints) {
                    echo ("<div class=\"result PVP\">Player 2 wins</div>");
                } else {
                    if ($_SESSION["freshGame"] == false) {
                        echo ("<div class=\"turn animate\">Player " . $_SESSION["currentTurn"] . " to play</div>");
                    } else {
                        echo ("<div class=\"turn\">Player " . $_SESSION["currentTurn"] . " to play</div>");
                    }
                }

                if (isset($_SESSION["lastDice1"])) {
                    if ($_SESSION["currentTurn"] == 2) {
                        echo ("<div id=\"diceroll\" class=\"dice player1dice animate\">" . $_SESSION["lastDice1"] . "</div>");
                    } else {
                        echo ("<div class=\"dice player1dice\">" . $_SESSION["lastDice1"] . "</div>");
                    }
                }
            
                if (isset($_SESSION["lastDice2"])) {
                    if ($_SESSION["currentTurn"] == 1) {
                        echo ("<div id=\"diceroll\" class=\"dice player2dice animate\">" . $_SESSION["lastDice2"] . "</div>");
                    } else {
                        echo ("<div class=\"dice player2dice\">" . $_SESSION["lastDice2"] . "</div>");
                    }
                }

                echo "<div></div>";

                if ($_SESSION["currentTurn"] == 2) {
                    if ($_SESSION["freshGame"] == false) {
                        echo ("<div class=\"score player1score animate\">Player 1: " . $_SESSION["score1"] . "</div>");
                    } else {
                        echo ("<div class=\"score player1score\">Player 1: " . $_SESSION["score1"] . "</div>");
                    }
                } else {
                    echo ("<div class=\"score player1score\">Player 1: " . $_SESSION["score1"] . "</div>");
                }
        
                if ($_SESSION["currentTurn"] == 1) {
                    if ($_SESSION["freshGame"] == false) {
                        echo ("<div class=\"score player2score animate\">Player 2: " . $_SESSION["score2"] . "</div>");
                    } else {
                        echo ("<div class=\"score player2score\">Player 2: " . $_SESSION["score2"] . "</div>");
                    }
                } else {
                    echo ("<div class=\"score player2score\">Player 2: " . $_SESSION["score2"] . "</div>");
                }

            } else {
                echo "<p>Press <strong>New Game</strong> to start</p>";
            }

        ?>

        <form action="index.php" method="post" id="form">
            <input class="PVP" type="submit" value="Roll" name="roll1" id="roll1"
            <?php if (!$_SESSION["gameStarted"] || $_SESSION["currentTurn"] !== 1 || $_SESSION["score1"] == $winPoints || $_SESSION["score2"] == $winPoints) { echo "disabled"; } ?>>
            <input class="PVP" type="submit" value="Roll" name="roll2" id="roll2"
            <?php if (!$_SESSION["gameStarted"] || $_SESSION["currentTurn"] !== 2 || $_SESSION["score1"] == $winPoints || $_SESSION["score2"] == $winPoints) { echo "disabled"; } ?>>
            <div></div>
            <input class="PVP" type="submit" value="New game" name="newgame" id="newgame">
        </form>

        <a href="../" class="back" id="back">←</a>

        <script src="animate.js"></script>
        <script src="keyboard.js"></script>
        <script src="names.js"></script>

        <footer>&copy; 2026 Made by Bedna20</footer>
    </body>
</html>