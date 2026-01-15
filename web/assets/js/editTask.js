// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
	// Récupérer les paramètres de l'URL
	const urlParams = new URLSearchParams(window.location.search);
	const idTask = urlParams.get('idTask');


	fetch('..//dashboardData/dahboardData.php?pages=editTask&idTask=' + idTask, {
		credentials: 'include'
	})

		.then(response => response.json())

		// Quand les données sont prêtes, on les utilise
		.then(data => {
			console.log(data);

			const id = data.task.id;
			const task = data.task.title;
			const taskDescription = data.task.description;
			const taskDueDate = data.task.due_date;
			const date =  taskDueDate.split(' ')[0];
			const status = data.task.status;
			let priority;
			
			switch(data.task.priority) {
				case 1:
					priority = "Importante";
					break;
				case 2:
					priority = "Moyenne";
					break;
				case 3:
					priority = "Faible";
					break;
				default:
					priority = "Faible";
			}

			


			console.log(priority, data.task.priority);
			

			// Remplir le formulaire avec les données de la tâche
			document.getElementById('title').value = task;
			document.getElementById('description').value = taskDescription;
			document.getElementById('due_date').value = date;
			document.getElementById('status').value = status;
			document.getElementById('task_id').value = id;
			document.getElementById('priority').value = priority;
		});

	// Gestion de la soumission du formulaire
	document.getElementById('editTaskForm').addEventListener('submit', function(e) {
		e.preventDefault();
		
		const formData = new FormData(this);
		
		fetch('../tasks/uptadeTask.php', {
			method: 'POST',
			body: formData,
			credentials: 'include'
		})
		.then(response => response.json())
		.then(data => {
			const messageDiv = document.getElementById('message');
			
			if (data.success) {
				messageDiv.textContent = data.success;
				messageDiv.style.color = "green";
				
				// Rediriger vers la liste des tâches après 1.5 secondes
				setTimeout(() => {
					window.location.href = 'mestasks.html';
				}, 1500);
			} else if (data.error) {
				messageDiv.textContent = data.error;
				messageDiv.style.color = "red";
			}
		})
		.catch(error => {
			const messageDiv = document.getElementById('message');
			messageDiv.textContent = "Erreur lors de la mise à jour de la tâche.";
			messageDiv.style.color = "red";
			console.error('Erreur:', error);
		});
	});
});