<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP: Formular</title>
</head>
<body>
<?php
/*
Grundlage ist die Datei formular0.php (und die damit verknüpfte Datei style.css)

Folgende Aufgaben sind zu lösen:

1.) Wenn das Formular abgeschickt wurde, sollen anstelle des Formulars in 
    derselben Datei innerhalb eines section-Elements alle eingegebenen Werte
    (Anrede, Vorname, Nachname, Nachricht, Lieblingsmusik, Lieblingseis)
	ausgegeben werden. Dabei sollen Leerzeichen am Anfang und Ende des 
	Strings entfernt und HTML-eigene Zeichen maskiert werden.
	
	HTML
	- <section></section>
	PHP
	- htmlspecialchars();
	- trim();

2.) Wenn entsprechende Formularfelder nicht ausgefüllt bzw. ausgewählt wurden,
    soll noch vor dem Formular in einem section-Element mit der id="fehler"
	eine ungeordnete Liste stehen, in der alle nicht ausgefüllten/ausgewählten
	Felder aufgelistet sind.
	
	HTML
	- <section></section>
	JS
	- eventlistener (change)
	

3.) In den bereits ausgefüllten/ausgewählten Feldern des Formulars bleiben die 
    eingetragenen/ausgewählten Werte stehen, falls noch vor dem Formular eine 
	Fehlermeldung (ungeordnete Liste) erfolgt ist.
	
	PHP
	- GET Paramterwerte bei Fehler behalten

4.) Es soll sichergestellt sein, dass bei der Anrede, der Lieblingsmusik und
    dem Lieblingseis nur die angegebenen Werte ausgegeben werden und bei 
	Manipulation der Variablen in der URL diese dann als nicht ausgefüllt 
	gelten. Dazu bietet es sich an, die Werte der möglichen Anredearten/ 
	Musikarten/Eissorten in den entsprechenden Arrays abzuspeichern.
    Des Weiteren sollen bei der Eingabe von Vorname und Nachname maximal 20 
	Zeichen, bei der Eingabe von Nachricht maximal 100 Zeichen möglich sein.
	Sicherzustellen ist dies sowohl per HTML als auch per PHP.
	Bei einer Überschreitung der Zeichenanzahl soll der überschüssige Rest 
	entfernt werden. Beim Laden des Formulars ist bei Anrede Frau vorausgewählt.
	
	Rahmen
	- Anrede (manipulationssicher machen)
	- Lieblingseis (manipulationssicher machen)
	- Lieblingsmusik (manipulationssicher machen)
	- Vorname auf max 20 Zeichen beschränken (HTML und PHP)
	- Nachname auf max 20 Zeichen beschränken (HTML und PHP)
	- Nachricht auf max 100 Zeichen beschränken (HTML und PHP)
	- Bei Überschreitung einer Beschränkung soll der Rest abgeschnitten werden. (in PHP bei Auswertung jedoch fraglich, eher JS oder HTML5?)
	- Vorauswahl beim Laden des Formulars bei Anrede = Frau
	
	HTML
	- MAXLENGTH
	- Vorauswahl
	
	PHP
	- Manipulationssicherheit
	- strlen();
	- substring();
	
5.) Das Anlegen des Formulars und das Auswerten der Daten soll jeweils in einer 
    Funktion erfolgen. Bei beiden Funktionen soll als Parameter lediglich ein 
	Array (und nicht viele einzelne Variablen) übergeben werden.
	
	PHP	
	- 2 Funktionen, eine legt das Formular an und eine wertet es aus
	- Es soll nur ein Parameter übergeben werden an die Funktionen(Array)
	
	

6.) Sofern alle Felder korrekt ausgefüllt bzw. ausgewählt wurden, soll dem 
    Benutzer die Möglichkeit gegeben werden, nach der Ausgabe aller eingegebenen 
	Werte erneut die Eingaben zu ändern (zu realisieren über versteckte 
	Formularfelder) oder die Daten entgültig zu versenden. Wenn der Benutzer
	seine Eingaben ändern möchte, sollen in dem erneut bereitgestellten Formular
	die bereits eingetragenen/ausgewählten Werte stehen. Wenn der Benutzer die 
	Daten entgültig versenden möchte, kann das Versenden der Daten hier erfolgen 
	über die Funktion: mail("E-Mail-Adresse", "Betreff", "Text der Mail");
	Der Text der E-Mail sollte keine HTML-Tags enthalten und Zeilenumbrüche 
	sind über \n zu realisieren.
	Für das lokale Testen der Funktion mail(): 
	Standardmäßig ist mailToDisk aktiviert, wodurch alle Mails unter 
	C:/xampp/mailoutput als *.txt abgelegt werden. Anmerkung: je nach 
	Konfiguration ist es möglich, dass die Mail statt dessen als *.txt abgelegt 
	wird im Verzeichnis: C:/xampp/apache/mailoutput	#
	
	FRAGEN
	- wirklich ein neues Formular mit verstecken Feldern?
	
	HTML
	- versteckte inputs
	- zwei Formulare eins davon display:none
	
	JS
	- Fragen ob wirklich gesendet werden soll.
	
	Meine Idee: 
	- das selbe Formular bei Fehlerfall und Bearbeitung anzeigen
	
	E-Mail:
	- temp-mail.org und dort ändern auf jannickschurig@zdfpost.net
	
	Fehler des Dokuments:
		-Lieblingseis = Einzahl = ein Eis -> Lieblingseis ist in Checkbox Elemente unterteilt -> keine eindeutige Wahl möglich -> Korrektur = radio button
*/
?>
</body>
</html>