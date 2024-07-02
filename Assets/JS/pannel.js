    const sidePanel = document.getElementById("sidePanel");
    const overlay = document.getElementById("overlay");
    const panelButton = document.getElementById("toggle-btn");

    // Fonction pour ouvrir et fermer le panneau
    panelButton.onclick = function() {
        if (sidePanel.style.width === "250px") {
            sidePanel.style.width = "0";
            overlay.style.display = "none";
        } else {
            sidePanel.style.width = "250px";
            overlay.style.display = "block";
        }
    }

    // Fermer le panneau lorsque l'utilisateur clique sur l'overlay
    overlay.onclick = function() {
        sidePanel.style.width = "0";
        overlay.style.display = "none";
    }

    // Fermer le panneau lorsqu'on clique en dehors de celui-ci
    document.addEventListener('click', function(event) {
        const isClickInside = sidePanel.contains(event.target) || panelButton.contains(event.target);

        if (!isClickInside) {
            sidePanel.style.width = "0";
            overlay.style.display = "none";
        }
    });