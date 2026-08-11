document.addEventListener("keydown", function(e) {
    if (e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
        return;
    }

    if (e.code === "Space" || e.key === " ") {
        e.preventDefault();

        const roll1 = document.getElementById("roll1");
        const roll2 = document.getElementById("roll2");

        if (roll1 && !roll1.disabled) {
            roll1.click();
        } else if (roll2 && !roll2.disabled) {
            roll2.click();
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