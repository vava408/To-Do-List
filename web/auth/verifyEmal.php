<?php

	function getEmailValide($email)
	{
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
			
			$subject = "Code de verification. Ne pas répondre!";
			$destinataire = $email;
			$message = "Votre code de validation est $code";
			$code = 0000;

			mail($destinataire, $subject,$message);


		} else {
			return false;
		}
		
	}

?>