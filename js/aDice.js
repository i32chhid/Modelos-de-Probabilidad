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

/* CÓDIGO JAVASCRIPT - Pestaña "Un dado" */

/**
 * @name chooseDiceType
 * @description Establece probabilidades fijas (1/6) cuando el dado es "Perfecto" o a introducir por el usuario cuando es "Trucado"
 * @param {void}
 * @return {void}
 */

function chooseDiceType() {

    // Tipo de dado seleccionado
    let indexSelected = document.getElementById("diceType").options.selectedIndex;
    let chosenType = document.getElementById("diceType").options[indexSelected].text;

    // Tipo de dado "Perfecto" - Probabilidad 1/6 de obtener cualquier resultado del 1-6
    if(chosenType == "Perfecto" || chosenType == "Perfect" || chosenType == "Parfait") {
        document.getElementById("label_pX6").style.color = "black";
        document.getElementById("label_diceType").style.color = "black"; 
        
        document.querySelectorAll(".diceProb input").forEach((el) => {
            el.type = "string"
            el.value = "1/6"
            el.setAttribute("disabled", "")
        });   
        document.querySelector(".diceProb").style.display = "flex"; 

    // Tipo de dado "Trucado" - El usuario deberá introducir la probabilidad de obtener 
    // cualquier resultado del 1-5. Para el 6 se autocomplementará hasta que la suma de probabilidades sea 1
    } else if (chosenType != "") {
        document.getElementById("label_diceType").style.color = "black"; 

        document.querySelectorAll(".diceProb input").forEach((el) => {
            el.type = "number";
            el.value = parseFloat(0).toFixed(1);
            el.removeAttribute("disabled");
        });
        document.querySelector(".diceProb").style.display = "flex";  
        document.getElementById("pX6").setAttribute("disabled", "");
    } 

}


/**
 * @name throwAdice
 * @description Coordina la simulación del lanzamiento de un dado
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {void}
 */

function throwAdice(button) {

     // Tipo de dado seleccionado
     let indexSelected = document.getElementById("diceType").options.selectedIndex;
     let diceType = document.getElementById("diceType").options[indexSelected].text;
    
    if (button != "restart" && validateAdice(button, diceType) == true) {

        document.getElementById("diceType").setAttribute("disabled", "");
        document.getElementById("label_pX6").style.color = "black";
        document.getElementById("label_diceType").style.color = "black";   

        switch(button) {

            // Botón "Uno a uno"
            case "oneByone":           
                showDoughnutChart(calcAdiceProb(parseInt(1), button, diceType));
                break;
    
            // Botón "Número fijo"
            case "fixedNum":

                // Número fijo de lanzamientos introducido por el usuario 
                let indexSelected = document.getElementById("fixedNumber").options.selectedIndex;
                let fixedThrows = document.getElementById("fixedNumber").options[indexSelected].text;
               
                showDoughnutChart(calcAdiceProb(parseInt(fixedThrows), button, diceType));
                break;
    
            // Botón "Continuo"
            case "continuous":  

                // Ocultamos los botones de acción
                document.querySelector(".actionBtn").style.display = "none";  
                
                // Mostramos el botón "Detener"
                document.querySelector(".stopBtn").style.display = "flex";

                // Cargamos el gif
                document.getElementById("image1").src = "./images/dice.gif"; 

                // Bloque continuo hasta que el usuario pulsa el botón "Detener" o cambia de pestaña
                noStop = setInterval(function (){
                    showDoughnutChart(calcAdiceProb(parseInt(1), button, diceType));   
                    showAdiceLegend();                   
                }, 1000);   // Repetición cada segundo                      
                break;
    
            // Botón "Detener"
            case "stop":

                // Mostramos los botones de acción y ocultamos el botón "Detener"
                document.querySelector(".stopBtn").style.display = "none";
                document.querySelector(".actionBtn").style.display = "flex";

                // Detenemos el bloque continuo
                clearInterval(noStop);

                showDoughnutChart(calcAdiceProb(parseInt(1), button, diceType));                   
                break;        
        } 

        showAdiceLegend();

    // Botón "Reiniciar"   
    } else if (button == "restart") {      
        initialise();   
    } 

}


/**
 * @name validateAdice
 * @description Comprueba que el "Tipo de dado" y las "P(x = y)" introducidos sean correctos o, en caso contrario, muestra un mensaje de error
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @param {string} diceType - Tipo de dado seleccionado (Perfecto / Trucado)
 * @return {boolean} validation - Devuelve "true" si la validación es correcta o "false" en caso contrario
 */

