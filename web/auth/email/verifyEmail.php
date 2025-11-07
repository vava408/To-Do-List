<?php

	function getEmailValide($email)
	{
		require_once('generCode.php');
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			$subject = "Code de verification. Ne pas répondre!";
			$destinataire = $email;
			$code = genereCode();
			$message = "Votre code de validation est $code";

			mail($destinataire, $subject,$message);

			return true;



		} else {
			return false;
		}
		
	}

?>