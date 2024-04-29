// Fonction pour mettre à jour les valeurs des balises input
  function updateValues(data) {
    const { cpu, ram, network } = JSON.parse(data);
    $(".dial1").val(cpu).trigger('change');
    $(".dial2").val(ram).trigger('change');
    $(".dial3").val(network).trigger('change');
  }

  // Appel AJAX pour récupérer les données du serveur
  function fetchData() {
    fetch('metrics.rb')
      .then(response => response.json())
      .then(data => updateValues(data))
      .catch(error => console.error('Erreur lors de la récupération des données :', error));
  }

  // Actualiser les données toutes les X secondes
  setInterval(fetchData, 5000); // Mettez ici la fréquence d'actualisation souhaitée en millisecondes

  // Appel initial pour charger les données une fois la page chargée
  window.onload = fetchData;