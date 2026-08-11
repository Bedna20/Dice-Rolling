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

        <title>Dice Rolling</title>
    </head>
    <body>
        <h1>Settings</h1>

        <section class="themes">
            <h2>Themes</h2>
            <div class="themes" id="themesGrid">

            </div>
        </section>

        <section class="playerNames">
            <h2>Player names</h2>
            <div class="nameInputs">
                <label>
                    Player 1:
                    <input type="text" maxlenght="20" id="name1" placeholder="Player 1">
                </label>
                <div></div>
                <label>
                    Player 2:
                    <input type="text" maxlenght="20" id="name2" placeholder="Player 2">
                </label>
                <div></div>
                <button type="button" id="saveNames">Save Names</button>
            </div>
        </section>

        <?php
            session_start();
            $winPointsPVP = $_SESSION["winPointsPVP"] ?? 25;
            $winPointsPVC = $_SESSION["winPointsPVC"] ?? 25;

            if (isset($_POST["winPointsPVP"])) {
                $winPointsPVP = $_POST["winPointsPVPText"] ?? null;

                if (is_numeric($winPointsPVP)) {
                    if ($winPointsPVP >= 1 && $winPointsPVP <= 100) {
                        $_SESSION["winPointsPVP"] = (int)$winPointsPVP;
                        
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
                    }
                }

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            if (isset($_POST["winPointsPVC"])) {
                $winPointsPVC = $_POST["winPointsPVCText"] ?? null;

                if (is_numeric($winPointsPVC)) {
                    if ($winPointsPVC >= 1 && $winPointsPVC <= 100) {
                        $_SESSION["winPointsPVC"] = (int)$winPointsPVC;

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

                    }
                }

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            if (isset($_POST["resetSettings"])) {
                $_SESSION["winPointsPVP"] = 25;
                $_SESSION["winPointsPVC"] = 25;

                $_SESSION["score1"] = 0;
                $_SESSION["score2"] = 0;
                $_SESSION["playerscore"] = 0;
                $_SESSION["pcscore"] = 0;

                $_SESSION["currentTurn"] = 1;
                $_SESSION["freshGame"] = true;
                $_SESSION["gameStarted"] = true;

                unset($_SESSION["lastDice1"]);
                unset($_SESSION["lastDice2"]);

                unset($_SESSION["playerscore"]);
                unset($_SESSION["pcscore"]);
                unset($_SESSION["lastPlayerDice"]);
                unset($_SESSION["lastPCDice"]);

                unset($_SESSION["winCounted"]);
                unset($_SESSION["drawCounted"]);
                unset($_SESSION["loseCounted"]);
                unset($_SESSION["animate"]);
                unset($_SESSION["lastRoll"]);
                unset($_SESSION["pcWaiting"]);

                header("Location: " . $_SERVER["PHP_SELF"] . "?reset=1");
                exit;
            }
        ?>

        <h2>Win points</h2>

        <form action="index.php" method="post" class="winPoints">
            <label class="winPoints">
                PVP:
                <input type="number" name="winPointsPVPText" min="1" max="100" class="winPoints" placeholder="Win points" value="<?php echo isset($_SESSION["winPointsPVP"]) ? $_SESSION["winPointsPVP"] : 25 ; ?>">
            </label>
            <input type="submit" name="winPointsPVP" value="Save" class="winPoints">
        </form>

        <form action="index.php" method="post" class="winPoints">
            <label class="winPoints">
                PVC:
                <input type="number" name="winPointsPVCText" min="1" max="100" class="winPoints" placeholder="Win points" value="<?php echo isset($_SESSION["winPointsPVC"]) ? $_SESSION["winPointsPVC"] : 25 ; ?>">
            </label>
            <input type="submit" name="winPointsPVC" value="Save" class="winPoints">
        </form>

        <h2>Reset settings</h2>

        <form action="index.php" method="post" class="resetSettings" onsubmit="return confirm('Reset all settings to default?\n');">
            <label class="resetSettings">
                Reset settings to default:
                <input type="submit" name="resetSettings" value="Reset" class="resetSettings">
            </label>
        </form>

        <a href="../" class="back" id="back">←</a>

        <script src="names.js"></script>
        <script src="reset.js"></script>
        <script src="themes.js"></script>
        <script src="keyboard.js"></script>

        <footer>&copy; 2026 Made by Bedna20</footer>
    </body>
</html>