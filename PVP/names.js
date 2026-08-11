(function () {
    const p1 = localStorage.getItem("player1Name") || "Player 1";
    const p2 = localStorage.getItem("player2Name") || "Player 2";

    document.querySelectorAll(".player1score").forEach(el => {
        el.textContent = el.textContent.replace("Player 1", p1);
    });
    document.querySelectorAll(".player2score").forEach(el => {
        el.textContent = el.textContent.replace("Player 2", p2);
    });

    document.querySelectorAll(".turn").forEach(el => {
        el.textContent = el.textContent.replace("Player 1", p1);
        el.textContent = el.textContent.replace("Player 2", p2);
    });

    document.querySelectorAll(".result.PVP").forEach(el => {
        el.textContent = el.textContent.replace("Player 1", p1);
        el.textContent = el.textContent.replace("Player 2", p2);
    });
})();