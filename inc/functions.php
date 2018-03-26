<?php

ini_set('display_errors', '1');
ini_set('mbstring.internal_encoding', 'windows-1251');

include('config.php');

class admin{

	protected static $connection;
	protected static $pdo;

	public function connect(){
		try{
			self::$pdo = new PDO('mysql:host=localhost;dbname=sagrasa', DB_USER, DB_PASS);	
		}catch(PDOException $ex){
			echo 'Connection failed: '.$ex->getMessage();
		}
		
		return self::$pdo;
	}

	function test_conn(){
		//Used to test PDO connection
		$pdo = $this->connect();
		if($pdo)
			echo "Connected";
		else
			echo "no connection";
	}

	function check_login($username, $password){
		$query = "Select username as username, password as password from UserDB where username='".$username."' LIMIT 1";
		$pdo = $this->connect();
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();

		if(password_verify($password, $row['password'])){
			$_SESSION['user'] = $row['username'];
			return true;
		}else{
			return false;
		}
	}

	function getDashboardData($username){
		$query = "Select username as username, email as email from UserDB where username='".$username."' LIMIT 1";
		$pdo = $this->connect();
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row;
	}
	
	function updateEmail($email){
		try{
			$query = "Update UserDB set email= :email";
			$pdo = $this->connect();
			$data = array(':email' => $email);
			$stmt = $pdo->prepare($query);
			$stmt->execute($data);	
			return true;
		}catch(PDOException $ex){
			error_log("Error while updating e-mail: ".$e->getMessage());
			return false;
		}
	}

	function updatePassword($passwd){
		try{
			$query = "Update UserDB set password= :passwd";
			$pdo = $this->connect();
			$data = array(':passwd' => password_hash($passwd, PASSWORD_DEFAULT));
			$stmt = $pdo->prepare($query);
			$stmt->execute($data);	
			return true;
		}catch(PDOException $ex){
			error_log("Error while updating password: ".$e->getMessage());
			return false;
		}
	}

	function handleExcel($postvars, $filevars){
		include('excel_reader/excel_reader.php');

		try{
			$filename = "file".time();
			echo "Filename is ".$filename;
			$fileparams = pathinfo($_FILES['excelfile']['name']);
			$ext = $fileparams['extension'];
			echo "Extension is ".$ext;
			if(in_array($ext, array('xls','xlsx','csv'))){
				if(move_uploaded_file($_FILES['excelfile']['tmp_name'], '../admin/files/'.$filename.".".$ext)){
					$xlFilePath = "../admin/files/".$filename.".".$ext;

					$excel = new PHPExcelReader;
					$excel->read($xlFilePath);
					echo "done";
				}else{
					echo "not done";	
				}
			}else{
				error_log($_FILES['excelfile']['name']." - Not an allowed file type");
				return false;
			}
			
		}catch(Exception $exc){
			echo "Error:".$exc->getMessage();
		}
		

		
		echo "<br> Printing received variables:";
		print_r($postvars);
		echo "<br>";
		print_r($filevars);



		return true;
	}


	function logout(){
		session_destroy();
		header("Location: index.php");
		exit(0);
	}


}


?>