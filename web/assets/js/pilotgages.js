// Envoie une requête HTTP pour récupérer les informations de l'utilisateur depuis le fichier user.php
fetch('..//dashboardData/dahboardData.php?pages=pilotage', {
	credentials: 'include'
})
	// Lorsque la réponse est reçue, on la convertit en objet JavaScript (format JSON)
	.then(response => response.json())
	// Quand les données sont prêtes, on les utilise
	.then(data => { 

    })