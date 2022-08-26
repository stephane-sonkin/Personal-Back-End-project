window.onload = () => {
    
    let boutons = document.querySelector(".form-check-input")

    for(let bouton of boutons) {
        bouton.addEventListener("click", activer)
    }
}

function activer() {
    
    let xmlhttp = new XMLHttpRequest;

    xmlhttp.open('GET', '/POO_BD/Public/index.php/admin/activeAnnonce/'+this.dataset.id)

    xmlhttp.send()
}