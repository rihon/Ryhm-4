<?php
	require("../../vpconfig.php");
	$database = "if17_rinde";
	$monthFieldNames = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
	
	$firstname = "";
	$lastname = "";
	$language = "";
	$january = "";
	$february = "";
	$march = "";
	$april = "";
	$may = "";
	$june = "";
	$july = "";
	$august = "";
	$september = "";
	$october = "";
	$november = "";
	$december = "";
	
	if(isset($_POST["saveMonths"])){
		if(isset($_POST["firstname"]) and !empty($_POST["firstname"])){
			$firstname = testInput($_POST["firstname"]);
		}
		if(isset($_POST["lastname"]) and !empty($_POST["lastname"])){
			$lastname = testInput($_POST["lastname"]);
		}
		if(isset($_POST["language"]) and !empty($_POST["language"])){
			$language = testInput($_POST["language"]);
		}
		if(isset($_POST["january"]) and !empty($_POST["january"])){
			$january = testInput($_POST["january"]);
		}
		if(isset($_POST["february"]) and !empty($_POST["february"])){
			$february = testInput($_POST["february"]);
		}
		if(isset($_POST["march"]) and !empty($_POST["march"])){
			$march = testInput($_POST["march"]);
		}
		if(isset($_POST["april"]) and !empty($_POST["april"])){
			$april = testInput($_POST["april"]);
		}
		if(isset($_POST["may"]) and !empty($_POST["may"])){
			$may = $_POST["may"];
		}
		if(isset($_POST["june"]) and !empty($_POST["june"])){
			$june = testInput($_POST["june"]);
		}
		if(isset($_POST["july"]) and !empty($_POST["july"])){
			$july = testInput($_POST["july"]);
		}
		if(isset($_POST["august"]) and !empty($_POST["august"])){
			$august = testInput($_POST["august"]);
		}
		if(isset($_POST["september"]) and !empty($_POST["september"])){
			$september = testInput($_POST["september"]);
		}
		if(isset($_POST["october"]) and !empty($_POST["october"])){
			$october = testInput($_POST["october"]);
		}
		if(isset($_POST["november"]) and !empty($_POST["november"])){
			$november = testInput($_POST["november"]);
		}
		if(isset($_POST["december"]) and !empty($_POST["december"])){
			$december = testInput($_POST["december"]);
		}
		if(!empty($firstname) and !empty($lastname) and !empty($language) and !empty($january) and !empty($february) and !empty($march) and !empty($april) and !empty($may) and !empty($june) and !empty($july) and !empty($august) and !empty($september) and !empty($october) and !empty($november) and !empty($december)){
			saveMonths($firstname, $lastname, $language, $january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december);
		}
	}

	function saveMonths($firstname, $lastname, $language, $january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december){
		//echo "salvestame nüüd!";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT language FROM vptestmonths WHERE language = ?");
		echo $mysqli->error;
		$stmt->bind_param("s", $language);
		$stmt->bind_result($languageFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Kahjuks selline keel on juba olemas!";
			$stmt->close();
			$mysqli->close();
		} else {
			$stmt->close();
			$stmt = $mysqli->prepare("INSERT INTO vptestmonths (firstname, lastname, language, january, february, march, april, may, june, july, august, september, october, november, december) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$mysqli->error;
			//echo $lastname;
			$stmt->bind_param("sssssssssssssss", $firstname, $lastname, $language, $january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december);
			if($stmt->execute()){
				echo "Õnnestus!";
			} else {
				echo "Salvestamisel tekkis tõrge: " .$stmt->error;
			}
			$stmt->close();
			$mysqli->close();
			cleanVariables();
		}
	}

	//sisestuse kontrollimise funktsioon
	function testInput($input) {
		$input = trim($input); //eemaldab ebavajaliku - liigsed tühikud, TAB, reavahetused
		$input = stripslashes($input); //eemaldab kaldkriipsud "\"
		$input = htmlspecialchars($input); //see mul juba vormi action atribuudi väärtuses olemas, eemaldab keelatud märgid.
		return $input;
	}	
	
function cleanVariables(){
	$GLOBALS["language"] = "";
	$GLOBALS["january"] = "";
	$GLOBALS["february"] = "";
	$GLOBALS["march"] = "";
	$GLOBALS["april"] = "";
	$GLOBALS["may"] = "";
	$GLOBALS["june"] = "";
	$GLOBALS["july"] = "";
	$GLOBALS["august"] = "";
	$GLOBALS["september"] = "";
	$GLOBALS["october"] = "";
	$GLOBALS["november"] = "";
	$GLOBALS["december"] = "";
}
	
	
	?>
<!DOCTYPE html>
<html lang="et">
<head>
<title>Kontrolltöö variant 1</title>
</head>
<body>
<h1>Salvestame kuude nimed mingis keeles</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<label>Eesnimi </label><input name="firstname" type="text" value="<?php echo $firstname; ?>"><br>
	<label>Perekonnanimi </label><input name="lastname" type="text" value="<?php echo $lastname; ?>"><br>
	
	<?php
		if(!empty($firstname) and !empty($lastname)){
			require("addMonths.php");
		}
	?>
	<input type="submit" name="saveMonths" value="Salvesta">
</form>
</body>
</html>