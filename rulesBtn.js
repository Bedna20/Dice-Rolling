document.getElementById("rules").addEventListener("click", function() {
    const panel = document.getElementById("rulesPanel");
    panel.classList.toggle("hidden");
    this.textContent = panel.classList.contains("hidden") ? "Rules ▾" : "Rules ▴";
})