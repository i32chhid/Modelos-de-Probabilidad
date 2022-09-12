<!--
     UNIVERSIDAD DE CÓRDOBA
     Escuela Politécnica Superior de Córdoba
     Departamento de Estadística, Econometría, Investigación Operativa, Organización de Empresas y
     Economía Aplicada

     Simulación de Modelos de Probabilidad con JavaScript: Lanzamiento de dados y monedas
     Autor: David Checa Hidalgo
     Director: Roberto Espejo Mohedano
     Curso 2021 - 2022
-->

<!-- CÓDIGO HTML -->

<!DOCTYPE html>
<html>

    <head>
    
        <!-- Carga del archivo PHP que gestiona el idioma -->
        <?php
            require_once('./php/lang.php');
        ?>

        <!-- Título en el idioma seleccionado -->
        <title><?php echo $title[$lang]; ?></title>
    
        <!-- Codificación de caracteres empleada -->
        <meta charset="utf-8" />
    
        <!-- Icono de la pestaña del navegador -->
        <link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
    
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
   
        <!-- Descripción sobre el contenido de la web, palabras clave para su localización y autor -->
        <meta name="description" content="Simulación de Modelos de Probabilidad con JavaScript: Lanzamiento
        de dados y monedas" />
        <meta name="keywords" content="Simulaciones Estadísticas, Estadística, Probabilidad,
        Modelos de Probabilidad, Monedas, Dados" />
        <meta name="author" content="David Checa Hidalgo" />

        <!-- Hojas de estilos de Bootstrap y personalizadas -->
        <link href="./css/styles.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
        
        <!-- Librería gráfica -->
        <script defer src="./js/Chart.js"></script>
    
        <!-- Archivos con codificación en JavaScript -->
        <script defer src="./js/severalCoins.php?lang=<?php echo($lang); ?>"></script>
        <script defer src="./js/aCoin.php?lang=<?php echo($lang); ?>"></script>
        <script defer src="./js/commonCoins.php?lang=<?php echo($lang); ?>"></script>
        <script defer src="./js/simulator.js"></script>
        <script defer src="./js/aDice.php?lang=<?php echo($lang); ?>"></script>
        <script defer src="./js/commonDice.js"></script>
        <script defer src="./js/severalDice.php?lang=<?php echo($lang); ?>"></script>
    </head>

    <body>
        <!-- Contenedor principal -->
        <div id="container-fluid">

            <!-- Cabecera -->
            <div id="header" class="row text-center">
                <div class="panel panel-default">

                    <div class="panel-heading">

                        <!-- Acceso a la página de ayuda -->
                        <div class="row text-right" id="help">
                            <img name="helpImage" id="helpImage" src="./images/help.svg" title="<?php echo $help[$lang]; ?>"
                            onmouserover="" onclick="showHelp()" alt="Acceso a la ayuda" />
                        </div>
                    
                        <!-- Título de la cabecera -->
                        <h3><strong><?php echo $header[$lang]; ?></strong></h3>

                    </div>

                    <!-- Párrafo de la cabecera -->
                    <div class="panel-body">
                        <h5><?php echo $headText[$lang]; ?></h5>
                    </div>

                </div>
            </div>
            <!-- FIN Cabecera -->

            <!-- Contenedor central -->
            <div id="centralContainer">

                <!-- Menú central de pestañas  -->
                <ul id="menu">

                    <!-- Pestaña "Una moneda" - Activa por defecto -->
                    <li class="simulation clicked" id="aCoin" onclick="start(id)">
                        <img id="coin" src="./images/coin.svg" class="hidden-xs hidden-sm" alt="Una moneda" />
                        <?php echo $tab[$lang][0]; ?>
                    </li>

                    <!-- Pestaña "Varias monedas" -->
                    <li class="simulation" id="severalCoins" onclick="start(id)">
                        <img id="coins" src="./images/coins.svg" class="hidden-xs hidden-sm" alt="Varias monedas" />
                        <?php echo $tab[$lang][1]; ?>
                    </li>

                    <!-- Pestaña "Un dado" -->
                    <li class="simulation" id="aDice" onclick="start(id)">
                        <img id="dice" src="./images/dice-1.svg" class="hidden-xs hidden-sm" alt="Un dado" />
                        <?php echo $tab[$lang][2]; ?>
                    </li>

                    <!-- Pestaña "Varios dados" -->
                    <li class="simulation" id="severalDice" onclick="start(id)">
                        <img id="smallDice" src="./images/dice-3.svg" class="hidden-xs hidden-sm" alt="Varios dados" />
                        <img id="smallDice" src="./images/dice-6.svg" class="hidden-xs hidden-sm" alt="Varios dados" />
                        <?php echo $tab[$lang][3]; ?>
                    </li>

                </ul>
                <!-- FIN Menú central de pestañas -->

                <!-- Área central de simulaciones -->
                <div id="simulationArea">

                    <!-- Botones de acción y entradas numéricas -->
                    <div class="buttons">

                        <!-- Entradas "P(x = Cara)", "Nº de monedas", "Tipo de dado" y "Nº de dados" -->
                        <div class="inputBtn">
                        
                            <!-- Entrada "Nº de monedas" -->
                            <div class="divCoinsNum">
                                <label id="label_coinsNum" for="coinsNum"><?php echo $coinsNum[$lang][0]; ?></label>
                                <!-- La entrada numérica queda deshabilitada para la pestaña "Una moneda" -->
                                <input type="number" id="coinsNum" min="1" max="8" step="1" value="1" title="<?php echo $coinsNum[$lang][1]; ?>" disabled />
                            </div>
                    
                            <!-- Entrada "P(x = Cara)" -->
                            <div class="divPx">
                                <label id="label_pX" for="pX" title="<?php echo $pX[$lang][1]; ?>"><?php echo $pX[$lang][0]; ?></label>
                                <input type="number" id="pX" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $pX[$lang][2]; ?>" />
                            </div>
            
                            <!-- Entrada "Tipo de dado" -->
                            <div class="divDiceType">
                                <label id="label_diceType"><?php echo $diceType[$lang][0]; ?></label>
                                <!-- La entrada de selección quedará deshabilitada para la pestaña "Varios dados" -->
                                <select id="diceType" class="diceType" title="<?php echo $diceType[$lang][1]; ?>" onclick="chooseDiceType()">
                                    <option id="defDiceType" value=""></option>
                                    <option id="perfectDice" value="Perfecto"><?php echo $diceType[$lang][2]; ?></option>
                                    <option id="trickedDice" value="Trucado"><?php echo $diceType[$lang][3]; ?></option>
                                </select>
                            </div>

                            <!-- Entrada "Nº de dados" -->
                            <div class="divDiceNum">
                                <label id="label_diceNum" for="diceNum"><?php echo $diceNum[$lang][0]; ?></label>
                                <!-- La entrada numérica quedará deshabilitada para la pestaña "Un dado" -->
                                <input type="number" id="diceNum" min="2" max="8" step="1" value="2" title="<?php echo $diceNum[$lang][1]; ?>" />
                            </div>
                                             
                        </div>
                        <!-- FIN de Entradas "P(x = Cara)", "Nº de monedas", "Tipo de dado" y "Nº de dados" -->
                    
                        <!-- Entradas "P(x = y)" -->
                        <div class="diceProb">
                        
                            <!-- Entrada "P(x = 1)" -->
                            <div>
                                <label id="label_pX1" for="pX1">P(x = 1):</label>
                                <input type="number" id="pX1" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $diceProb[$lang][0]; ?>" />
                            </div>

                            <!-- Entrada "P(x = 2)" -->
                            <div>
                                <label id="label_pX2" for="pX2">P(x = 2):</label>
                                <input type="number" id="pX2" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $diceProb[$lang][1]; ?>" />
                            </div>
                                    
                            <!-- Entrada "P(x = 3)" -->
                            <div>
                                <label id="label_pX3" for="pX3">P(x = 3):</label>
                                <input type="number" id="pX3" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $diceProb[$lang][2]; ?>" />
                            </div>

                            <!-- Entrada "P(x = 4)" -->
                            <div>
                                <label id="label_pX4" for="pX4">P(x = 4):</label>
                                <input type="number" id="pX4" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $diceProb[$lang][3]; ?>" />
                            </div>
              
                            <!-- Entrada "P(x = 5)" -->
                            <div>
                                <label id="label_pX5" for="pX5">P(x = 5):</label>
                                <input type="number" id="pX5" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $diceProb[$lang][4]; ?>" />
                            </div>

                            <!-- Entrada "P(x = 6)" -->
                            <div>
                                <label id="label_pX6" for="pX6">P(x = 6):</label>
                                <input type="number" id="pX6" min="0.1" max="1.0" step="0.1" value="0.0" title="<?php echo $diceProb[$lang][5]; ?>" />
                            </div>

                        </div>
                        <!-- FIN de Entradas "P(x = y)" -->
                    
                        <!-- Botones de acción -->
                        <div class="actionBtn">
                        
                            <!-- Botón "Uno a uno" -->
                            <div class="btn">
                                <button id="oneByone" title="<?php echo $button[$lang][0];?>" onclick="simulate(id)">
                                    <?php echo $button[$lang][1];?>
                                </button>
                            </div>
                        
                            <!-- Botón "Número fijo" -->
                            <div class="btn">
                                <button id="fixedNum" title="<?php echo $button[$lang][2];?>" onclick="simulate(id)">
                                    <?php echo $button[$lang][3];?>
                                </button>
                                <select id="fixedNumber" padding-top=20>
                                    <option value="number10">10</option>
                                    <option value="number50">50</option>
                                    <option value="number100">100</option>
                                    <option value="number500">500</option>
                                    <option value="number1000">1000</option>
                                </select>
                            </div>
                            
                            <!-- Botón "Continuo" -->
                            <div class="btn">
                                <button id="continuous" title="<?php echo $button[$lang][4];?>" onclick="simulate(id)">
                                    <?php echo $button[$lang][5];?>
                                </button>
                            </div>

                            <!-- Botón "Reiniciar" -->
                            <div class="btn">
                                <button id="restart" title="<?php echo $button[$lang][8];?>" onclick="simulate(id)">
                                    <?php echo $button[$lang][9];?>
                                </button>
                            </div>

                        </div>
                        <!-- FIN de Botones de acción -->
                                       
                    </div>
                    <!-- FIN Botones de acción y entradas numéricas -->

                    <!-- Botón de acción "Detener" -->
                    <div class="stopBtn">

                        <!-- Estará oculto mientras que el usuario no pulse el botón "Continuo" -->
                        <div class="btn">
                            <button id="stop" title="<?php echo $button[$lang][6];?>" onclick="simulate(id)">
                                <?php echo $button[$lang][7];?>
                            </button>
                        </div>

                    </div>
                    <!-- FIN Botón de acción "Detener" -->

                    <!-- Imágenes que representan el lanzamiento -->
                    <div class="throwImages">

                        <!-- Imagen moneda o dado 1 -->
                        <div class="divImage1">
                            <img id="image1" src="" alt="Moneda o dado 1" />
                        </div>

                        <!-- Imagen moneda o dado 2 -->
                        <div class="divImage2">
                            <img id="image2" src="" alt="Moneda o dado 2" />
                        </div>

                        <!-- Imagen moneda o dado 3 -->
                        <div class="divImage3">
                            <img id="image3" src="" alt="Moneda o dado 3" />
                        </div>

                        <!-- Imagen moneda o dado 4 -->
                        <div class="divImage4">
                            <img id="image4" src="" alt="Moneda o dado 4" />
                        </div>

                        <!-- Imagen moneda o dado 5 -->
                        <div class="divImage5">
                            <img id="image5" src="" alt="Moneda o dado 5" />
                        </div>

                        <!-- Imagen moneda o dado 6 -->
                        <div class="divImage6">
                            <img id="image6" src="" alt="Moneda o dado 6" />
                        </div>

                        <!-- Imagen moneda o dado 7 -->
                        <div class="divImage7">
                            <img id="image7" src="" alt="Moneda o dado 7" />
                        </div>

                        <!-- Imagen moneda o dado 8 -->
                        <div class="divImage8">
                            <img id="image8" src="" alt="Moneda o dado 8" />
                        </div>

                    </div>
                    <!-- FIN Imágenes que representan el lanzamiento -->

                    <!-- Contenedor para las gráficas -->
                    <div class="graphic">
                        <canvas id="myChart"></canvas>
                    </div>
                    <!-- Fin Contenedor para las gráficas -->
                
                    <!-- Leyenda inferior -->
                    <div class="bottomLegend">
                
                        <!-- Dato 1 -->
                        <div class="divText1">
                            <label id="label1" for="text1"></label>
                            <span id="text1"></span>
                        </div>

                        <!-- Dato 2 -->
                        <div class="divText2">
                            <label id="label2" for="text2"></label>
                            <span id="text2"></span>
                        </div>

                        <!-- Dato 3 -->
                        <div class="divText3">
                            <label id="label3" for="text3"></label>
                            <span id="text3"></span>
                        </div>

                        <!-- Dato 4 -->
                        <div class="divText4">
                            <label id="label4" for="text4"></label>
                            <span id="text4"></span>
                        </div>

                        <!-- Dato 5 -->
                        <div class="divText5">
                            <label id="label5" for="text5"></label>
                            <span id="text5"></span>
                        </div>
                    
                        <!-- Dato 6 -->
                        <div class="divText6">
                            <label id="label6" for="text6"></label>
                            <span id="text6"></span>
                        </div>

                        <!-- Dato 7 -->
                        <div class="divText7">
                            <label id="label7" for="text7"></label>
                            <span id="text7"></span>
                        </div>

                        <!-- Dato 8 -->
                        <div class="divText8">
                            <label id="label8" for="text8"></label>
                            <span id="text8"></span>
                        </div>

                        <!-- Dato 9 -->
                        <div class="divText9">
                            <label id="label9" for="text9"></label>
                            <span id="text9"></span>
                        </div>

                        <!-- Dato 10 -->
                        <div class="divText10">
                            <label id="label10" for="text10"></label>
                            <span id="text10"></span>
                        </div>

                        <!-- Dato 11 -->
                        <div class="divText11">
                            <label id="label11" for="text11"></label>
                            <span id="text11"></span>
                        </div>

                    </div>
                    <!-- FIN Leyenda inferior -->
                
                </div>
                <!-- FIN Área central de simulaciones -->
           
            </div>
            <!-- FIN Contenedor central -->
           
            <!-- Pie de página -->
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="row well well-lg text-center">

                        <!-- Logotipo del Aula Virtual de Estadística -->
                        <div class="col-lg-2">
                            <a>
                                <img src="http://www.uco.es/dptos/estadistica/estadistica/set/set/logovirtual.gif" class="center-block" id="virtualClass" alt="Logo Aula Virtual de Estadística" />
                            </a>
                        </div>
                        <!-- FIN Logotipo del Aula Virtual de Estadística -->

                        <!-- Texto a pie de página -->
                        <div class="col-lg-8">

                            <p><?php echo $footerText[$lang]; ?>

                                <!-- Vínculo a llamada telefónica o fax -->
                                Tel: <a title="<?php echo $contactUs[$lang]; ?>" href="tel:+34957218568">+34 957 218568</a>
                                Fax: <a title="<?php echo $contactUs[$lang]; ?>" href="tel:+34957218563">+34 957 218563</a>

                            </p>
                            <h4><?php print $coord[$lang]; ?></h4>

                            <!-- Enlace de correo electrónico a los coordinadores -->
                            <p>
                                <a title="ma1esmor@uco.es" href="mailto:ma1esmor@uco.es?subject=UCO%20-%20Aula%20Virtual%20de%20Estad&iacute;stica:%20Lanzamiento%20de%20dados%20y%20monedas" class="coord">
                                    <i class="fa fa-user fa-fw"></i> Roberto Espejo Mohedano
                                </a>
                                <a title="ma1jubem@uco.es" href="mailto:ma1jubem@uco.es?subject=UCO%20-%20Aula%20Virtual%20de%20Estad&iacute;stica:%20Lanzamiento%20de%20dados%20y%20monedas" class="coord">
                                    <i class="fa fa-user fa-fw"></i> Manuel Jurado Bello
                                </a>
                                <a title="ma1dipej@uco.es" href="mailto:ma1dipej@uco.es?subject=UCO%20-%20Aula%20Virtual%20de%20Estad&iacute;stica:%20Lanzamiento%20de%20dadoss%20y%20monedas" class="coord">
                                    <i class="fa fa-user fa-fw"></i><?php echo htmlentities("José Diz Pérez"); ?>
                                </a>
                            </p>

                        </div>
                        <!-- FIN Texto a pie de página -->

                        <!-- Enlace a la web del Aula Virtual de Estadística -->
                        <div class="col-lg-2">
                            <a href="http://www.uco.es/dptos/estadistica/estadistica/set/index.php">
                                <img src="http://www.uco.es/dptos/estadistica/estadistica/set/set/logo_set.png" class="img-responsive center-block" id="teachingArea" alt="Logo Área Docente de Estadística" />
                            </a>
                        </div>
                        <!-- FIN Enlace a la web del Aula Virtual de Estadística -->

                    </div>
                </div>
            </div>
            <!-- FIN Pie de página -->

        </div>
        <!-- FIN Contenedor principal -->

    </body>

</html>