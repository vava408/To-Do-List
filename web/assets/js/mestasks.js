let allTasks = [];
let currentFilter = 'all';
// Charger les tâches
fetch('..//dashboardData/dahboardData.php?pages=mesTasks', {
	credentials: 'include'
})
.then(response => response.json())
.then(data => {
	allTasks = data.mesTasks;
	renderTasks();
})
.catch(error => console.error("Erreur lors du chargement des tâches :", error));
// Rendu des tâches
function renderTasks(filter = 'all', searchTerm = '') {
	const taskList = document.getElementById('taskList');
	const taskCounter = document.getElementById('taskCounter');
	taskList.innerHTML = '';
	// Filtrer les tâches
	let filteredTasks = allTasks;
	
	if (filter !== 'all') {
		filteredTasks = filteredTasks.filter(task => task.status === filter);
	}
	if (searchTerm) {
		filteredTasks = filteredTasks.filter(task => 
			task.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
			(task.description && task.description.toLowerCase().includes(searchTerm.toLowerCase()))
		);
	}
	// Trier par date d'échéance
	filteredTasks.sort((a, b) => new Date(a.due_date) - new Date(b.due_date));
	// Afficher le compteur
	taskCounter.textContent = `${filteredTasks.length} tâche(s) affichée(s)`;
	// Afficher les tâches
	if (filteredTasks.length === 0) {
		taskList.innerHTML = '<div class="empty-state">Aucune tâche trouvée</div>';
		return;
	}
	filteredTasks.forEach(task => {
		const li = document.createElement('li');
		let emoji = '⏳';
		let statusClass = 'not_started';
		let statusText = 'À faire';
		if (task.status === 'completed') {
			emoji = '✅';
			statusClass = 'completed';
			statusText = 'Terminée';
		} else if (task.status === 'in_progress') {
			emoji = '🕓';
			statusClass = 'in_progress';
			statusText = 'En cours';
		}
		// Vérifier si la date est dépassée
		const isOverdue = new Date(task.due_date) < new Date() && task.status !== 'completed';
		const dueDateText = isOverdue ? `⚠️ ${task.due_date} (en retard)` : task.due_date;
		li.classList.add(statusClass);
		li.innerHTML = `
			<span class="emoji">${emoji}</span>
			<div class="task-content">
				<strong>${task.title}</strong>
				<p>${task.description ? task.description : '<em>Aucune description</em>'}</p>
				<div class="task-meta">
					<span>📅 ${dueDateText}</span>
					<span>📊 ${statusText}</span>
				</div>
			</div>
		`;
		taskList.appendChild(li);
	});
}
// Gestion des filtres
document.querySelectorAll('.filter-btn').forEach(btn => {
	btn.addEventListener('click', function() {
		document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
		this.classList.add('active');
		currentFilter = this.dataset.filter;
		const searchTerm = document.getElementById('searchInput').value;
		renderTasks(currentFilter, searchTerm);
	});
});
// Gestion de la recherche
document.getElementById('searchInput').addEventListener('input', function(e) {
	renderTasks(currentFilter, e.target.value);
});