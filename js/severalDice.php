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

/* CÓDIGO JAVASCRIPT - Pestaña "Varios dados" */

/**
 * @name throwDice
 * @description Coordina la simulación del lanzamiento de varios dados
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {void}
 */

function throwDice(button) {

    // Número de dados a lanzar
    let diceNum = document.getElementById("diceNum").value;

    if (button != "restart" && valDiceNum(button, diceNum) === true) {

        document.getElementById("label_diceNum").style.color = "black";

        switch(button) {

            // Botón "Uno a uno"
            case "oneByone":
                showChartDice(calcDiceProb(parseInt(1,10), button, diceNum), diceNum);  
                break;
    
            // Botón "Número fijo"
            case "fixedNum":
                
                // Número fijo de lanzamientos introducido por el usuario 
                let indexSelected = document.getElementById("fixedNumber").options.selectedIndex;
                let fixedThrows = document.getElementById("fixedNumber").options[indexSelected].text;

                showChartDice(calcDiceProb(parseInt(fixedThrows,10), button, diceNum), diceNum); 
                break;
    
            // Botón "Continuo"
            case "continuous":

                // Ocultamos los botones de acción
                document.querySelector(".actionBtn").style.display = "none";
                
                // Mostramos el botón "Detener"
                document.querySelector(".stopBtn").style.display = "flex";

                // Bloque continuo hasta que el usuario pulsa el botón "Detener" o cambia de pestaña
                noStop = setInterval(function (){            
                    showChartDice(calcDiceProb(parseInt(1,10), button, diceNum), diceNum);
                    showDiceLegend(diceNum);
                }, 500);   // Repetición cada 0.5 segundos
                             
                break;
    
            // Botón "Detener"
            case "stop":

                // Mostramos los botones de acción y ocultamos el botón "Detener"
                document.querySelector(".stopBtn").style.display = "none";
                document.querySelector(".actionBtn").style.display = "flex";

                // Detenemos el bloque continuo
                clearInterval(noStop);

                showChartDice(calcDiceProb(parseInt(1,10), button, diceNum), diceNum);
                break;
        }

        showDiceLegend(diceNum);

    // Botón "Reiniciar"
    } else if (button === "restart") {  
        initialise();
    }

}


// Almacenamos las leyendas según el idioma activo
let sevDiceLeg = [];
<?php
    @require_once('../php/lang.php');

    $i = 0;
    foreach($sevDiceLeg[$lang] as $legend) {
        echo("sevDiceLeg[$i] = '$legend';\n");
        $i++;
    }
?>


/**
 * @name valDiceNum
 * @description Comprueba que el "Nº de dados" introducido sean correcto o, en caso contrario, muestra un mensaje de error
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @param {number} diceNum - Número de dados a lanzar [2-8]
 * @return {boolean} validation - Devuelve "true" si la validación es correcta o "false" en caso contrario
 */

function valDiceNum(button, diceNum) {

    // Resultado de la validación de datos
    let validation = true;

    if (button != "restart") {    

        if (diceNum >= 2 && diceNum <=8) {
            validation = true;

            // Redondeamos a número entero el número de dados introducido
            document.getElementById("diceNum").value = parseInt(document.getElementById("diceNum").value,10);

            // Desactivamos "Nº de dados" para que no pueda ser modificado
            document.getElementById("diceNum").setAttribute("disabled", "");

        } else {
            document.getElementById("label_diceNum").style.color = "red";
            alert(sevDiceLeg[5]);
            validation = false;
        }
    }
    return validation;

}


/**
 * @name calcDiceProb
 * @description Calcula las frecuencias de la suma de puntuaciones al lanzar varios dados al aire
 * @param {number} throws - Número de lanzamientos
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @param {number} diceNum - Número de dados a lanzar [2-8]
 * @return {array} - array[0] Suma de puntuaciones posibles según el número de dados a lanzar
 *                 - array[1] Frecuencia simulada tras realizar los lanzamientos de los dados
 *                 - array[2] Frecuencia teórica según el número de dados a lanzar
 */

