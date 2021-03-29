fetch("https://call-of-duty-modern-warfare.p.rapidapi.com/warzone/Amartin743/psn", {
    "method": "GET",
    "headers": {
        "x-rapidapi-key": "8ae2996f1fmshc9e2b8df53d7cc3p1c4dc5jsnaa9e2fa5517f",
        "x-rapidapi-host": "call-of-duty-modern-warfare.p.rapidapi.com"
    }
})
    .then (response => response.json())
    .then(response => {
        console.log(response);

        document.getElementById('games').innerHTML = response.br_all.gamesPlayed;
        document.getElementById('kd').innerHTML = response.br_all.kdRatio ;
    })
    .catch(err => {
        console.error(err);
    });