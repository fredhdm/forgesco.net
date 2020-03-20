//ENREGISTRER LES DONNÉES DU FORMULAIRE AVANT D'ALLER À LA PAGE DE MODULE DEMANDÉE.
		function addModule(module) {
			document.getElementById("action").value = module;
			document.page.submit(); 
		}
		
		function activerUrlPreferes() {
			document.getElementById('upf').readOnly = false;
			document.getElementById('upe').readOnly = false;
			alert('Vous pouvez maintenant éditer les URL préférés.');
		}
		
		
		function confirmSubmit(nomPage) {
var agree=confirm("Êtes-vous sûr de vouloir supprimer : " + nomPage + "? \n Vous ne pourrez plus revenir en arrière.");
	if (agree) {
		return true ;
	} else {
		return false ;
	}
}