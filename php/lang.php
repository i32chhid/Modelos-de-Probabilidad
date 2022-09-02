<?php
/* 
UNIVERSIDAD DE CÓRDOBA 
Escuela Politécnica Superior de Córdoba
Departamento de Estadística, Econometría, Investigación Operativa, Organización de Empresas y
Economía Aplicada

Simulación de Modelos de Probabilidad con JavaScript: Lanzamiento de dados y monedas
Autor: David Checa Hidalgo 
Director: Roberto Espejo Mohedano
Curso 2021 - 2022 
*/

    // Codificación de caracteres interna a UTF-8 en PHP
    mb_internal_encoding("UTF-8");
    header('Content-Type: text/html; charset=utf-8');
    
    // Idioma seleccionado por el usuario (por defecto se establece español)
    $lang = "es";
    
    if (array_key_exists("lang", $_REQUEST)) {
        $lang = $_REQUEST["lang"];
    } else if (is_array(isset($_SESSION)) && array_key_exists("lang", $_SESSION)) {
        $lang = $_SESSION["lang"];
    }
    
    if (!isset($lang) || !($lang == "es" || $lang == "en" || $lang == "fr")) {
        $lang = "es";
    }

    // Título de la página en el navegador web
    $title['es'] = "Lanzamiento de dados y monedas";
    $title['en'] = "Dice and coins throwing";
    $title['fr'] = htmlentities("Lancer de dés et de pièces");

    // Título de cabecera
    $header['es'] = htmlentities("Simulación de Modelos de Probabilidad");
    $header['en'] = "Simulation of Probability Models";
    $header['fr'] = htmlentities("Simulation de Modèles de Probabilité");

    // Texto descriptivo de la cabecera
    $headText['es'] = htmlentities("Lanzamiento de dados y monedas, anotando las frecuencias relativas. Ley frecuentista de probabilidad y distribución de la suma de puntuaciones");
    $headText['en'] = "Dice and coins tossing, noting relative frequencies. Frequency law of probability and distribution of the sum of scores";
    $headText['fr'] = htmlentities("Lancer des dés et des pièces, en notant les fréquences relatives. Loi fréquentiste de probabilité et distribution de la somme des scores");

    // Ayuda
    $help['es'] = "AYUDA";
    $help['en'] = "HELP";
    $help['fr'] = "AIDE";

    // Texto de la página de Ayuda
    $helpText['es'] = htmlentities("Tras un número elevado de ejecuciones se puede comprobar que la frecuencia converge a la 
    probabilidad previamente asignada y que está representada por la línea roja.<br /><br />
    <strong>Para ejecutar correctamente la simulación:</strong><br /><br />
    <strong>1º) </strong>Seleccione la opción del menú de pestañas para el tipo de simulación que desee realizar.<br /> 
    &nbsp&nbsp&nbsp&nbsp&nbsp<strong>'Una moneda', 'Varias monedas', 'Un dado' o 'Varios dados'</strong>.<br /><br />
    <strong>2º) </strong>Introduzca los parámetros de entrada: <br /><br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Probabilidad (0,1] de salir cara para el lanzamiento de <strong>'Una moneda'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Probabilidad (0,1] de salir cara y número de monedas [2-8] a lanzar para el lanzamiento de <strong>'Varias monedas'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Tipo de dado (Perfecto) para el lanzamiento de <strong>'Un dado'</strong> perfecto. <br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Tipo de dado (Trucado) y probabilidad (0,1] de salir cada uno de los seis valores para el lanzamiento de <strong>'Un dado'</strong> trucado.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Número de dados [2-8] a lanzar para el lanzamiento de <strong>'Varios dados'</strong>.<br /><br />
    <strong>3ª) </strong>Pulse algún botón de ejecución: <br /><br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si pulsa sobre el botón <strong>'Uno a uno'</strong>: Simulará un solo lanzamiento.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si pulsa sobre el botón <strong>'Número Fijo'</strong>: 
    Se ejecutarán el número de lanzamientos de la lista desplegable <strong>'Número fijo'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPor defecto, 10 lanzamientos.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si pulsa sobre el botón <strong>'Continuo'</strong>: 
    Se ejecutarán continuos lanzamientos hasta que pulse el botón <strong>'Detener'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si pulsa sobre el botón <strong>'Reiniciar'</strong>: 
    Reseteará todos los valores de la simulación.<br /><br />");
    $helpText['en'] = htmlentities("After a large number of runs, it can be seen that the frequency converges to the 
    previously assigned probability, represented by the red line.<br /><br />
    <strong>To run the simulation correctly:</strong><br /><br />
    <strong>1º) </strong>Select the tab menu option for the type of simulation you wish to perform.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp<strong>'A coin', 'Several coins', 'A dice' or 'Several dice'</strong>.<br /><br />
    <strong>2º) </strong>Enter the input parameters: <br /><br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Probability (0,1] of right side for the throw of <strong>'A coin'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Probability (0,1] of right side and coins number [2-8] for the throw of <strong>'Several coins'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Dice type (Perfect) for the throw of <strong>'A dice'</strong> that is perfect. <br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Dice type (Tricked) and probability (0,1] of each of the six values for the throw of <strong>'A dice'</strong> that is tricked. <br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Dice number [2-8] to be throwed for the throw of <strong>'Several dice'</strong>.<br /><br />
    <strong>3ª) </strong>Press any execution button: <br /><br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- If you click on the <strong>'One by one'</strong> button: 
    Simulate a single throw.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- If you click on the <strong>'Fixed number'</strong> button: 
    The number of throws from the <strong>'Fixed Number'</strong> drop-down list will be executed. <br />
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  By default, 10 throws.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- If you click on the <strong>'Continuous'</strong> button: 
    Continuous throws will be executed until you click the <strong>'Stop'</strong> button.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- If you click on the <strong>'Restart'</strong> button: 
    Reset all simulation values.<br /><br />");
    $helpText['fr'] = htmlentities("Après un grand nombre d'exécutions, on constate que la fréquence converge 
    vers la probabilité précédemment attribuée, représentée par la ligne rouge.<br /><br />
    <strong>Pour exécuter la simulation correctement :</strong><br /><br />
    <strong>1º) </strong>Sélectionnez l'option du menu à onglets correspondant au type de simulation que vous souhaitez effectuer.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp<strong>'Une pièce', 'Plusieurs pièces', 'Un dé' o 'Plusieurs dés'</strong>.<br /><br />
    <strong>2º) </strong>Entrez les paramètres d'entrée: <br /><br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Probabilité (0,1] de pile ou face pour le lancer de <strong>'Une pièce'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Probabilité (0,1] de têtes et nombre de pièces [2-8] à lancer pour le lancer de <strong>'Plusieurs pièces'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Type de dé (Parfait) pour le jet de <strong>'Un dé'</strong> parfait. <br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Type de dé (Truqué) et la probabilité (0,1] de chacune des six valeurs pour le lancer du tour <strong>'Un dé'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Nombre de dés [2-8] à lancer pour le jet de <strong>'Plusieurs dés'</strong>.<br /><br />
    <strong>3ª) </strong>Appuyez sur n'importe quel bouton d'exécution : <br /><br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si vous cliquez sur le bouton <strong>'Un par un'</strong>:
    Simuler un seul lancement.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si vous cliquez sur le bouton <strong>'Nombre fixe'</strong>: 
    Le nombre de lancements figurant dans la liste déroulante <strong>'Nombre fixe'</strong> sera exécuté. <br />
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Par défaut, 10 emplacements.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si vous cliquez sur le bouton <strong>'Continuo'</strong>: 
    Les lancements continus seront exécutés jusqu'à ce que vous cliquiez sur le bouton <strong>'Stop'</strong>.<br />
    &nbsp&nbsp&nbsp&nbsp&nbsp- Si vous cliquez sur le bouton <strong>'Redémarrer'</strong>:  
    Il réinitialisera toutes les valeurs de la simulation.<br /><br />");
        
    // Autor
    $author['es'] = "<strong>Autor: </strong>David Checa Hidalgo. Curso 2021 - 2022.";
    $author['en'] = "<strong>Author: </strong>David Checa Hidalgo. Course 2021 - 2022.";
    $author['fr'] = "<strong>Auteur: </strong>David Checa Hidalgo. Cours 2021 - 2022.";
        
    // Texto de las pestañas del menú
    $tab['es'] = array("Una moneda","Varias monedas","Un dado","Varios dados");
    $tab['en'] = array("A coin","Several coins","A dice","Several dice");
    $tab['fr'] = array(htmlentities("Une pièce"), htmlentities("Plusieurs pièces"), htmlentities("Un dé"), htmlentities("Plusieurs dés"));

    // Botón "P(x = Cara)" y título informativo al pasar el ratón
    $pX['es'] = array("P(x = Cara): ", "Probabilidad de obtener Cara", "La probabilidad de obtener cara ha de estar entre (0,1]");
    $pX['en'] = array("P(x = Right side): ", "Probability of getting Right side", "The probability of heads must be between (0,1]");
    $pX['fr'] = array("P(x = Face):", htmlentities("Probabilité d'obtenir Face"), htmlentities("La probabilité de têtes doit être comprise entre (0,1]"));   
        
    // Botón "Número de monedas" y título informativo al pasar el ratón
    $coinsNum['es'] = array(htmlentities("Número de monedas:"), htmlentities("Número de monedas a lanzar"));
    $coinsNum['en'] = array("Coins number:", "Coins number to be throwed");
    $coinsNum['fr'] = array(htmlentities("Nombre de pièces:"), htmlentities("Nombre de pièces à lancer"));

    // Botón "P(x = y)" y título informativo al pasar el ratón
    $diceProb['es'] = array("Probabilidad de obtener 1", "Probabilidad de obtener 2", "Probabilidad de obtener 3", 
                            "Probabilidad de obtener 4", "Probabilidad de obtener 5", "Probabilidad de obtener 6");
    $diceProb['en'] = array("Probability of obtaining 1", "Probability of obtaining 2", "Probability of obtaining 3", 
                            "Probability of obtaining 4", "Probability of obtaining 5", "Probability of obtaining 6");
    $diceProb['fr'] = array(htmlentities("Probabilité d'obtenir 1"), htmlentities("Probabilité d'obtenir 2"), htmlentities("Probabilité d'obtenir 3"), 
                            htmlentities("Probabilité d'obtenir 4"), htmlentities("Probabilité d'obtenir 5"), htmlentities("Probabilité d'obtenir 6"));

    // Botón "Tipo de dado" y título informativo al pasar el ratón
    $diceType['es'] = array("Tipo de dado:", "Tipo de dado a lanzar", "Perfecto", "Trucado");
    $diceType['en'] = array("Dice type:", "Dice type to be throwed", "Perfect", "Tricked");
    $diceType['fr'] = array(htmlentities("Type de dé:"), htmlentities("Type de dé à lancer"), "Parfait", htmlentities("Truqué"));
        
    // Botón "Número de dados" y título informativo al pasar el ratón
    $diceNum['es'] = array(htmlentities("Número de dados:"), htmlentities("Número de dados a lanzar"));
    $diceNum['en'] = array("Dice number:", "Dice number to be throwed");
    $diceNum['fr'] = array(htmlentities("Nombre de dés:"), htmlentities("Nombre de dés à lancer"));
        
    // Botones de ejecución y título informativo al pasar el ratón
    $button['es'] = array("Genera un solo lanzamiento","Uno a uno", htmlentities("Genera un número de lanzamientos fijo"), htmlentities("Número fijo"),
                    "Genera lanzamientos infinitos", "Continuo", "Detiene los lanzamientos infinitos", "Detener", "Resetea todos los valores", "Reiniciar");
    $button['en'] = array("Generates a single throw", "One by one", "Generates a fixed number of throws","Fixed number",
                    "Generates infinite throws", "Continuous", "Stops infinite throws", "Stop", "Resets all values", "Restart");
    $button['fr'] = array(htmlentities("Génère un seul lancement"),"Un par un", htmlentities("Génère un nombre fixe de lancements"),"Nombre fixe",
                          htmlentities("Génère des hauteurs infinies"), "Continuo", htmlentities("Arrête les lancers infinis"), "Stop", htmlentities("Réinitialise toutes les valeurs"), htmlentities("Redémarrer"));
    
    // Etiqueta "Suma de las puntuaciones" de la leyenda inferior
    $scoresSum['es'] = "Suma de las puntuaciones: ";
    $scoresSum['en'] = "Sum of the scores: ";
    $scoresSum['fr'] = "Somme des scores: ";
        
    // Texto a pie de página 
    $footerText['es'] =  htmlentities("Departamento de Estadística - Universidad de Córdoba<br />Aptdo. 3048. E-14080 Córdoba (España)");
    $footerText['en'] = "Statistics Department - Cordova University<br />Aptdo. 3048. E-14080 Cordova (Spain)";
    $footerText['fr'] = htmlentities("Département des Statistiques - Université de Cordoue<br />Aptdo. 3048. E-14080 Cordoue (Espagne)");

    // Título informativo al pasar el ratón por los números de teléfono y fax
    $contactUs['es'] = "Contacta con nosotros";
    $contactUs['en'] = "Contact us";
    $contactUs['fr'] = "Contactez-nous";   
        
    // Coordinadores
    $coord['es'] = "Coordinadores:";
    $coord['en'] = "Coordinators:";
    $coord['fr'] = "Coordonnateurs:";  
    
    $legend["es"] = ["Lanzamientos: ", "Caras: ", "Frecuencia caras (%): ", "Cruces: ", "Frecuencia cruces (%): "];
    $legend["en"] = ["Throws: ", "Right sides: ", "Frequency of right sides (%): ", "Reverses: ", "Frequency of reverses (%): "];
    $legend["fr"] = ["Lancements: ", "Faces: ", "Fréquence des faces (%): ", "Traversées: ", "Fréquence des traversées (%): "];

?> 