function calcDiceProb(throws, button, diceNum) {

    // Combinaciones posibles según el número de dados
    let combinations = [];
    for (let i=diceNum; i<=diceNum*6; i++) {
        combinations.push(parseInt(i,10));
    }

    simulations.length = combinations.length+1;

    // Frecuencia teórica
    let theoreticalFreq = [[2.78, 5.56, 8.33, 11.11, 13.89, 16.67, 13.89, 11.11, 8.33, 5.56, 2.78],
                          [0.46, 1.39, 2.78, 4.63, 6.94, 9.72, 11.57, 12.5, 12.5, 11.57, 9.72, 6.94, 4.63, 2.78, 1.39, 0.46],
                          [0.08, 0.31, 0.77, 1.54, 2.7, 4.32, 6.17, 8.02, 9.65, 10.8, 11.27, 10.8, 9.65, 8.02, 6.17, 4.32, 2.7, 1.54, 0.77, 0.31, 0.08],
                          [0.01, 0.06, 0.19, 0.45, 0.9, 1.62, 2.64, 3.92, 5.4, 6.94, 8.37, 9.45, 10.03, 10.03, 9.45, 8.37, 6.94, 5.4, 3.92, 2.64, 1.62, 0.9, 0.45, 0.19, 0.06, 0.01],
                          [0, 0.01, 0.09, 0.12, 0.27, 0.54, 0.98, 1.62, 2.49, 3.57, 4.82, 6.12, 7.35, 8.37, 9.05, 9.28, 9.05, 8.37, 7.35, 6.12, 4.82, 3.57, 2.49, 1.62, 0.98, 0.54, 0.27, 0.12, 0.09, 0.01, 0],
                          [0, 0, 0.01, 0.03, 0.08, 0.17, 0.33, 0.6, 1, 1.58, 2.34, 3.27, 4.33, 5.45, 6.55, 7.5, 8.2, 8.58, 8.58, 8.58, 8.2, 7.5, 6.55, 5.45, 4.33, 3.27, 2.34, 1.58, 1, 0.6, 0.33, 0.17, 0.08, 0.03, 0.01,0,0],
                          [0, 0, 0 , 0.01, 0.02, 0.05, 0.1, 0.2, 0.37, 0.62, 1, 1.52, 2.18, 2.99, 3.92, 4.9, 5.88, 6.77, 7.48, 7.94, 8.09, 7.94, 7.48, 6.77, 5.88, 4.9, 3.92, 2.99, 2.18, 1.52, 1, 0.62, 0.37, 0.2, 0.1, 0.05, 0.02, 0.01, 0, 0, 0]];

    // Cara del dado obtenida
    let diceValue;

    // Imágenes de dados y gif
    let diceImg = ["./images/dice.gif", "./images/dice-1.svg", "./images/dice-2.svg", "./images/dice-3.svg", "./images/dice-4.svg", "./images/dice-5.svg", "./images/dice-6.svg"];

    // Id´s de los contenedores de las imágenes empleadas
    let divImg = [];
    document.querySelectorAll(".throwImages div").forEach((el) => {
        divImg.push(".".concat(el.className));                                                                       
    });
    
     // Id´s de las imágenes empleadas en la leyenda
    let imgId = [];
    document.querySelectorAll(".throwImages img").forEach((el) => {
        imgId.push(el.id);                                                                      
    });

    // Índice que ocupa la suma de puntuaciones
    let index;

    // Número de lanzamientos
    for (i=0; i<throws; i++) {
        
        // Suma de puntuaciones al lanzar los dados
        let throwAmount = 0;

        for (let j=0; j<diceNum; j++) {
            
            diceValue = calcDiceSideNum("Perfect", generateRandom()); 

            throwAmount = parseInt(throwAmount + diceValue,10);
            document.querySelector(divImg[j]).style.display = "flex";

            if (button === "continuous") {   
                document.getElementById(imgId[j]).src = diceImg[0]; 
            }else {
                document.querySelectorAll(".throwImages img").forEach((el) => {
                    el.style.height = "50px";
                    el.style.width = "50px";
                });
                document.getElementById(imgId[j]).src = diceImg[diceValue];
            }
        }

        document.getElementById("text2").innerHTML = throwAmount;

        index = combinations.indexOf(throwAmount);
        simulations[index] = simulations[index]+1;

        // Conteo de lanzamientos
        simulations[(simulations.length)-1] = parseInt(simulations[(simulations.length)-1],10) + 1;
        
    }
   
    // Frecuencia simulada
    let simulatedFreq = new Array(combinations.length);
    for (i=0; i<combinations.length; i++) {
        simulatedFreq[i] = parseFloat((simulations[i] / simulations[(simulations.length)-1])*100).toFixed(2);
    }
  
    return [combinations, simulatedFreq, theoreticalFreq[diceNum-2]];
}


