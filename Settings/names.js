document.getElementById("name1").value = localStorage.getItem("player1Name" || "");
document.getElementById("name2").value = localStorage.getItem("player2Name" || "");

document.getElementById("saveNames").addEventListener("click", () => {
    const name1 = document.getElementById("name1").value.trim() || "Player 1";
    const name2 = document.getElementById("name2").value.trim() || "Player 2";

    localStorage.setItem("player1Name", name1);
    localStorage.setItem("player2Name", name2);
});