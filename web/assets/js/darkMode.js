(function () {
	// Racine du document : élément <html>
	// Nous utilisons l'attribut data-theme sur cet élément pour appliquer
	// les styles CSS correspondants (par ex. [data-theme="dark"]).
	const root = document.documentElement;

	/**
	 * Met à jour l'état visuel d'un contrôle (checkbox/toggle) lié au thème.
	 * @param {string} theme - 'dark' ou 'light'
	 *
	 * Recherche l'élément avec l'id #theme-toggle (si présent) et positionne
	 * sa propriété checked en fonction du thème courant.
	 */
	function updateToggleState(theme) {
		const toggle = document.querySelector('#theme-toggle');
		if (toggle) {
			// checked = true si thème sombre, false sinon
			toggle.checked = theme === 'dark';
		}
	}

	/**
	 * Applique le thème demandé au document et le mémorise en localStorage.
	 * - Définit l'attribut data-theme sur <html>, ce qui permet au CSS
	 *   d'appliquer les variables et couleurs correspondantes.
	 * - Sauvegarde le choix dans localStorage sous la clé 'theme' pour
	 *   persister la préférence entre les visites.
	 * - Met à jour l'état du toggle (si présent) pour garder l'UI synchronisée.
	 *
	 * @param {string} theme - 'dark' ou 'light'
	 */
	function setTheme(theme) {
		root.setAttribute('data-theme', theme);
		try {
			localStorage.setItem('theme', theme);
		} catch (e) {
			// localStorage peut échouer (mode navigation privée, quotas, etc.).
			// On ignore l'erreur pour ne pas casser l'expérience utilisateur.
			// eslint-disable-next-line no-console
			console.warn('Impossible de sauvegarder le thème dans localStorage', e);
		}
		updateToggleState(theme);
	}

	/**
	 * Bascule entre les thèmes 'dark' et 'light'.
	 * Lit le thème actuel via l'attribut data-theme (par défaut 'light')
	 * et appelle setTheme() avec la valeur opposée.
	 */
	function toggleTheme() {
		const currentTheme = root.getAttribute('data-theme') || 'light';
		const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
		setTheme(newTheme);
	}

	/**
	 * Initialise le thème au chargement du script :
	 * - Si une préférence est stockée dans localStorage, on l'utilise.
	 * - Sinon, on interroge la préférence système via matchMedia.
	 * - Enfin, on applique le thème choisi.
	 */
	function initTheme() {
		const storedTheme = (() => {
			try {
				return localStorage.getItem('theme');
			} catch (e) {
				return null;
			}
		})();
		// matchMedia renvoie true si l'utilisateur préfère le thème sombre
		const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
		const theme = storedTheme || (systemPrefersDark ? 'dark' : 'light');
		setTheme(theme);
	}

	// Initialisation immédiate : applique le thème approprié
	initTheme();

	// Gestionnaire d'événements : une fois le DOM chargé, on branche
	// le changement du toggle (input) pour appeler toggleTheme().
	//
	// On recherche un élément via l'attribut data-theme-toggler (au lieu
	// d'un id précis) pour rester flexible sur le markup côté HTML.
	document.addEventListener('DOMContentLoaded', () => {
		const toggleInput = document.querySelector('[data-theme-toggler]');
		if (toggleInput) {
			// Quand l'utilisateur change le contrôle, on bascule le thème
			toggleInput.addEventListener('change', toggleTheme);
			// Synchroniser l'état initial du toggle avec le thème appliqué
			updateToggleState(root.getAttribute('data-theme'));
		}
	});
})();