function validateAdice(button, diceType) {   

    // Resultado de la validación de datos 
    let validation = true;      

    if (button != "restart") { 

        let pXsum = parseFloat(0);  // Almacena la suma de "P(x = y)"
        let validateProb = true;    // Controla que ninguna P(x = y) desde P1 a P5 sean 0

        // Validación para la entrada "Tipo de dado"
        let diceTypeMsg = ["es", "en", "fr"];
        diceTypeMsg["es"] = "Debe seleccionar el tipo de dado (Perfecto o Trucado)";
        diceTypeMsg["en"] = "You must select the type of dice (Perfect or Tricked)";
        diceTypeMsg["fr"] = "Vous devez choisir le type de dé (Parfait ou Truqué)";

        // Validación para las entradas "P(x = y)"
        let diceProbMsg = ["es", "en", "fr"];
        diceProbMsg["es"] = "P(x = 6) errónea ya que todas las probabilidades han de ser > 0, < 1 y su suma igual a 1";
        diceProbMsg["en"] = "P(x = 6) wrong as all probabilities must be > 0, < 1 and their sum equal to 1";
        diceProbMsg["fr"] = "P(x = 6) faux car toutes les probabilités doivent être > 0, < 1 et leur somme égale à 1";

        if (diceType == "") {
            alert(diceTypeMsg[langActive]);
            initialise();
            document.getElementById("label_diceType").style.color = "red";   
            validation = false;

        }else if (diceType != "Perfecto" && diceType != "Perfect" && diceType != "Parfait") {
            
            // P(x = 6) será calculada en función de la suma del resto de P(x = y)
            document.getElementById("pX6").value = parseFloat(0).toFixed(1); 

            document.querySelectorAll(".diceProb input").forEach((el) => {

                // Comprobamos que ninguna P(x = y) de 1-5 sean 0.0
                if (el.value == 0.0 && el.id != "pX6" || el.value < 0 || el.value >= 1) {
                    validateProb = false;

                } else {

                    // Sumamos todas las P(x = y) introducidas por el usuario
                    pXsum = (parseFloat(pXsum) + parseFloat(el.value)).toFixed(2);                              
                }                                                                            
            });  

            if (pXsum == parseFloat(1).toFixed(2) || pXsum >1) {
                validateProb = false;
            }

            // Establecemos P(x =6) = (1 - pXsum)   
            document.getElementById("pX6").value = parseFloat(1 - pXsum).toFixed(2);

            if (validateProb != false) {
                                        
                // Desactivamos todas las entradas de datos para que no puedan ser modificadas
                document.querySelectorAll(".diceProb input").forEach((el) => {
                    el.setAttribute("disabled", "");                                                                           
                });                

                validation = true;

            } else {
                document.getElementById("label_pX6").style.color = "red";
                alert(diceProbMsg[langActive]);
                validation = false;                                        
            }
        }                           
    }
    
    return validation;

}


/**
 * @name calcAdiceProb
 * @description Calcula la probabilidad de salir cada cara del dado "1-6" al lanzarlo
 * @param {number} throws - Número de lanzamientos
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @param {string} diceType - Tipo de dado seleccionado (Perfecto / Trucado)
 * @return {array} - array[0] Probabilidad simulada tras realizar los lanzamientos del dado
 *                 - array[1] Probabilidad teórica según el tipo de dado y los datos introducidos por el usuario
 */

function calcAdiceProb(throws, button, diceType) {  
      
    let diceValue;                  // Cara del dado obtenida         
    let simulatedProb = [];         // Probabilidad simulada
    let theoreticalProb = [];       // Probabilidad teórica
   
    // Imágenes de dados y gif
    let diceImg = ["./images/dice.gif", "./images/dice-1.svg", "./images/dice-2.svg", "./images/dice-3.svg", "./images/dice-4.svg", "./images/dice-5.svg", "./images/dice-6.svg"];

    // Número de lanzamientos
    for (let i=0; i<throws; i++) {      
        
        diceValue = calcDiceSideNum(diceType, generateRandom());
        simulations[diceValue-1] = simulations[diceValue-1]+1;

        if (button != "continuous") {
            document.getElementById("image1").style.width = "50px";     
            document.getElementById("image1").style.height = "50px"; 
            document.getElementById("image1").src = diceImg[diceValue];  
        }

        // Conteo de lanzamientos
        simulations[6] = parseInt(simulations[6]) + 1;
    }

    for (let j=0; j<6; j++) {
        simulatedProb.push((parseFloat((simulations[j]/simulations[6])).toFixed(2)));
    }

    document.querySelectorAll(".diceProb input").forEach((el) => {
        if (diceType == "Perfecto" || diceType == "Perfect" || diceType == "Parfait") {
            theoreticalProb.push(parseFloat(1/6).toFixed(2));
        } else {
            theoreticalProb.push(el.value);
        }
    }); 

    return [simulatedProb, theoreticalProb];
}


/**
 * @name initDoughnutChart
 * @description Inicializa el que será el gráfico de donut empleado en la pestaña "Un dado"
 * @param {void}
 * @return {void}
 */

