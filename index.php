<!DOCTYPE html>
<?php
	$pruefung = false;
	$delivered_data = [];
	
	
	if (count($_GET) > 0){
		$pruefung = true;
		foreach ($_GET as $key => $value){
			if ($value != ""){
				$delivered_data += array($key => trim(htmlspecialchars($value)));
			} else {
				$pruefung = false;
			}
		}
		
		if(count($delivered_data) < 7){
			$pruefung = false;
		}
		
		//Sicherheitsnetz
		$sicherheitsnetz = [
			'Anrede' => [
				 1 => "Frau"
				,2 => "Herr"
			]
			
			,'Vorname' => 20
			
			,'Nachname' => 20
			
			,'Nachricht' => 100
			
			,'Lieblingsmusik' => [
				  1 => "Abschicken"
				, 2 => "Pop"
				, 3 => "Rock"
				, 4 => "Jazz"
				, 5 => "Volksmusik"
			]
			
			,'Lieblingseis' => [
				  1 => "Schokolade"
				, 2 => "Vanille"
				, 3 => "Zitrone"
				, 4 => "Mango"
				, 5 => "Erdbeere"
			]
			
			,'Senden' => [
				 'start' => ''
				,'bearbeiten' => 'Abschicken'
				,'abschicken' => 'Endgültig Abschicken'
				,'fertig' => 'Abgeschickt'
			]
		];
		
		if ($pruefung == true){
			//Anrede Prüfen
			if (!array_search($delivered_data["Anrede"], $sicherheitsnetz["Anrede"])){
				$delivered_data["Anrede"] = "Frau";
			}
			
			//Vorname Prüfen
			if (strlen($delivered_data["Vorname"]) > intval($sicherheitsnetz['Vorname'])){
				$delivered_data["Vorname"] = substr($delivered_data["Vorname"], 0, intval($sicherheitsnetz['Vorname']));
			}
			
			//Nachname Prüfen
			if (strlen($delivered_data["Nachname"]) > intval($sicherheitsnetz['Nachname'])){
				$delivered_data["Nachname"] = substr($delivered_data["Nachname"], 0, intval($sicherheitsnetz['Nachname']));
			}
			
			//Nachricht Prüfen
			if (strlen($delivered_data["Nachricht"]) > intval($sicherheitsnetz['Nachricht'])){
				$delivered_data["Nachricht"] = substr($delivered_data["Nachricht"], 0, intval($sicherheitsnetz['Nachricht']));
			}
			
			//Lieblingsmusik Prüfen
			if (!array_search($delivered_data["Musik"], $sicherheitsnetz["Lieblingsmusik"])){
				$delivered_data["Musik"] = "Klassik";
			}
			
			//Lieblingseis Prüfen
			if (!array_search($delivered_data["Eis"], $sicherheitsnetz["Lieblingseis"])){
				$delivered_data["Eis"] = "Schokolade";
			}
			
			//Senden Prüfen
			if (!array_search($delivered_data["Senden"], $sicherheitsnetz["Senden"])){
				$delivered_data["Senden"] = $sicherheitsnetz["Senden"]['start'];
			} else {
				if ($delivered_data["Senden"] == "Abschicken"){
					$delivered_data["Senden"] = "Endgültig Abschicken";
				} else {
					$delivered_data["Senden"] = "Abgeschickt";
				}
			}
		} else {
			//Senden Prüfen
			if (!array_search($delivered_data["Senden"], $sicherheitsnetz["Senden"])){
				$delivered_data["Senden"] = $sicherheitsnetz["Senden"]['start'];
			}
		}
	} else {
		$delivered_data["Anrede"] = "";
		$delivered_data["Vorname"] = "";
		$delivered_data["Nachname"] = "";
		$delivered_data["Nachricht"] = "";
		$delivered_data["Musik"] = "";
		$delivered_data["Eis"] = "";
		$delivered_data["Senden"] = "";
	} 
	
	if (!$pruefung){
		displayForm($delivered_data);
	} else {
		evaluateForm($delivered_data);
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>PHP: Formular</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<script>
			//JS Script
			document.addEventListener("DOMContentLoaded", function(event) {
				if (document.getElementsByTagName('form')[0] !== undefined){
					//onChange an alle Inputs der "form" anhängen
					var inputs = document.forms["form"].getElementsByTagName("input");
					for (i=0; i<inputs.length; i++){
						inputs[i].onchange = checkValues;
					}
					
					//onChange an das Textfeld "textarea1" anhängen
					var textarea = document.getElementById('textarea1');
					textarea.onchange = checkValues;
					
					//onChange an die Selectbox "select1" anhängen
					var select = document.getElementById('select1');
					select.onchange = checkValues;
					
					
					function checkValues(){
						var data = new Array();
						
						if(document.querySelector('input[name = "Anrede"]:checked') != null){
							data['Anrede'] = document.querySelector('input[name = "Anrede"]:checked').value;
						} else {
							data['Anrede'] = "";
						}
						data['Vorname'] = document.querySelector('input[name = "Vorname"]').value;
						data['Nachname'] = document.querySelector('input[name = "Nachname"]').value;
						data['Nachricht'] = document.querySelector('textarea[name = "Nachricht"]').value;
						data['Lieblingsmusik'] = document.querySelector('select[name = "Musik"]').value;
						if(document.querySelector('input[name = "Eis"]:checked') != null){
							data['Lieblingseis'] = document.querySelector('input[name = "Eis"]:checked').value;
						} else {
							data['Lieblingseis'] = "";
						}
						
						var ul = document.querySelector('section[id = "fehler"] ul');
						ul.innerHTML = "";
						
						for (key in data) {
							if (data[key] === ""){
								var li = document.createElement("li");
								li.appendChild(document.createTextNode(key));
								ul.appendChild(li);
							}
						}
						
						if (ul.children.length > 0){
							document.getElementById('fehler').style.display = "";
						} else {
							document.getElementById('fehler').style.display = "none";
						}
					}
					
					//um beim Start des Formulars die Liste zu erstllen
					checkValues();
				}
			});
		</script>
	</head>
	<body>
		<?php
			function displayForm($delivered_data){
				echo'
				<section id="fehler">
					<h3>fehlende Formulardaten</h3>
					<div>
						<span>Bitte füllen Sie die fehlenden Daten aus!</span><br>
						<ul>
						</ul> 
					</div>
				</section>
				';
				
				//Formular Überschrift
					if ($delivered_data["Senden"] == "" || $delivered_data["Senden"] == "Abschicken"){
						echo'
							<section>
								<h3>Formular</h3>
								<form name="form" action="" method="get">
						';
					} else {
						if ($delivered_data["Senden"] == "Endgültig Abschicken"){
							echo'
								<section>
									<h3>Formular bearbeiten</h3>
									<form name="form" action="" method="get">
							';
						}
					}
				
				//Anrede
					if ($delivered_data["Anrede"] == "Frau" || $delivered_data["Anrede"] == ""){
						echo'	
							<span>Anrede: </span><br>
								<input type="radio" name="Anrede" value="Frau" id="radio1_anrede" checked="checked">
								<label for="radio1_anrede"> Frau</label>
								<br>
								<input type="radio" name="Anrede" value="Herr" id="radio2_anrede">
								<label for="radio2_anrede"> Herr</label>
								<br>
						';
					} else {
						echo'	
							<span>Anrede: </span><br>
								<input type="radio" name="Anrede" value="Frau" id="radio1_anrede">
								<label for="radio1_anrede"> Frau</label>
								<br>
								<input type="radio" name="Anrede" value="Herr" id="radio2_anrede" checked="checked">
								<label for="radio2_anrede"> Herr</label>
								<br>
						';
					}
			
				//Vorname //Nachname //Nachricht 
					echo'
						<label for="input1">Vorname: </label>
							<input type="text" name="Vorname" id="input1" maxlength="20" value="' . $delivered_data["Vorname"] . '">
							<br>
						
						<label for="input2">Nachname: </label>
							<input type="text" name="Nachname" id="input2" maxlength="20" value="' . $delivered_data["Nachname"] . '">
							<br>
						
						<label for="textarea1">Nachricht: </label><br>
							<textarea name="Nachricht" id="textarea1" maxlength="100">' . $delivered_data["Nachricht"] . '</textarea>
							<br>
					';
				
				//Lieblingsmusik selected="selected"
					echo'
						<label for="select1">Lieblingsmusik: </label><br>
							<select name="Musik" id="select1">
					';
					
					switch ($delivered_data["Musik"]) {
						case "Klassik":
							echo '
								<option value="">Bitte wählen</option>
								<option selected="selected" value="Klassik">Klassik</option>
								<option value="Pop">Pop</option>
								<option value="Rock">Rock</option>
								<option value="Jazz">Jazz</option>
								<option value="Volksmusik">Volksmusik</option>
							';
							break;
						case "Pop":
							echo '
								<option value="">Bitte wählen</option>
								<option value="Klassik">Klassik</option>
								<option selected="selected" value="Pop">Pop</option>
								<option value="Rock">Rock</option>
								<option value="Jazz">Jazz</option>
								<option value="Volksmusik">Volksmusik</option>
							';
							break;
						case "Rock":
							echo '
								<option value="">Bitte wählen</option>
								<option value="Klassik">Klassik</option>
								<option value="Pop">Pop</option>
								<option selected="selected" value="Rock">Rock</option>
								<option value="Jazz">Jazz</option>
								<option value="Volksmusik">Volksmusik</option>
							';
							break;
						case "Jazz":
							echo '
								<option value="">Bitte wählen</option>
								<option value="Klassik">Klassik</option>
								<option value="Pop">Pop</option>
								<option value="Rock">Rock</option>
								<option selected="selected" value="Jazz">Jazz</option>
								<option value="Volksmusik">Volksmusik</option>
							';
							break;
						case "Volksmusik":
							echo '
								<option value="">Bitte wählen</option>
								<option value="Klassik">Klassik</option>
								<option selected="selected" value="Pop">Pop</option>
								<option value="Rock">Rock</option>
								<option value="Jazz">Jazz</option>
								<option selected="selected" value="Volksmusik">Volksmusik</option>
							';
							break;
						default:
							echo '
								<option value="">Bitte wählen</option>
								<option value="Klassik">Klassik</option>
								<option value="Pop">Pop</option>
								<option value="Rock">Rock</option>
								<option value="Jazz">Jazz</option>
								<option value="Volksmusik">Volksmusik</option>
							';
					}
					
					echo'
						</select>
							<br>
					';	
				
				//Lieblingseis
					echo'
						<span>Lieblingseis: </span>
						<br>
					';
					
					switch ($delivered_data["Eis"]){
						case "Schokolade":
							echo'
								<input type="radio" name="Eis" value="Schokolade" id="radio1_eis" checked="checked">
								<label for="radio1_eis"> Schokolade</label>
								<br>
								<input type="radio" name="Eis" value="Vanille" id="radio2_eis">
								<label for="radio2_eis"> Vanille</label>
								<br>
								<input type="radio" name="Eis" value="Zitrone" id="radio3_eis">
								<label for="radio3_eis"> Zitrone</label>
								<br>
								<input type="radio" name="Eis" value="Mango" id="radio4_eis">
								<label for="radio4_eis"> Mango</label>
								<br>
								<input type="radio" name="Eis" value="Erdbeere" id="radio5_eis">
								<label for="radio5_eis"> Erdbeere</label>
								<br>
							';
							break;
						case "Vanille":
							echo'
								<input type="radio" name="Eis" value="Schokolade" id="radio1_eis">
								<label for="radio1_eis"> Schokolade</label>
								<br>
								<input type="radio" name="Eis" value="Vanille" id="radio2_eis" checked="checked">
								<label for="radio2_eis"> Vanille</label>
								<br>
								<input type="radio" name="Eis" value="Zitrone" id="radio3_eis">
								<label for="radio3_eis"> Zitrone</label>
								<br>
								<input type="radio" name="Eis" value="Mango" id="radio4_eis">
								<label for="radio4_eis"> Mango</label>
								<br>
								<input type="radio" name="Eis" value="Erdbeere" id="radio5_eis">
								<label for="radio5_eis"> Erdbeere</label>
								<br>
							';
							break;
						case "Zitrone":
							echo'
								<input type="radio" name="Eis" value="Schokolade" id="radio1_eis">
								<label for="radio1_eis"> Schokolade</label>
								<br>
								<input type="radio" name="Eis" value="Vanille" id="radio2_eis">
								<label for="radio2_eis"> Vanille</label>
								<br>
								<input type="radio" name="Eis" value="Zitrone" id="radio3_eis" checked="checked">
								<label for="radio3_eis"> Zitrone</label>
								<br>
								<input type="radio" name="Eis" value="Mango" id="radio4_eis">
								<label for="radio4_eis"> Mango</label>
								<br>
								<input type="radio" name="Eis" value="Erdbeere" id="radio5_eis">
								<label for="radio5_eis"> Erdbeere</label>
								<br>
							';
							break;
						case "Mango":
							echo'
								<input type="radio" name="Eis" value="Schokolade" id="radio1_eis">
								<label for="radio1_eis"> Schokolade</label>
								<br>
								<input type="radio" name="Eis" value="Vanille" id="radio2_eis">
								<label for="radio2_eis"> Vanille</label>
								<br>
								<input type="radio" name="Eis" value="Zitrone" id="radio3_eis">
								<label for="radio3_eis"> Zitrone</label>
								<br>
								<input type="radio" name="Eis" value="Mango" id="radio4_eis" checked="checked">
								<label for="radio4_eis"> Mango</label>
								<br>
								<input type="radio" name="Eis" value="Erdbeere" id="radio5_eis">
								<label for="radio5_eis"> Erdbeere</label>
								<br>
							';
							break;
						case "Erdbeere":
							echo'
								<input type="radio" name="Eis" value="Schokolade" id="radio1_eis">
								<label for="radio1_eis"> Schokolade</label>
								<br>
								<input type="radio" name="Eis" value="Vanille" id="radio2_eis">
								<label for="radio2_eis"> Vanille</label>
								<br>
								<input type="radio" name="Eis" value="Zitrone" id="radio3_eis">
								<label for="radio3_eis"> Zitrone</label>
								<br>
								<input type="radio" name="Eis" value="Mango" id="radio4_eis">
								<label for="radio4_eis"> Mango</label>
								<br>
								<input type="radio" name="Eis" value="Erdbeere" id="radio5_eis" checked="checked">
								<label for="radio5_eis"> Erdbeere</label>
								<br>
							';
							break;
						default:
							echo'
								<input type="radio" name="Eis" value="Schokolade" id="radio1_eis">
								<label for="radio1_eis"> Schokolade</label>
								<br>
								<input type="radio" name="Eis" value="Vanille" id="radio2_eis">
								<label for="radio2_eis"> Vanille</label>
								<br>
								<input type="radio" name="Eis" value="Zitrone" id="radio3_eis">
								<label for="radio3_eis"> Zitrone</label>
								<br>
								<input type="radio" name="Eis" value="Mango" id="radio4_eis">
								<label for="radio4_eis"> Mango</label>
								<br>
								<input type="radio" name="Eis" value="Erdbeere" id="radio5_eis">
								<label for="radio5_eis"> Erdbeere</label>
								<br>
							';
					}
					
					//Senden
					if ($delivered_data["Senden"] == "" || $delivered_data["Senden"] == "Abschicken"){
						echo'
										<input type="submit" name="Senden" value="Abschicken">
									</form>
								</section>
							';
					} else {
						if ($delivered_data["Senden"] == "Endgültig Abschicken"){
							echo'
										<input type="submit" name="Senden" value="Endgültig Abschicken">
									</form>
								</section>
							';
						}
					}
			}
			
			function evaluateForm($delivered_data){
				if ($delivered_data["Senden"] == "" || $delivered_data["Senden"] == "Abschicken" || $delivered_data["Senden"] == "Endgültig Abschicken"){
					displayForm($delivered_data);
				} else {
					if ($delivered_data["Senden"] == "Abgeschickt"){
						echo '
							<section>
								<h3>übermittelte Formulardaten</h3>
								<div>
									<span>Anrede: </span><br>
										<input type="text" name="Anrede" id="delivered1" value="' . $delivered_data["Anrede"] . '" readonly>
									
									<span>Vorname: </span><br>
										<input type="text" name="Vorname" id="delivered2" value="' . $delivered_data["Vorname"] . '" readonly>
									
									<span>Nachname: </span><br>
										<input type="text" name="Nachname" id="delivered3" value="' . $delivered_data["Nachname"] . '" readonly>
									
									<span>Nachricht: </span><br>
										<textarea name="Nachricht" id="delivered4" readonly>' . $delivered_data["Nachricht"] . '</textarea>
									
									<span>Lieblingsmusik: </span><br>
										<input type="text" name="Lieblingsmusik" id="delivered5" value="' . $delivered_data["Musik"] . '" readonly>
									
									<span>Lieblingseis: </span><br>
										<input type="text" name="Lieblingseis" id="delivered6" value="' . $delivered_data["Eis"] . '" readonly>
								</div>
						';
						//löscht letzten GET Paramter aus Array
						array_pop($delivered_data);
						
						$result = mail("jannickschurig@zdfpost.net", "übermittelte Formulardaten", implode(",", $delivered_data));
						if($result) {   
							echo'<span style="color:green; text-align:center;">Übermittelte Formulardaten wurden per Email an "jannickschurig@zdfpost.net" versendet!</span><br>';
						} else {
							echo'<span style="color:red; text-align:center;">Übermittelte Formulardaten konnten nicht per Email an "jannickschurig@zdfpost.net" versendet werden!</span><br>';
						}
						
						echo'
							</section>
						';
					}
				}
			}
		?>
	</body>
</html>