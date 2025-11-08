<?php

	function getEmailValide($email, $userName, $userId)
	{
		require_once('generCode.php');
		require_once('../../includes/sessionCode.php');
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			$subject = "Code de verification. Ne pas répondre!";
			$destinataire = $email;
			$code = genereCode();
			$message = "Bienvenue $userName sur To Do list. Votre code de validation est $code";

			genereSessionCode($code);

			mail($destinataire, $subject,$message);

			return true;



		} else {
			return false;
		}
		
	}

?>