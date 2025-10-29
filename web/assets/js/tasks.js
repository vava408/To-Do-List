	fetch('..//dashboardData/dahboardData.php?pages=tasks', { credentials: 'include' })
		.then(response => response.json())
		.then(data => {
			// Mise à jour des statistiques
            //console.log(data)
			document.getElementById('totalTasks').innerText = data.stat.nbTasks;
			document.getElementById('completedTasks').innerText = data.stat.nbTasksCompleted;

			const tbody = document.getElementById("t-body");
			tbody.innerHTML = ""; // vider les lignes statiques

			data.task.forEach((task, index) => {
				const tr = document.createElement("tr");
				tr.id = `task-${index}`;

				// Colonne : titre
				const tdTitle = document.createElement("td");
				tdTitle.textContent = task.title;
				// associe a la ligne
				tr.appendChild(tdTitle);

				// Colonne : date limite
				const tdDate = document.createElement("td");
				tdDate.textContent = task.due_date || "Pas de date";
				// associe a la ligne
				tr.appendChild(tdDate);

				// Colonne : statut avec badge
				const tdStatus = document.createElement("td");
				const span = document.createElement("span");
				span.textContent = task.status;

				if (task.status === "completed") span.className = "badge complete";
				else if (task.status === "in_progress") span.className = "badge progress";
				else span.className = "badge not-started";

				// associe a la ligne
				tdStatus.appendChild(span);
				// associe a la ligne
				tr.appendChild(tdStatus);

				// associe a la ligne
				tbody.appendChild(tr);
			});
		})
		.catch(error => console.error('Erreur :', error));