<?php


require_once __DIR__ . '/../../../config/db.php';


require_once __DIR__ . '/countTasks.php';

function GetCountTasksCompleted()
{
    global $pdo;


    if(GetCount() != 0)
    {
		$stmt = $pdo->prepare(
			"SELECT COUNT(*) 
			FROM tasks 
			WHERE user_id = :user_id AND status = :status"
		);
        $stmt->execute
        ([
            'user_id' => $_SESSION['user_id'],
            'status'  =>  'completed'
        ]);
        $countCompeted = $stmt->fetchColumn();
        
        if($countCompeted == 0)
        {
            return "Aucune taches complétées";
        }

        return $countCompeted ?: "Aucune taches n'as était complétée";
;
    }
    
    return "Aucune taches n'as était complétée";

}

?>