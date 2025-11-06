<?php

	function getEmailValide($email)
	{
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			$subject = "Code de verification. Ne pas répondre!";
			$destinataire = $email;
			$code = 0000;
			$message = "Votre code de validation est $code";

			mail($destinataire, $subject,$message);

			return true;



		} else {
			return false;
		}
		
	}

?>