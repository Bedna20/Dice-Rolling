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
                    default: "themes/styleForest.css",
                    ocean: "themes/styleOcean.css",
                    spring: "themes/styleSpring.css",
                    coffee: "themes/styleCoffee.css"
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
        <h1>Dice rolling</h1>

        <a href="PVP/" class="navigator">Play with friend</a>
        <div></div>
        <a href="PVC/" class="navigator">Play with computer</a>
        <div></div>
        <a href="Stats/" class="navigator">Your stats</a>
        <div></div>
        <a href="About/" class="navigator">About</a>
        <div></div>

        <?php
            if (isset($_POST["hideCookie"])) {
                setcookie("cookieBaner", 1, time() + 86400 * 365, "/");

                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            }

            if (!isset($_COOKIE["cookieBaner"])) {
                echo "<form class=\"cookies\" action=\"index.php\" method=\"post\">";
                echo "    <p class=\"cookies\">This site uses cookies. More info <strong><a href=\"Cookies/\" class=\"cookies\">here</a></strong>.</p>";
                echo "    <input class=\"cookies\" type=\"submit\" name=\"hideCookie\" value=\"X\">";
                echo "</form>";
            }
        ?>

        <a href="Settings/" class="settings">⚙️</a>

        <footer>&copy; 2026 Made by Bedna20</footer>
    </body>
</html>