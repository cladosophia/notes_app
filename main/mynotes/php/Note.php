<?php
	date_default_timezone_set('Asia/Manila');
	include 'dbconnect.php';
	session_start();
	$user_id = $_SESSION['user_id'];
	
	if($_POST['action'] == 'add_note'){
		try {
			$name = $_POST['data']["name"];
			$description = $_POST['data']["description"];
			
			///pdo
			$pdo->beginTransaction();
			$prepared_statement = $pdo->prepare("INSERT INTO tbl_notes (title, description, user_id, status) VALUES (?,?,?,?)");
			echo json_encode($name);
			echo json_encode($description);

			$prepared_statement->execute(array($name, $description, $user_id, true));

			echo $pdo->lastInsertId();

			$pdo->commit();
		} catch (Exception $e) {
			$pdo->rollback();
			throw $e;
		}
	}else if($_POST['action'] == 'get_notes'){
		
		try {
			$sql = "SELECT * FROM  tbl_notes WHERE user_id = $user_id AND status = 1";
			$stm = $pdo->query($sql);
			$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($rows);
			
		} catch (Exception $e) {

			throw $e;
		}

	}else if($_POST['action'] == 'delete_note'){

		$note_id =  intval($_POST['id']);
		try {

			$pdo->beginTransaction();
			$prepared_statement = $pdo->prepare("DELETE FROM tbl_notes WHERE id=?");

			$prepared_statement->execute(array($note_id));

			$pdo->commit();

			echo "deleted";
		} catch (Exception $e) {
			$pdo->rollback();
			throw $e;
		}

	}else if($_POST['action'] == 'edit_note'){
		
		try {
			
			$pdo->beginTransaction();
			$prepared_statement = $pdo->prepare("UPDATE tbl_notes SET title = ? , description = ? , updated_at = ? WHERE id = ?");

			$prepared_statement->execute(array($_POST['data']["title"],$_POST['data']["description"],date("Y-m-d 
				H:i:s"),$_POST['data']["id"]));

			$pdo->commit();

			echo "edited!";
		} catch (Exception $e) {
			$pdo->rollback();
			throw $e;
		}

	}
?>	
