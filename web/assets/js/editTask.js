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
				priority = "moyenne";
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