function initDoughnutChart(){
    
    const data = {
        labels: [],
        datasets: [{    

            // Dataset[0] - Probabilidad teórica
            data: [], 
            backgroundColor: [
                'rgba(255, 51, 51, 0.5)',
                'rgba(51, 153, 255, 0.5)',
                'rgba(153, 255, 51, 0.5)',
                'rgba(255, 255, 51, 0.5)',
                'rgba(255, 153, 51, 0.5)',
                'rgba(255, 51, 153, 0.5)',
            ],
            borderColor: [
                'rgba(255, 0, 0, 1)', 
                'rgba(255, 0, 0, 1)', 
                'rgba(255, 0, 0, 1)', 
                'rgba(255, 0, 0, 1)', 
                'rgba(255, 0, 0, 1)', 
                'rgba(255, 0, 0, 1)', 
            ],
            borderWidth: 1,
        },
        {
            // Dataset [1] - Probabilidad simulada
            data: [], 
            backgroundColor: [
                'rgba(255, 51, 51, 0.5)',
                'rgba(51, 153, 255, 0.5)',
                'rgba(153, 255, 51, 0.5)',
                'rgba(255, 255, 51, 0.5)',
                'rgba(255, 153, 51, 0.5)',
                'rgba(255, 51, 153, 0.5)',
            ], 
            borderColor: [
                'rgba(255, 51, 51, 1)',
                'rgba(51, 153, 255, 1)',
                'rgba(153, 255, 51, 1)',
                'rgba(255, 255, 51, 1)',
                'rgba(255, 153, 51, 1)',
                'rgba(255, 51, 153, 1)',
            ],
            borderWidth: 1,
            cutout: '90%'
        },],
    };

    const config = {
        type: 'doughnut',
        data,  
        options: { 
            cutoutPercentage: 70,    
            responsive: true,
            legend: {
                position: 'bottom',
                display: true,
            },
            title: {
                display: true,
                text: '',
                fontColor: "#2980b9",
                position: 'bottom',
            },   
        },
    }; 

    myChart = new Chart(ctx,config);

}


/**
 * @name showDoughnutChart
 * @description Actualiza y muestra en pantalla un gráfico de donut para la pestaña "Un dado"
 * @param {array} probabilities - probabilities[0] Probabilidad simulada tras realizar los lanzamientos del dado
 *                              - probabilities[1] Probabilidad teórica según el tipo de dado y los datos introducidos por el usuario
 * @return {void}
 */

function showDoughnutChart(probabilities) {
    
    // Leyendas del gráfico de donut  
    let legend = ["es", "en", "fr"];
    legend["es"] = ["Probabilidad Teórica:  Disco externo          -||-        Probabilidad Simulada:  Disco interno"];
    legend["en"] = ["Theoretical Probability:  External disk       -||-        Simulated Probability:  Internal disk"];
    legend["fr"] = ["Probabilité théorique:  Disque externe        -||-        Probabilité simulée :  Disque interne "];

    let diceFaces = ["es", "en", "fr"];
    diceFaces["es"] = ["Cara 1", "Cara 2", "Cara 3", "Cara 4", "Cara 5", "Cara 6"];
    diceFaces["en"] = ["Face 1", "Face 2", "Face 3", "Face 4", "Face 5", "Face 6"];
    diceFaces["fr"] = ["Face 1", "Face 2", "Face 3", "Face 4", "Face 5", "Face 6"];

    // Contenedor que incluye la gráfica
    document.querySelector(".graphic").style.display = "flex";

    // Actualización del gráfico de donut
    myChart.data.labels = diceFaces[langActive];
    myChart.options.title.text = legend[langActive][0];
    myChart.data.datasets[0].data = probabilities[1];
    myChart.data.datasets[1].data = probabilities[0];
    myChart.update();  

}


/**
 * @name showAdiceLegend
 * @description Muestra las imágenes que representan el resultado del lanzamiento y la leyenda inferior correspondiente para la pestaña “Un dado”
 * @param {void} 
 * @return {void}
 */

function showAdiceLegend() {

    // Etiquetas leyenda inferior
    let legend = ["es", "en", "fr"];
    legend["es"] = ["Lanzamientos: ", "Frecuencias Relativas (%)"];
    legend["en"] = ["Throws: ", "Relative Frequencies (%)"];
    legend["fr"] = ["Lancements: ", "Fréquences Relatives (%)"];

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
    document.querySelector(".divImage1").style.display = "flex";

    
    // Leyenda inferior
    document.querySelector(".bottomLegend").style.display = "flex"; 
    document.querySelector(".divText1").style.display = "block";
    document.getElementById("label1").innerHTML = legend[langActive][0]; 
    document.getElementById("text1").innerHTML = parseInt(simulations[6]); 
    document.querySelector(".divText2").style.display = "block";
    document.getElementById("label2").innerHTML = legend[langActive][1]; 
    document.getElementById("text2").innerHTML = ""; 
    
    for (let i=0; i<6; i++) {
        document.querySelector(divText[i+2]).style.display = "block";
        document.getElementById(labels[i+2]).innerHTML = i+1 + ":"; 
        document.getElementById(texts[i+2]).innerHTML = parseFloat((simulations[i]/simulations[6])*100).toFixed(2);  
    }     

}