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
    
    // Idioma seleccionado por el usuario (por defecto se establece español)
    $lang = "fr";
    
    if (array_key_exists("lang", $_REQUEST)) {
        $lang = $_REQUEST["lang"];
    } else if (is_array(isset($_SESSION)) && array_key_exists("lang", $_SESSION)) {
        $lang = $_SESSION["lang"];
    }
    
    if (!isset($lang) || !($lang == "es" || $lang == "en" || $lang == "fr")) {
        $lang = "es";
    }

    $base_dir = dirname(__FILE__); // Absolute path to your installation, ex: /var/www/mywebsite
    $doc_root = preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); # ex: /var/www
    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $domain = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
    $base_url = preg_replace('!^{$doc_root}!', '', $base_dir); # ex: '' or '/mywebsite'
    $full_url = "$protocol://{$domain}{$disp_port}{$base_url}";

    // Título de la página en el navegador web
    $title['es'] = htmlentities("Lanzamiento de dados y monedas");
    $title['en'] = htmlentities("Dice and coins throwing");
    $title['fr'] = htmlentities("Lancer de dés et de pièces");

    // Título de cabecera
    $header['es'] = htmlentities("Simulación de Modelos de Probabilidad");
    $header['en'] = htmlentities("Simulation of Probability Models");
    $header['fr'] = htmlentities("Simulation de Modèles de Probabilité");

    // Texto descriptivo de la cabecera
    $headText['es'] = htmlentities("Lanzamiento de dados y monedas, anotando las frecuencias relativas. Ley frecuentista de probabilidad y distribución de la suma de puntuaciones");
    $headText['en'] = htmlentities("Dice and coins tossing, noting relative frequencies. Frequency law of probability and distribution of the sum of scores");
    $headText['fr'] = htmlentities("Lancer des dés et des pièces, en notant les fréquences relatives. Loi fréquentiste de probabilité et distribution de la somme des scores");

    // Ayuda
    $help['es'] = htmlentities("AYUDA");
    $help['en'] = htmlentities("HELP");
    $help['fr'] = htmlentities("AIDE");

    // Texto de la página de Ayuda
    $helpText['es'] = htmlentities("Tras un número elevado de ejecuciones se puede comprobar que la frecuencia converge a la 
    probabilidad previamente asignada y que está representada por la línea roja.")."<br /><br />
    <strong>".htmlentities("Para ejecutar correctamente la simulación:")."</strong><br /><br />
    <strong>".htmlentities("1º) ")."</strong>".htmlentities("Seleccione la opción del menú de pestañas para el tipo de simulación que desee realizar.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>".htmlentities("'Una moneda', 'Varias monedas', 'Un dado' o 'Varios dados'.")."</strong><br /><br />
    <strong>".htmlentities("2º) ")."</strong>".htmlentities("Introduzca los parámetros de entrada: ")."<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Probabilidad (0,1] de salir cara para el lanzamiento de ")."<strong>".htmlentities("'Una moneda'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Probabilidad (0,1] de salir cara y número de monedas [2-8] a lanzar para el lanzamiento de ")."<strong>".htmlentities("'Varias monedas'")."</strong>.<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Tipo de dado (Perfecto) para el lanzamiento de ")."<strong>".htmlentities("'Un dado'")."</strong>".htmlentities(" perfecto.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Tipo de dado (Trucado) y probabilidad (0,1] de salir cada uno de los seis valores para el lanzamiento de ")."<strong>".htmlentities("'Un dado'")."</strong>".htmlentities(" trucado.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Número de dados [2-8] a lanzar para el lanzamiento de ")."<strong>".htmlentities("'Varios dados'")."</strong>.<br /><br />
    <strong>".htmlentities("3ª) ")."</strong>".htmlentities("Pulse algún botón de ejecución: ")."<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si pulsa sobre el botón ")."<strong>".htmlentities("'Uno a uno': ")."</strong>".htmlentities(" Simulará un solo lanzamiento.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si pulsa sobre el botón ")."<strong>".htmlentities("'Número Fijo': ")."</strong>".
    htmlentities("Se ejecutarán el número de lanzamientos de la lista desplegable ")."<strong>".htmlentities("'Número fijo'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("Por defecto, 10 lanzamientos.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si pulsa sobre el botón ")."<strong>".htmlentities("'Continuo': ")."</strong>".
    htmlentities("Se ejecutarán continuos lanzamientos hasta que pulse el botón ")."<strong>".htmlentities("'Detener'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si pulsa sobre el botón ")."<strong>".htmlentities("'Reiniciar': ")."</strong>".
    htmlentities("Reseteará todos los valores de la simulación.")."<br /><br />";
    $helpText['en'] = htmlentities("After a large number of runs, it can be seen that the frequency converges to the 
    previously assigned probability, represented by the red line.")."<br /><br />
    <strong>".htmlentities("To run the simulation correctly:")."</strong><br /><br />
    <strong>".htmlentities("1º) ")."</strong>".htmlentities("Select the tab menu option for the type of simulation you wish to perform.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>".htmlentities("'A coin', 'Several coins', 'A dice' or 'Several dice'.")."</strong><br /><br />
    <strong>".htmlentities("2º) ")."</strong>".htmlentities("Enter the input parameters: ")."<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Probability (0,1] of right side for the throw of ")."<strong>".htmlentities("'A coin'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Probability (0,1] of right side and coins number [2-8] for the throw of ")."<strong>".htmlentities("'Several coins'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Dice type (Perfect) for the throw of ")."<strong>".htmlentities("'A dice'")."</strong>".htmlentities(" that is perfect.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Dice type (Tricked) and probability (0,1] of each of the six values for the throw of ")."<strong>".htmlentities("'A dice'")."</strong>".htmlentities(" that is tricked. ")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Dice number [2-8] to be throwed for the throw of ")."<strong>".htmlentities("'Several dice'.")."</strong><br /><br />
    <strong>".htmlentities("3ª) ")."</strong>".htmlentities("Press any execution button: ")."<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- If you click on the ")."<strong>".htmlentities("'One by one'")."</strong>".htmlentities(" button: 
    Simulate a single throw.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- If you click on the ")."<strong>".htmlentities("'Fixed number'")."</strong>".htmlentities(" button: 
    The number of throws from the ")."<strong>".htmlentities("'Fixed Number'")."</strong>".htmlentities(" drop-down list will be executed. ")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("  By default, 10 throws.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- If you click on the ")."<strong>".htmlentities("'Continuous'")."</strong>".htmlentities(" button: 
    Continuous throws will be executed until you click the ")."<strong>".htmlentities("'Stop'")."</strong>".htmlentities(" button.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- If you click on the ")."<strong>".htmlentities("'Restart'")."</strong>".htmlentities(" button: 
    Reset all simulation values.")."<br /><br />";
    $helpText['fr'] = htmlentities("Après un grand nombre d'exécutions, on constate que la fréquence converge 
    vers la probabilité précédemment attribuée, représentée par la ligne rouge.")."<br /><br />
    <strong>".htmlentities("Pour exécuter la simulation correctement :")."</strong><br /><br />
    <strong>".htmlentities("1º) ")."</strong>".htmlentities("Sélectionnez l'option du menu à onglets correspondant au type de simulation que vous souhaitez effectuer.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>".htmlentities("'Une pièce', 'Plusieurs pièces', 'Un dé' o 'Plusieurs dés'.")."</strong><br /><br />
    <strong>".htmlentities("2º) ")."</strong>".htmlentities("Entrez les paramètres d'entrée: ")."<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Probabilité (0,1] de pile ou face pour le lancer de ")."<strong>".htmlentities("'Une pièce'.")."</strong>.<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Probabilité (0,1] de têtes et nombre de pièces [2-8] à lancer pour le lancer de ")."<strong>".htmlentities("'Plusieurs pièces'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Type de dé (Parfait) pour le jet de ")."<strong>".htmlentities("'Un dé'")."</strong>".htmlentities(" parfait.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Type de dé (Truqué) et la probabilité (0,1] de chacune des six valeurs pour le lancer du tour ")."<strong>".htmlentities("'Un dé'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Nombre de dés [2-8] à lancer pour le jet de ")."<strong>".htmlentities("'Plusieurs dés'.")."</strong><br /><br />
    <strong>".htmlentities("3ª) ")."</strong>".htmlentities("Appuyez sur n'importe quel bouton d'exécution : ")."<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si vous cliquez sur le bouton ")."<strong>".htmlentities("'Un par un': ")."</strong>".
    htmlentities("Simuler un seul lancement.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si vous cliquez sur le bouton ")."<strong>".htmlentities("'Nombre fixe': ")."</strong>". 
    htmlentities("Le nombre de lancements figurant dans la liste déroulante ")."<strong>".htmlentities("'Nombre fixe'")."</strong>".htmlentities(" sera exécuté.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("  Par défaut, 10 emplacements.")."<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si vous cliquez sur le bouton ")."<strong>".htmlentities("'Continuo': ")."</strong>".
    htmlentities("Les lancements continus seront exécutés jusqu'à ce que vous cliquiez sur le bouton ")."<strong>".htmlentities("'Stop'.")."</strong><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities("- Si vous cliquez sur le bouton ")."<strong>".htmlentities("'Redémarrer': ")."</strong>".
    htmlentities("Il réinitialisera toutes les valeurs de la simulation.")."<br /><br />";
        
    // Autor
    $author['es'] = "<strong>".htmlentities("Autor: ")."</strong>".htmlentities("David Checa Hidalgo. Curso 2021 - 2022.");
    $author['en'] = "<strong>".htmlentities("Author: ")."</strong>".htmlentities("David Checa Hidalgo. Course 2021 - 2022.");
    $author['fr'] = "<strong>".htmlentities("Auteur: ")."</strong>".htmlentities("David Checa Hidalgo. Cours 2021 - 2022.");
        
    // Texto de las pestañas del menú
    $tab['es'] = array(htmlentities("Una moneda"), htmlentities("Varias monedas"), htmlentities("Un dado"), htmlentities("Varios dados"));
    $tab['en'] = array(htmlentities("A coin"), htmlentities("Several coins"), htmlentities("A dice"), htmlentities("Several dice"));
    $tab['fr'] = array(htmlentities("Une pièce"), htmlentities("Plusieurs pièces"), htmlentities("Un dé"), htmlentities("Plusieurs dés"));

    // Entrada "P(x = Cara)" y mensajes vinculados
    $pX['es'] = array(htmlentities("P(x = Cara): "), htmlentities("Probabilidad de obtener Cara"), "P(x = Cara) ha de ser > 0 y <= 1");
    $pX['en'] = array(htmlentities("P(x = Right side): "), htmlentities("Probability of getting Right side"), "P(x = Right side) has to be > 0 and <= 1");
    $pX['fr'] = array(htmlentities("P(x = Face): "), htmlentities("Probabilité d'obtenir Face"), "P(x = Face) doit être > 0 et <= 1");
        
    // Textos vinculados para la pestaña "Una moneda"
    $aCoinLegends["es"] = array("P(x = Cara) Simulada", "P(x = Cara) Teórica", "Nº de lanzamientos", "Probabilidad",
                                "Lanzamientos: ", "Caras: ", "Frecuencia caras (%): ", "Cruces: ", "Frecuencia cruces (%): ");
    $aCoinLegends["en"] = array("P(x = Right side) Simulated", "P(x = Right side) Theoretical", "Nº of throws", "Probability",
                                "Throws: ", "Right sides: ", "Frequency of right sides (%): ", "Reverses: ", "Frequency of reverses (%): ");
    $aCoinLegends["fr"] = array("P(x = Face) Simulé", "P(x = Face) Théorique", "Nº de lancements", "Probabilité",
                                "Lancements: ", "Faces: ", "Fréquence des faces (%): ", "Traversées: ", "Fréquence des traversées (%): ");

    // Entrada "Nº de monedas" y mensajes vinculados
    $coinsNum['es'] = array(htmlentities("Nº de monedas:"), htmlentities("Número de monedas a lanzar"));
    $coinsNum['en'] = array(htmlentities("Nº of coins:"), htmlentities("Coins number to be throwed"));
    $coinsNum['fr'] = array(htmlentities("Nº de pièces:"), htmlentities("Nombre de pièces à lancer"));

    // Textos vinculados para la pestaña "Varias monedas"
    $sevCoinsLeg["es"] = array("Frecuencia Simulada", "Frecuencia Teórica", "Número de Caras obtenidas", "Frecuencia relativa (%)",
                               "Lanzamientos: ", "El número de monedas a lanzar ha de ser >=2 y <=8");
    $sevCoinsLeg["en"] = array("Simulated Frequency", "Theoretical Frequency", "Number of Right sides obtained", "Relative frequency (%)", 
                               "Throws: ", "The number of coins to be throwed has to be >=2 and <=8");
    $sevCoinsLeg["fr"] = array("Fréquence Simulée", "Fréquence Théorique", "Nombre de Visages obtenus", "Fréquence relative (%)",
                               "Lancements: ", "Le nombre de pièces à lancer doit être >=2 et <=8");

    // Entrada "P(x = y)" y mensajes vinculados
    $diceProb['es'] = array(htmlentities("Probabilidad de obtener 1"), htmlentities("Probabilidad de obtener 2"), htmlentities("Probabilidad de obtener 3"),
                            htmlentities("Probabilidad de obtener 4"), htmlentities("Probabilidad de obtener 5"), htmlentities("Probabilidad de obtener 6"));
    $diceProb['en'] = array(htmlentities("Probability of obtaining 1"), htmlentities("Probability of obtaining 2"), htmlentities("Probability of obtaining 3"),
                            htmlentities("Probability of obtaining 4"), htmlentities("Probability of obtaining 5"), htmlentities("Probability of obtaining 6"));
    $diceProb['fr'] = array(htmlentities("Probabilité d'obtenir 1"), htmlentities("Probabilité d'obtenir 2"), htmlentities("Probabilité d'obtenir 3"),
                            htmlentities("Probabilité d'obtenir 4"), htmlentities("Probabilité d'obtenir 5"), htmlentities("Probabilité d'obtenir 6"));

    // Entrada "Tipo de dado" y mensajes vinculados
    $diceType['es'] = array(htmlentities("Tipo de dado:"), htmlentities("Tipo de dado a lanzar"), htmlentities("Perfecto"), htmlentities("Trucado"));
    $diceType['en'] = array(htmlentities("Dice type:"), htmlentities("Dice type to be throwed"), htmlentities("Perfect"), htmlentities("Tricked"));
    $diceType['fr'] = array(htmlentities("Type de dé:"), htmlentities("Type de dé à lancer"), htmlentities("Parfait"), htmlentities("Truqué"));
        
    // Textos vinculados para la pestaña "Un dado"
    $aDiceLegends["es"] = array("Probabilidad Teórica:  Disco externo          -||-        Probabilidad Simulada:  Disco interno", "Cara 1", "Cara 2", "Cara 3",
                               "Cara 4", "Cara 5", "Cara 6", "Lanzamientos: ", "Frecuencias Relativas (%)",
                               "Debe seleccionar el tipo de dado (Perfecto o Trucado)", "P(x = 6) errónea ya que todas las probabilidades han de ser > 0, < 1 y su suma igual a 1");
    $aDiceLegends["en"] = array("Theoretical Probability:  External disk       -||-        Simulated Probability:  Internal disk", "Face 1", "Face 2", "Face 3", 
                               "Face 4", "Face 5", "Face 6", "Throws: ", "Relative Frequencies (%)",
                               "You must select the type of dice (Perfect or Tricked)", "P(x = 6) wrong as all probabilities must be > 0, < 1 and their sum equal to 1");
    $aDiceLegends["fr"] = array("Probabilité théorique:  Disque externe        -||-        Probabilité simulée :  Disque interne ", "Face 1", "Face 2", "Face 3",
                               "Face 4", "Face 5", "Face 6", "Lancements: ", "Fréquences Relatives (%)",
                               "Vous devez choisir le type de dé (Parfait ou Truqué)", "P(x = 6) faux car toutes les probabilités doivent être > 0, < 1 et leur somme égale à 1");
    
    // Entrada "Nº de dados" y mensajes vinculados
    $diceNum['es'] = array(htmlentities("Nº de dados:"), htmlentities("Número de dados a lanzar"));
    $diceNum['en'] = array(htmlentities("Nº of dice:"), htmlentities("Dice number to be throwed"));
    $diceNum['fr'] = array(htmlentities("Nº de dés:"), htmlentities("Nombre de dés à lancer"));
        
    // Textos vinculados para la pestaña "Varios dados"
    $sevDiceLeg["es"] = array("Frecuencia Simulada", "Frecuencia Teórica", "Suma de puntuaciones", "Frecuencia relativa (%)",
                               "Lanzamientos: ", "El número de dados a lanzar ha de ser >=2 y <=8");
    $sevDiceLeg["en"] = array("Simulated Frequency", "Theoretical Frequency", "Sum of scores", "Relative frequency (%)", 
                               "Throws: ", "The number of dice to be throwed has to be >=2 and <=8");
    $sevDiceLeg["fr"] = array("Fréquence Simulée", "Fréquence Théorique", "Somme des scores", "Fréquence relative (%)",
                               "Lancements: ", "Le nombre de dés à lancer doit être >=2 et <=8");
    
    // Botones de acción y título informativo al pasar el ratón
    $button['es'] = array(htmlentities("Genera un solo lanzamiento"), htmlentities("Uno a uno"), htmlentities("Genera un número de lanzamientos fijo"), htmlentities("Número fijo"),
                          htmlentities("Genera lanzamientos infinitos"), htmlentities("Continuo"), htmlentities("Detiene los lanzamientos infinitos"), htmlentities("Detener"), htmlentities("Resetea todos los valores"), htmlentities("Reiniciar"));
    $button['en'] = array(htmlentities("Generates a single throw"), htmlentities("One by one"), htmlentities("Generates a fixed number of throws"),htmlentities("Fixed number"),
                          htmlentities("Generates infinite throws"), htmlentities("Continuous"), htmlentities("Stops infinite throws"), htmlentities("Stop"), htmlentities("Resets all values"), htmlentities("Restart"));
    $button['fr'] = array(htmlentities("Génère un seul lancement"), htmlentities("Un par un"), htmlentities("Génère un nombre fixe de lancements"), htmlentities("Nombre fixe"),
                          htmlentities("Génère des hauteurs infinies"), htmlentities("Continuo"), htmlentities("Arrête les lancers infinis"), htmlentities("Stop"), htmlentities("Réinitialise toutes les valeurs"), htmlentities("Redémarrer"));
        
    // Texto a pie de página
    $footerText['es'] = htmlentities("Departamento de Estadística - Universidad de Córdoba")."<br />".htmlentities("Aptdo. 3048. E-14080 Córdoba (España)");
    $footerText['en'] = htmlentities("Statistics Department - Cordova University")."<br />".htmlentities("Aptdo. 3048. E-14080 Cordova (Spain)");
    $footerText['fr'] = htmlentities("Département des Statistiques - Université de Cordoue")."<br />".htmlentities("Aptdo. 3048. E-14080 Cordoue (Espagne)");

    // Título informativo al pasar el ratón por los números de teléfono y fax
    $contactUs['es'] = htmlentities("Contacta con nosotros");
    $contactUs['en'] = htmlentities("Contact us");
    $contactUs['fr'] = htmlentities("Contactez-nous");
        
    // Coordinadores
    $coord['es'] = htmlentities("Coordinadores:");
    $coord['en'] = htmlentities("Coordinators:");
    $coord['fr'] = htmlentities("Coordonnateurs:");
    
    
?>