/**
 * @name showChartDice
 * @description Actualiza y muestra en pantalla un diagrama de barras para la pestaña "Varios dados"
 * @param {array} dataCollection - dataCollection[0] Suma de puntuaciones posibles según el número de dados a lanzar
 *                               - dataCollection[1] Frecuencia simulada tras realizar los lanzamientos de los dados
 *                               - dataCollection[2] Frecuencia teórica según el número de dados a lanzar
 * @param {number} diceNum - Número de dados a lanzar [2-8]
 * @return {void}
*/

function showChartDice(dataCollection, diceNum) {

    if (diceNum>4) {
        document.querySelector(".graphic").style.width = "70%";
    }

    // Actualización del diagrama de barras
    myChart.data.labels = dataCollection[0];
    myChart.data.datasets[1].borderWidth = "1.5";
    myChart.data.datasets[0].data = dataCollection[1];
    myChart.data.datasets[1].data = dataCollection[2];
    myChart.data.datasets[0].label = sevDiceLeg[0];
    myChart.data.datasets[1].label = sevDiceLeg[1];
    myChart.config.options.scales.xAxes[0].scaleLabel.labelString = sevDiceLeg[2];
    myChart.config.options.scales.yAxes[0].scaleLabel.labelString = sevDiceLeg[3];
    myChart.update();

    // Contenedor que incluye la gráfica
    document.querySelector(".graphic").style.display = "flex";
    document.querySelector(".graphic").style.minHeight = "100px";

}


/**
 * @name showDiceLegend
 * @description Muestra las imágenes que representan el resultado del lanzamiento
 *              y la leyenda inferior correspondiente para la pestaña "Varios dados"
 * @param {void}
 * @return {void}
 */

function showDiceLegend() {

    // Id´s de los contenedores de los textos empleados
    let divText = [];
    document.querySelectorAll(".bottomLegend div").forEach((el) => {
        divText.push(".".concat(el.className));                                                                   
    });

    // Id´s de las etiquetas empleadas
    let labels = [];
    document.querySelectorAll(".bottomLegend label").forEach((el) => {
        labels.push(el.id);                                                                           
    }); 

    // Id´s de los textos empleados
    let texts = [];
    document.querySelectorAll(".bottomLegend span").forEach((el) => {
        texts.push(el.id);                                                                       
    });
   
    // Imágenes
    document.querySelector(".throwImages").style.display = "flex";
    
    // Leyenda inferior
    document.querySelector(".bottomLegend").style.display = "flex";
    document.querySelector(".divText1").style.display = "block";
    document.getElementById("label1").innerHTML = sevDiceLeg[4]; 
    document.getElementById("text1").innerHTML = parseInt(simulations[(simulations.length)-1],10);
    document.querySelector(".divText2").style.display = "block";
    document.getElementById("label2").innerHTML = sevDiceLeg[2];

}