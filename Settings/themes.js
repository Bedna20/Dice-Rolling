const themes = [
    { id: "default", name: "Forest", file: "../themes/styleForest.css"},
    { id: "ocean", name: "Ocean", file: "../themes/styleOcean.css"},
    { id: "spring", name: "Spring", file: "../themes/styleSpring.css"},
    { id: "coffee", name: "Coffee", file: "../themes/styleCoffee.css"}
];

const themeLink = document.getElementById("themeCSS");
const grid = document.getElementById("themesGrid");

function setTheme(themeID) {
    const theme = themes.find(t => t.id === themeID) || themes[0];

    themeLink.href = theme.file;
    localStorage.setItem("diceTheme", theme.id);

    document.querySelectorAll(".themeBtn").forEach(btn => {
        btn.classList.toggle("active", btn.dataset.id === theme.id);
    });
}

themes.forEach(theme => {
    const btn = document.createElement("button");
    btn.className = "themeBtn";
    btn.dataset.id = theme.id;
    btn.textContent = theme.name;
    btn.addEventListener("click", () => setTheme(theme.id));
    grid.appendChild(btn);
});

const saved = localStorage.getItem("diceTheme") || "default";
setTheme(saved);