<?php
    header('Content-Type: application/javascript; charset=utf-8');
?>


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

/* CÓDIGO JAVASCRIPT - Pestaña "Una moneda" */

/**
 * @name throwAcoin
 * @description Coordina la simulación del lanzamiento de una moneda
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {void}
 */

function throwAcoin(button) {

    if (button !== "restart" && validatePx() === true) {

        document.getElementById("label_pX").style.color = "black";

        switch(button) {

            // Botón "Uno a uno"
            case "oneByone":
                showLineGraph(calcCoinsProb(parseInt(1,10), parseInt(1,10), button));
                break;
    
            // Botón "Número fijo"
            case "fixedNum":

                // Número fijo de lanzamientos introducido por el usuario 
                let indexSelected = document.getElementById("fixedNumber").options.selectedIndex;
                let fixedThrows = document.getElementById("fixedNumber").options[indexSelected].text;
               
                showLineGraph(calcCoinsProb(parseInt(fixedThrows,10), parseInt(1,10), button));
                break;
    
            // Botón "Continuo"
            case "continuous":

                // Ocultamos los botones de acción
                document.querySelector(".actionBtn").style.display = "none";     
                
                // Mostramos el botón "Detener"
                document.querySelector(".stopBtn").style.display = "flex";

                // Cargamos el gif
                document.getElementById("image1").src = "./images/euro.gif";

                // Bloque continuo hasta que el usuario pulsa el botón "Detener" o cambia de pestaña
                noStop = setInterval(function (){
                    showLineGraph(calcCoinsProb(parseInt(1,10), parseInt(1,10), button)); 
                    showAcoinLegend();              
                }, 500);   // Repetición cada 0.5 segundos
                break;
    
            // Botón "Detener"
            case "stop":

                // Mostramos los botones de acción y ocultamos el botón "Detener"
                document.querySelector(".actionBtn").style.display = "flex";
                document.querySelector(".stopBtn").style.display = "none";
                               
                // Detenemos el bloque continuo
                clearInterval(noStop);

                showLineGraph(calcCoinsProb(parseInt(1,10), parseInt(1,10), button));
                break;
        }

        showAcoinLegend();
        
    // Botón "Reiniciar"
    } else if (button === "restart") {
        initialise();
    }

}


/**
 * @name initLineChart
 * @description Inicializa el que será el gráfico de líneas empleado en la pestaña "Una moneda"
 * @param {void}
 * @return {void}
 */

function initLineChart(){
    
    const data = {
        labels: [],
        datasets: [{
            // Dataset [0] - Probabilidad simulada
            label:  "",
            data: [],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
        },
        {
            // Dataset[1] - Probabilidad teórica
            label: "",
            data: [],
            backgroundColor: 'rgba(255, 255, 255, 0.5)',
            borderColor: 'rgba(255, 0, 0, 1)',
            borderWidth: 2.5,
            radius: 0,
        }],
    };

    const config = {
        type: 'line',
        data,
        options: {
            responsive: true,
            scales: {
                xAxes: [{               
                    scaleLabel: {
                        display: true,
                        labelString: "",
                        fontColor: "#2980b9",
                    },
                }],
                yAxes: [{              
                    ticks: {
                        beginAtZero: true,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "",
                        fontColor: "#2980b9",
                    },
                }],              
            },
        },
    };

    myChart = new Chart(ctx,config);

}


// Almacenamos las leyendas según el idioma activo
let aCoinLegends = [];
<?php
    @require_once('../php/lang.php');

    $i = 0;
    foreach($aCoinLegends[$lang] as $legend) {
        echo("aCoinLegends[$i] = '$legend';\n");
        $i++;
    }
?>


/**
 * @name showLineGraph
 * @description Actualiza y muestra en pantalla un gráfico de líneas para la pestaña "Una moneda"
 * @param {array} probabilities - probabilities[0] Probabilidad simulada tras realizar los lanzamientos de la moneda
 *                              - probabilities[1] Probabilidad teórica introducida por el usuario
 * @return {void}
 */

function showLineGraph(probabilities) {
     
    // Etiquetas que van en el eje X
    let xLabels = new Array(probabilities[0]);
    if (myChart.data.labels.length === 0) {
        xLabels[0] = 1;
    } else {
        xLabels[0] = parseInt(myChart.data.labels.length-1,10)+2;
    }
    for(let i=1; i<probabilities[0].length; i++) {
        xLabels[i] = xLabels[i-1] + 1;
    }

    // Actualización del gráfico de líneas
    myChart.data.labels = myChart.data.labels.concat(xLabels);
    myChart.data.datasets[0].data = myChart.data.datasets[0].data.concat(probabilities[0]);
    myChart.data.datasets[1].data = myChart.data.datasets[1].data.concat(probabilities[1]);
    myChart.data.datasets[0].label = aCoinLegends[0];
    myChart.data.datasets[1].label = aCoinLegends[1];
    myChart.config.options.scales.xAxes[0].scaleLabel.labelString = aCoinLegends[2];
    myChart.config.options.scales.yAxes[0].scaleLabel.labelString = aCoinLegends[3];
    myChart.update();
    
    // Contenedor que incluye la gráfica
    document.querySelector(".graphic").style.display = "flex";
    document.querySelector(".graphic").style.minHeight = "100px"

}


/**
 * @name showAcoinLegend
 * @description Muestra las imágenes que representan el resultado del lanzamiento
 *              y la leyenda inferior correspondiente para la pestaña "Una moneda"
 * @param {void}
 * @return {void}
 */

function showAcoinLegend() {
    
    // Imágenes
    document.querySelector(".throwImages").style.display = "flex";
    document.querySelector(".divImage1").style.display = "flex";
    document.getElementById("image1").style.width = "60px";
    document.getElementById("image1").style.height = "60px";

    // Leyenda inferior
    document.querySelector(".bottomLegend").style.display = "flex";
    document.querySelector(".divText1").style.display = "block";
    document.getElementById("label1").innerHTML = aCoinLegends[4];
    document.getElementById("text1").innerHTML = parseInt(simulations[(simulations.length)-1],10);
    document.querySelector(".divText2").style.display = "block";
    document.getElementById("label2").innerHTML = aCoinLegends[5];
    document.getElementById("text2").innerHTML = parseInt(simulations[1],10);
    document.querySelector(".divText3").style.display = "block";
    document.getElementById("label3").innerHTML = aCoinLegends[6];
    document.getElementById("text3").innerHTML = parseFloat((simulations[1]/simulations[(simulations.length)-1])*100).toFixed(2);
    document.querySelector(".divText4").style.display = "block";
    document.getElementById("label4").innerHTML = aCoinLegends[7];
    document.getElementById("text4").innerHTML = parseInt(simulations[0],10);
    document.querySelector(".divText5").style.display = "block";
    document.getElementById("label5").innerHTML = aCoinLegends[8];
    document.getElementById("text5").innerHTML = parseFloat((simulations[0]/simulations[(simulations.length)-1])*100).toFixed(2);

}