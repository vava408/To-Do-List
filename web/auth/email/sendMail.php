	<?php

		function sendMail($email, $userName, $code)
		{
			require_once('generCode.php');
			
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				
				$subject = "Code de verification. Ne pas répondre!";
				$destinataire = $email;
				$message = "Bienvenue $userName sur To Do list. Votre code de validation est $code";

				// --- Configuration des headers ---
				$from = "do-not-reply@airbot.adkynet.eu";
				$headers = "From: ToDoList <$from>\r\n";
				$headers .= "Reply-To: $from\r\n";
				$headers .= "X-Mailer: PHP/" . phpversion();
				$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

				mail($destinataire, $subject,$message, $headers);

				return true;



			} else {
				return false;
			}
			
		}

	?>