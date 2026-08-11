document.addEventListener("keydown", function(e) {
    if (e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
        return;
    }

    if (e.code === "Space" || e.key === " ") {
        e.preventDefault();

        const rollBtn = document.getElementById("roll");
        if (rollBtn && !rollBtn.disabled) {
            rollBtn.click();
            return;
        }
    }

    if (e.key === "Enter" || e.key.toLowerCase() === "n") {
        const newGameBtn = document.getElementById("newgame");
        if (newGameBtn) {
            newGameBtn.click();
        }
    }

    if (e.code === "Backspace" || e.key === "Backspace") {
        const back = document.getElementById("back");
        if (back) {
            back.click();
        }
    }
});