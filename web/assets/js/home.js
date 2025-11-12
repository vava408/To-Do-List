import { changerButtonConnexion } from "./bouttonConnexion.js";
 
 // Envoie une requête HTTP pour récupérer les informations de l'utilisateur depuis le fichier user.php
fetch('..//dashboardData/dahboardData.php?pages=home', {
	credentials: 'include'
})
// Lorsque la réponse est reçue, on la convertit en objet JavaScript (format JSON)
.then(response => response.json())

// Quand les données sont prêtes, on les utilise
.then(data => {
	// On extrait le nom d'utilisateur de l'objet JSON
	const user = data.user;
	const totalTasks = data.stat.nbTasks;
	const totalTasksComp = data.stat.nbTasksCompleted;
	const totalTasksEnCours = data.stat.nbTasksEnCours;
	const totalTaskNotStart      = data.stat.nbTaskNotStart;
	const lastTaskFinish = data.lastTask.completed;
	const lastTaskInProgresse = data.lastTask.inProgresse;
	const lastTaskNotStart = data.lastTask.notStated;
	// On met à jour le texte de l'élément HTML avec l'id "welcome"
	// pour dire "Bienvenue, [nom de l'utilisateur] 👋"
	document.getElementById('welcome').innerText = `Bienvenue, ${user} 👋`;
	document.getElementById('totalTasks').innerText = totalTasks;
	document.getElementById('completedTasks').innerText = totalTasksComp;
	document.getElementById('ongoingTasks').innerText = totalTasksEnCours;
	document.getElementById('notStartedTasks').innerText = totalTaskNotStart;
	document.getElementById('task-end').innerText = lastTaskFinish;
	document.getElementById('task-in-progresse').innerText = lastTaskInProgresse;
	document.getElementById('task-not-start').innerText = lastTaskNotStart;
	if(user === 'Guest')
	{
		changerButtonConnexion();
	}
	console.log(`Bienvenue, ${user} 👋`);
	console.log(`Total des tâches : ${totalTasks}`);
	console.log(data);
});