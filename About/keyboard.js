document.addEventListener("keydown", function(e) {
    if (e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
        return;
    }

    if (e.code === "Backspace" || e.key === "Backspace") {
        const back = document.getElementById("back");
        if (back) {
            back.click();
        }
    }
});