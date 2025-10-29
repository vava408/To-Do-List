// Envoie une requête HTTP pour récupérer les informations de l'utilisateur depuis le fichier user.php
fetch('..//dashboardData/dahboardData.php?pages=profile', {
	credentials: 'include'
})
	// Lorsque la réponse est reçue, on la convertit en objet JavaScript (format JSON)
	.then(response => response.json())
	// Quand les données sont prêtes, on les utilise
	.then(data => {
		const user = data.user;
		const date = data.date;
		const mail = data.mail;
		const totalTasksComp = data.nbTasksCompleted;
		const totalTasksEnCours = data.nbTasksEnCours;
		const nbTask = data.nbTasks;
		document.getElementById('userName').innerText = user;
		document.getElementById('userEmail').innerText = mail;
		document.getElementById('emailInfo').innerText = mail;
		document.getElementById('memberSince').innerText = date;
		
		document.getElementById("tasksCreated").innerText = nbTask;
		document.getElementById('tasksCompleted').innerText = totalTasksComp;
		document.getElementById('tasksPending').innerText = totalTasksEnCours;
		document.getElementById('editProfileBtn').addEventListener('click', () => {
			window.location.href = 'modifierProfil.html';
		})
		document.getElementById('editPassBtn').addEventListener('click', () => {
			window.location.href = 'modifPassword.html';
		})
		document.getElementById('deleteProfileBtn').addEventListener('click', () => {
			window.location.href = '../auth/deleteUser.php';
		})
	})