if (new URLSearchParams(window.location.search).get("reset") === "1") {
    localStorage.setItem("player1Name", "Player 1");
    localStorage.setItem("player2Name", "Player 2");

    localStorage.setItem("diceTheme", "default");

    history.replaceState(null, "", window.location.pathname);

    setTimeout(function() {
        window.location.reload();
    }, 10);
}