function rand(min, max) {
    return Math.floor(Math.random() * ((max - min) + 1)) + min;
}

const dice = document.getElementById("diceroll");
var diceValue = dice.innerHTML;

for (let i = 0; i < 10; i++) {
    setTimeout(function() {
        dice.innerHTML = rand(1, 6);
    }, 100 * (i + 1));
}

setTimeout(function() {
    dice.innerHTML = diceValue;
}, 1010);