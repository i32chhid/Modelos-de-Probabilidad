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

<!-- PÁGINA DE AYUDA -->

<!DOCTYPE html>
<html>

    <head>
     
        <!-- Archivo PHP que gestiona el idioma -->
        <?php
            require_once('../php/lang.php');
        ?>   

        <!-- Título en el idioma seleccionado -->
        <title><?php echo $help[$lang]; ?> .- <?php echo $title[$lang]; ?></title>
    
        <!-- Codificación de caracteres empleada -->
        <meta charset="utf-8" />
    
        <!-- Icono de la pestaña del navegador -->
        <link rel="shortcut icon" type="image/ico" href="../images/favicon.ico" />
    
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
   
        <!-- Hojas de estilos de Bootstrap y personalizadas -->
        <link href="../css/styles.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />    
   
    </head>

    <body>
        <!-- Contenedor principal -->
        <div id="container-fluid">

            <!-- Cabecera -->
            <div id="header" class="row text-center">
                <div class="panel panel-default">

                    <!-- Título de la cabecera -->
                    <div class="panel-heading">
                        <h3><strong><?php echo $help[$lang]; ?> .- </strong><?php echo $header[$lang]; ?></h3>
                    </div>

                    <!-- Párrafo de la cabecera -->
                    <div class="panel-body">
                        <h5><strong><?php echo $headText[$lang]; ?></strong></h5>
                    </div>

                </div>
            </div>
            <!-- FIN Cabecera -->

            <!-- Contenedor central para el texto de ayuda -->
            <div class="center-block" id="helpContainer">

                <!-- Texto de ayuda en el idioma seleccionado -->
                <h5><?php echo $helpText[$lang]; ?></h5>

            </div>

            <div id="author">
                <h5><?php echo $author[$lang]; ?></h5>
            </div>
            <!-- FIN Contenedor central para el texto de ayuda -->
    
            <!-- Pie de página -->
            <div class="row text-center">   
                <div class="col-lg-12">            
                    <div class="row well well-lg text-center">

                        <!-- Logotipo del Aula Virtual de Estadística -->
                        <div class="col-lg-2">
                            <a>
                                <img src="http://www.uco.es/dptos/estadistica/estadistica/set/set/logovirtual.gif" class="center-block" style="padding: 10px;" alt="Logo Aula Virtual Estadística" />
                            </a>
                        </div>
                        <!-- FIN Logotipo del Aula Virtual de Estadística -->

                        <!-- Texto a pie de página según idioma seleccionado -->
                        <div class="col-lg-8">

                            <p><?php echo $footerText[$lang]; ?>

                                <!-- Vínculo a llamada telefónica o fax -->
                                Tel: <a title="<?php echo $contactUs[$lang]; ?>" href="tel:+34957218568">+34 957 218568</a>
                                Fax: <a title="<?php echo $contactUs[$lang]; ?>" href="tel:+34957218563">+34 957 218563</a>

                            </p>
                            <h4><?php print $coord[$lang]; ?></h4>

                            <!-- Enlace de correo electrónico a los coordinadores -->              
                            <p>
                                <a title="ma1esmor@uco.es" href="mailto:ma1esmor@uco.es?subject=UCO%20-%20Aula%20Virtual%20de%20Estadística:%20Lanzamiento%20de%20monedas%20y%20dados." class="coord">
                                    <i class="fa fa-user fa-fw"></i> Roberto Espejo Mohedano
                                </a>
                                <a title="ma1jubem@uco.es" href="mailto:ma1jubem@uco.es?subject=UCO%20-%20Aula%20Virtual%20de%20Estadística:%20Lanzamiento%20de%20monedas%20y%20dados." class="coord">
                                    <i class="fa fa-user fa-fw"></i> Manuel Jurado Bello
                                </a>
                                <a title="ma1dipej@uco.es" href="mailto:ma1dipej@uco.es?subject=UCO%20-%20Aula%20Virtual%20de%20Estadística:%20Lanzamiento%20de%20monedas%20y%20dados." class="coord">
                                    <i class="fa fa-user fa-fw"></i><?php echo htmlentities("José Diz Pérez"); ?>
                                </a>
                            </p>

                        </div>
                        <!-- FIN Texto a pie de página según idioma seleccionado -->

                        <!-- Enlace a la web del Aula Virtual de Estadística -->
                        <div class="col-lg-2">
                            <a href="http://www.uco.es/dptos/estadistica/estadistica/set/index.php">
                                <img src="http://www.uco.es/dptos/estadistica/estadistica/set/set/logo_set.png" class="img-responsive center-block" style="padding: 10px;" alt="Logo Aula Virtual Estadística" />
                            </a>
                        </div>
                        <!-- FIN Logotipo y enlace a la web del Aula Virtual de Estadística -->

                    </div>
                </div>
            </div>
            <!-- FIN Pie de página -->
        
        </div>
        <!-- FIN  Contenedor principal -->

    </body>

</html>