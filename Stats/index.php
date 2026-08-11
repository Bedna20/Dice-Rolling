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
        <h1>Stats</h1>

        <?php
            if (isset($_POST["reset"])) {
                setcookie("wins", 0, time() - 3600, "/");
                setcookie("draws", 0, time() - 3600, "/");
                setcookie("lose", 0, time() - 3600, "/");
                setcookie("total", 0, time() - 3600, "/");
                setcookie("streak", 0, time() - 3600, "/");
                setcookie("bestStreak", 0, time() - 3600, "/");

                unset($_COOKIE["total"]);
                unset($_COOKIE["wins"]);
                unset($_COOKIE["draws"]);
                unset($_COOKIE["lose"]);
                unset($_COOKIE["streak"]);
                unset($_COOKIE["bestStreak"]);

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            if (isset($_COOKIE["total"])) {
                echo ("<div class=\"stats total\">" . "Games played: " . (int)($_COOKIE["total"]) . "</div>");
            } else {
                echo ("<div class=\"stats total\">" . "You need to play some games against computer to see your stats" . "</div>");
            }

            if (isset($_COOKIE["wins"]) && isset($_COOKIE["total"])) {
                $winRate = round((int)($_COOKIE["wins"]) / (int)($_COOKIE["total"]) * 100, 2);

                if ($winRate >= 66.7) {
                    echo ("<div class=\"stats winRate high\">" . "Win rate: " . $winRate . " %</div>");
                } elseif ($winRate >= 33.3) {
                    echo ("<div class=\"stats winRate medium\">" . "Win rate: " . $winRate . " %</div>");
                } elseif ($winRate >= 0) {
                    echo ("<div class=\"stats winRate low\">" . "Win rate: " . $winRate . " %</div>");
                }
            }

            if (!isset($_COOKIE["wins"]) && isset($_COOKIE["lose"]) && isset($_COOKIE["total"])) {
                $winRate = (0);

                if ($winRate >= 66.7) {
                    echo ("<div class=\"stats winRate high\">" . "Win rate: " . $winRate . " %</div>");
                } elseif ($winRate >= 33.3) {
                    echo ("<div class=\"stats winRate medium\">" . "Win rate: " . $winRate . " %</div>");
                } elseif ($winRate >= 0) {
                    echo ("<div class=\"stats winRate low\">" . "Win rate: " . $winRate . " %</div>");
                }
            }

            if (isset($_COOKIE["streak"])) {
                echo ("<div class=\"stats streak\">" . "Current streak: " . (int)($_COOKIE["streak"]) . "</div>");
            }

            if (isset($_COOKIE["bestStreak"])) {
                echo ("<div class=\"stats bestStreak\">" . "Best streak: " . (int)($_COOKIE["bestStreak"]) . "</div>");
            }

            if (isset($_COOKIE["wins"])) {
                echo ("<div class=\"stats win\">" . "Wins: " . (int)($_COOKIE["wins"]) . "</div>");
            }

            if (isset($_COOKIE["draws"])) {
                echo ("<div class=\"stats draw\">" . "Draws: " . (int)($_COOKIE["draws"]) . "</div>");
            }

            if (isset($_COOKIE["lose"])) {
                echo ("<div class=\"stats lose\">" . "Losses: " . (int)($_COOKIE["lose"]) . "</div>");
            }

            if (isset($_COOKIE["total"])) {
                echo "<form class=\"reset\" action=\"index.php\" method=\"post\" onsubmit=\"return confirm('Reset all settings to default?\\n');\">";
                echo "    <input class=\"reset\" type=\"submit\" name=\"reset\" value=\"Reset stats\">";
                echo "</form>";
            }
        ?>

        <a href="../" class="back" id="back">←</a>

        <script src="keyboard.js"></script>

        <footer>&copy; 2026 Made by Bedna20</footer>
    </body>
</html>