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
        <h1>Play VS Computer</h1>

        <?php
            session_start();
            $winPoints = $_SESSION["winPointsPVC"] ?? 25;

            if (!isset($_SESSION["playerscore"])) {
                $_SESSION["playerscore"] = 0;
            }

            if (!isset($_SESSION["pcscore"])) {
                $_SESSION["pcscore"] = 0;
            }

            if (!isset($_SESSION["gameStarted"])) {
                $_SESSION["gameStarted"] = false;
                $_SESSION["playerscore"] = 0;
                $_SESSION["pcscore"] = 0;
                $_SESSION["currentTurn"] = 1;
            }

            if (isset($_POST["newgame"])) {
                $_SESSION["playerscore"] = 0;
                $_SESSION["pcscore"] = 0;
                $_SESSION["freshGame"] = true;
                $_SESSION["gameStarted"] = true;
                $_SESSION["currentTurn"] = 1;

                unset($_SESSION["lastPlayerDice"]);
                unset($_SESSION["lastPCDice"]);
                unset($_SESSION["winCounted"]);
                unset($_SESSION["drawCounted"]);
                unset($_SESSION["loseCounted"]);
                unset($_SESSION["animate"]);
                unset($_SESSION["lastRoll"]);
                unset($_SESSION["pcWaiting"]);

                unset($_SESSION["score1"], $_SESSION["score2"]);
                unset($_SESSION["lastDice1"], $_SESSION["lastDice2"]);

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            if (isset($_POST["roll"])) {
                $_SESSION["freshGame"] = false;
                $now = microtime(true);
            
                if (isset($_SESSION["lastRoll"])) {
                    if ($now - $_SESSION["lastRoll"] < 0.5) {
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit;
                    }
                }

                $_SESSION["lastRoll"] = $now;
            

                if ($_SESSION["currentTurn"] === 1) {
                    if ($_SESSION["playerscore"] < $winPoints) {
                        if ($_SESSION["pcscore"] < $winPoints) {
                            $playerdice = rand(1, 6);

                            if ($_SESSION["playerscore"] + $playerdice <= $winPoints) {
                                $_SESSION["playerscore"] = $_SESSION["playerscore"] + $playerdice;
                            }

                            $_SESSION["lastPlayerDice"] = $playerdice;
                            $_SESSION["animate"] = "player";

                            if ($_SESSION["playerscore"] < $winPoints) {
                                $_SESSION["currentTurn"] = 2;
                                $_SESSION["pcWaiting"] = true;
                            } else {
                                $_SESSION["currentTurn"] = 1;
                                unset($_SESSION["pcWaiting"]);
                            }
                        }
                    }
                }

                if ($_SESSION["playerscore"] == $winPoints) {
                    if ($_SESSION["pcscore"] != $winPoints) {
                        if (empty($_SESSION["winCounted"])) {
                            $wins = isset($_COOKIE["wins"]) ? (int)$_COOKIE["wins"] + 1 : 1;
                            setcookie("wins", $wins, time() + 86400 * 365, "/");

                            $total = isset($_COOKIE["total"]) ? (int)$_COOKIE["total"] + 1 : 1;
                            setcookie("total", $total, time() + 86400 * 365, "/");

                            $streak = isset($_COOKIE["streak"]) ? (int)$_COOKIE["streak"] + 1 : 1;
                            setcookie("streak", $streak, time() + 86400 * 365, "/");

                            $bestStreak = isset($_COOKIE["bestStreak"]) ? (int)$_COOKIE["bestStreak"] : 0;
                            if ($streak > $bestStreak) {
                                setcookie("bestStreak", $streak, time() + 86400 * 365, "/");
                            }

                            $_SESSION["winCounted"] = true;
                        }
                    } else {
                        if (empty($_SESSION["drawCounted"])) {
                            $draws = isset($_COOKIE["draws"]) ? (int)$_COOKIE["draws"] + 1 : 1;
                            setcookie("draws", $draws, time() + 86400 * 365, "/");

                            $total = isset($_COOKIE["total"]) ? (int)$_COOKIE["total"] + 1 : 1;
                            setcookie("total", $total, time() + 86400 * 365, "/");

                            setcookie("streak", 0, time() + 86400 * 365, "/");

                            $_SESSION["drawCounted"] = true;
                        }
                    }
                }

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }
        
            if ($_SESSION["gameStarted"]) {
                if ($_SESSION["currentTurn"] === 2) {
                    if (empty($_SESSION["pcWaiting"])) {
                        if ($_SESSION["playerscore"] < $winPoints) {
                            if ($_SESSION["pcscore"] < $winPoints) {
                                $pcdice = rand(1,6);
                                if ($_SESSION["pcscore"] + $pcdice <= $winPoints) {
                                    $_SESSION["pcscore"] = $_SESSION["pcscore"] + $pcdice;
                                }

                                $_SESSION["lastPCDice"] = $pcdice;
                                $_SESSION["currentTurn"] = 1;
                                $_SESSION["animate"] = "pc";
                                $_SESSION["freshGame"] = false;

                                if ($_SESSION["pcscore"] == $winPoints) {
                                    if ($_SESSION["playerscore"] != $winPoints) {
                                        if (empty($_SESSION["loseCounted"])) {
                                            $lose = isset($_COOKIE["lose"]) ? (int)$_COOKIE["lose"] + 1 : 1;
                                            setcookie("lose", $lose, time() + 86400 * 365, "/");

                                            $total = isset($_COOKIE["total"]) ? (int)$_COOKIE["total"] + 1 : 1;
                                            setcookie("total", $total, time() + 86400 * 365, "/");

                                            setcookie("streak", 0, time() + 86400 * 365, "/");
                                            
                                            $_SESSION["loseCounted"] = true;
                                        }
                                    } else {
                                        if (empty($_SESSION["drawCounted"])) {
                                            $draws = isset($_COOKIE["draws"]) ? (int)$_COOKIE["draws"] + 1 : 1;
                                            setcookie("draws", $draws, time() + 86400 * 365, "/");

                                            $total = isset($_COOKIE["total"]) ? (int)$_COOKIE["total"] + 1 : 1;
                                            setcookie("total", $total, time() + 86400 * 365, "/");

                                            setcookie("streak", 0, time() + 86400 * 365, "/");

                                            $_SESSION["drawCounted"] = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            if ($_SESSION["gameStarted"]) {
                if ($_SESSION["playerscore"] == $winPoints && $_SESSION["pcscore"] != $winPoints) {
                    echo "<div class=\"result player\">" . "You win" . "</div>";
                } elseif ($_SESSION["pcscore"] == $winPoints && $_SESSION["playerscore"] != $winPoints) {
                    echo "<div class=\"result pc\">" . "PC win" . "</div>";
                } elseif ($_SESSION["playerscore"] == $winPoints && $_SESSION["pcscore"] == $winPoints) {
                    echo "<div class=\"result draw\">" . "Draw" . "</div>";
                } else {
                    if (!empty($_SESSION["freshGame"])) {
                        echo "<div class=\"turn\">You to play</div>";
                    } else {
                        if ($_SESSION["currentTurn"] === 1) {
                            echo "<div class=\"turn animate\">You to play</div>";
                        } else {
                            echo "<div class=\"turn animate\">PC to play</div>";
                        }
                    }
                }

                $playerAnim = (!empty($_SESSION["animate"]) && $_SESSION["animate"] === "player") ? " animate" : "";
                $pcAnim = (!empty($_SESSION["animate"]) && $_SESSION["animate"] === "pc") ? " animate" : "";

                if (isset($_SESSION["lastPlayerDice"])) {
                    if ($_SESSION["currentTurn"] == 2) {
                        echo "<div id=\"diceroll\" class=\"dice playerdice" . $playerAnim . "\">" . $_SESSION["lastPlayerDice"] . "</div>";
                    } else {
                        echo "<div class=\"dice playerdice" . $playerAnim . "\">" . $_SESSION["lastPlayerDice"] . "</div>";
                    }
                }
                if (isset($_SESSION["lastPCDice"])) {
                    if ($_SESSION["currentTurn"] == 1) {
                        if ($_SESSION["playerscore"] == $winPoints && $_SESSION["pcscore"] != $winPoints) {
                            echo "<div class=\"dice pcdice" . $pcAnim . "\">" . $_SESSION["lastPCDice"] . "</div>";
                        } else {
                            echo "<div id=\"diceroll\" class=\"dice pcdice" . $pcAnim . "\">" . $_SESSION["lastPCDice"] . "</div>";
                        }
                    } else {
                        echo "<div class=\"dice pcdice" . $pcAnim . "\">" . $_SESSION["lastPCDice"] . "</div>";
                    }
                }

                echo "<div></div>";

                $playerScoreAnim = (!empty($_SESSION["animate"]) && $_SESSION["animate"] === "player") ? " animate" : "";
                $pcScoreAnim = (!empty($_SESSION["animate"]) && $_SESSION["animate"] === "pc") ? " animate" : "";


                if ($_SESSION["currentTurn"] == 2) {
                    if ($_SESSION["freshGame"] == false) {
                        echo "<div class=\"score playerscore animate" . $playerScoreAnim . "\">" . "You: " . ($_SESSION["playerscore"]) . "</div>";
                    } else {
                        echo "<div class=\"score playerscore" . $playerScoreAnim . "\">" . "You: " . ($_SESSION["playerscore"]) . "</div>";
                    }
                } else {
                    echo "<div class=\"score playerscore" . $playerScoreAnim . "\">" . "You: " . ($_SESSION["playerscore"]) . "</div>";
                }

                if ($_SESSION["currentTurn"] == 1) {
                    if ($_SESSION["freshGame"] == false) {
                        echo "<div class=\"score pcscore animate" . $pcScoreAnim . "\">" . "PC: " . ($_SESSION["pcscore"]) . "</div>";
                    } else {
                        echo "<div class=\"score pcscore" . $pcScoreAnim . "\">" . "PC: " . ($_SESSION["pcscore"]) . "</div>";
                    }
                } else {
                    if ($_SESSION["pcscore"] != 0) {
                        echo "<div class=\"score pcscore" . $pcScoreAnim . "\">" . "PC: " . ($_SESSION["pcscore"]) . "</div>";
                    }
                }

                

                unset($_SESSION["animate"]);
            } else {
                echo "<p>Press <strong>New game</strong> to start</p>";
            }

            if (!empty($_SESSION["pcWaiting"])) {
                unset($_SESSION["pcWaiting"]);

                echo "<script src=\"pcDelay.js\"></script>";
            }
        ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" id="form">
            <input type="submit" class="PVC" value="Roll" name="roll" id="roll" <?php if (!$_SESSION["gameStarted"] || $_SESSION["currentTurn"] !== 1 || $_SESSION["playerscore"] == $winPoints || $_SESSION["pcscore"] == $winPoints) {echo "disabled";} ?>>
            <input type="submit" class="PVC" value="New game" name="newgame" id="newgame">
        </form>

        <a href="../" class="back" id="back">←</a>

        <script src="animate.js"></script>
        <script src="keyboard.js"></script>

        <footer>&copy; 2026 Made by Bedna20</footer>
    </body>
</html>