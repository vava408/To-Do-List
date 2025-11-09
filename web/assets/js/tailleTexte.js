//Script pour agrandissement automatique du textarea


const textarea = document.getElementById("description");
textarea.addEventListener("input", function () {
	this.style.height = "auto";
	this.style.height = this.scrollHeight + "px";
});

const intarea = document.getElementById("description");
intarea.addEventListener("input", function () {
	this.style.height = "auto";
	this.style.height = this.scrollHeight + "px";
});
