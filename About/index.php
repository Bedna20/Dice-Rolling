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
        <h1>About</h1>
            
        <div class="aboutPanel">
            <p>Simple game made primarily using PHP</p>
            <p>There are 2 game modes: you can play with a friend localy or play with computer</p>
            <p>By default you need to reach exactly 25 points by rolling your dice, but you can change that in settings</p>
            <p>Each round everyone rolls a dice (1 - 6), points are added to the score as long as it stays below or equal to the target score</p>
            <p>First one to hit 25 points (or your desired win points changed in the settings) wins</p>
            <p>After someone wins you need to start new game</p>
            <p>I made 4 different themes, you can change it in the <strong>settings</strong> (bottom-right corner), you can also change player names, points needed to win and of course reset the settings to default</p>
            <p>You can see stats under <strong>Your stats</strong></p>
            <p>Stats are only made from <strong>Play with computer</strong> game mode</p>
            <p>Game tracks: total games played, win rate, current win streak, best win streak, wins and losses</p>
            <p>If you want to reset your stats you can do it by clicking <strong>Reset stats</strong> button (bottom-right corner)</p>
            <p>You can press <strong>Space</strong> or <strong>Roll</strong> button to roll your dice</p>
            <p>Press <strong>New game</strong>, <strong>Enter</strong> or <strong>N</strong> to start new game</p>
            <p>You can also press <strong>Backspace</strong> to get back to main menu</p>
        </div>

        <a href="../" class="back" id="back">←</a>

        <script src="keyboard.js"></script>

        <footer>&copy; 2026 Made by Bedna20</footer>
    </body>
</html>