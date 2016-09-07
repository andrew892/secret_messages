<?php

class Database {
    
    private static $nomeHost = "localhost";
    private static $nomeUtente = "username";
    private static $password = "password";
    private static $nomeDb = "messaggiSegreti";
    
    public static function dbConnect() {
        $conn = mysql_connect(Database::$nomeHost, Database::$nomeUtente, Database::$password)
            or die("Errore nella connessione al database: ".mysql_error());
        mysql_select_db(Database::$nomeDb)
            or die("Errore nella selezione del databse: "-mysql_error());
		mysql_set_charset("utf8", $conn);
        return $conn;
    }
    
    public static function ask_parola($num) {
        // $conn = Database::dbConnect();
        $sql = "SELECT * FROM parole WHERE id=$num";
        $result = mysql_query($sql)
            or die("Errore nella query: ".mysql_error());
		// mysql_close($conn);
		
		$result = mysql_fetch_array($result);
		return $result["parola"];
		
		// $risposta = array();
		// if(mysql_num_rows($result) > 0) {
			
			// $risposta["success"] = 1;
			// $risposta["parola"] = $result["parola"];
		// } else {
			// $risposta["success"] = 0;
			// $risposta["error"] = "Nessuna parola trovata";
		// }
		// return json_encode($risposta);
    }
	
	public static function inserisci_messaggio($parola1, $parola2, $messaggio) {
		$conn = Database::dbConnect();
		$sql = "INSERT INTO messaggi (id,parola1,parola2,messaggio) VALUES (NULL,".$parola1.",".$parola2.",\"".utf8_encode($messaggio)."\");";
		mysql_query($sql)
			or die("Errore nella query: ".mysql_error());
		
		$risposta = array();
		if(mysql_affected_rows()==0) {
			$risposta["success"] = 0;
			$risposta["error"] = "nessuna modifica apportata";
		} else {
			$risposta["success"] = 1;
			$risposta["parola1"] = Database::ask_parola($parola1);
			$risposta["parola2"] = Database::ask_parola($parola2);
		}
		
		mysql_close($conn);
		
		return json_encode($risposta);
	}
	
	public static function leggi_messaggio($parola1,$parola2) {
		$conn = Database::dbConnect();
		$sql = "SELECT t1.parola as parola1, parole.parola as parola2, t1.messaggio
				FROM (
					SELECT parole.parola, messaggi.parola2, messaggio
					FROM messaggi
					INNER JOIN parole
					ON messaggi.parola1=parole.id
					WHERE parole.parola=\"".$parola1."\"
				) AS t1
				INNER JOIN parole
				ON t1.parola2=parole.id
				WHERE parole.parola=\"".$parola2."\"";
		$result = mysql_query($sql)
            or die("Errore nella query: ".mysql_error());
		mysql_close($conn);
		
		$risposta = array();
		if(mysql_num_rows($result) > 0) {
			$result = mysql_fetch_array($result);
			$risposta["success"] = 1;
			$risposta["messaggio"] = $result["messaggio"];
			return json_encode($risposta);
		} else {
			$risposta["success"] = 0;
			$risposta["error"] = "Nessun messaggio trovato";
			return json_encode($risposta);
		}
	}
}

?>
