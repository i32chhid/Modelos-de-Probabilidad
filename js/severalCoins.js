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

/* CÓDIGO JAVASCRIPT - Pestaña "Varias monedas" */

/**
 * @name throwCoins
 * @description Coordina la simulación del lanzamiento de varias monedas
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {void}
 */

function throwCoins(button) {

    // Número de monedas a lazar
    let coinsNum = document.getElementById("coinsNum").value;
    
    if (button != "restart" && valSeveralCoins(button) == true) {

        document.getElementById("label_coinsNum").style.color = "black";
        simulations.length = parseInt((document.getElementById("coinsNum").value)) + 2;

        switch(button) {

            // Botón "Uno a uno"
            case "oneByone":           
                showChartCoins(calcCoinsProb(parseInt(1), coinsNum, button));
                break;
    
            // Botón "Número fijo"
            case "fixedNum":
                let indexSelected = document.getElementById("fixedNumber").options.selectedIndex;
                let fixedThrows = document.getElementById("fixedNumber").options[indexSelected].text;

                showChartCoins(calcCoinsProb(parseInt(fixedThrows), coinsNum, button));
                break;
    
            // Botón "Continuo"
            case "continuous":  

                // Ocultamos los botones de acción
                document.querySelector(".actionBtn").style.display = "none";  
                
                // Mostramos el botón "Detener"
                document.querySelector(".stopBtn").style.display = "flex";

                // Bloque continuo hasta que el usuario pulsa el botón "Detener" o cambia de pestaña
                noStop = setInterval(function (){
                    showChartCoins(calcCoinsProb(parseInt(1), coinsNum, button));
                    showCoinsLegend(coinsNum);
                }, 500);   // Repetición cada 0,5 segundos  
                break;
    
            // Botón "Detener"
            case "stop":
                
                // Mostramos los botones de acción y ocultamos el botón "Detener"
                document.querySelector(".actionBtn").style.display = "flex"; 
                document.querySelector(".stopBtn").style.display = "none";

                // Detenemos el bloque continuo
                clearInterval(noStop);

                showChartCoins(calcCoinsProb(parseInt(1), coinsNum, button));
                break;      
        } 
        
        showCoinsLegend(coinsNum);
        
    // Botón "Reiniciar"
    } else if (button == "restart") {              
        initialise();    
    }

}


/**
 * @name valSeveralCoins
 * @description Comprueba que la "P(x = Cara)" introducida sea correcta (0,1] o, en caso contrario, muestra un mensaje de error
 *              Comprueba que el "Número de monedas" introducido sea correcto [2,8] o, en caso contrario, muestra un mensaje de error
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {boolean} validation - Devuelve "true" si la validación es correcta o "false" en caso contrario
 */

function valSeveralCoins(button) { 

    // Resultado de la validación de datos 
    let validation = true;  

    if (button != "restart") {    
       
        // Validación para la entrada "Número de monedas"
        let coinsNumMsg = ["es", "en", "fr"];
        coinsNumMsg["es"] = "El número de monedas a lanzar ha de ser >=2 y <=8";
        coinsNumMsg["en"] = "The number of coins to be throwed has to be >=2 and <=8";
        coinsNumMsg["fr"] = "Le nombre de pièces à lancer doit être >=2 et <=8";    

        // Número de monedas a lanzar introducido por el usuario
        let coinsNum = document.getElementById("coinsNum").value; 

        validation = validatePx();
        if (validation == true) {

            document.getElementById("label_pX").style.color = "black";

            if (coinsNum >= 2 && coinsNum <=8) {
                validation = true;

                // Redondeamos a número entero el número de monedas introducido 
                document.getElementById("coinsNum").value = parseInt(document.getElementById("coinsNum").value);

                // Desactivamos "Número de monedas" para que no pueda ser modificado
                document.getElementById("coinsNum").setAttribute("disabled", "");

            } else {
                document.getElementById("label_coinsNum").style.color = "red";
                alert(coinsNumMsg[langActive]);
                validation = false;
            }
        }                           
    }   
    return validation;

}


/**
 * @name calculateBinomial
 * @description Calcula la fórmula de la Distribución Binomial
 * @param {number} sample - Tamaño de la muestra
 * @param {number} successesNum - Número de éxitos
 * @return {number} Resultado del cálculo
 */
 
function calculateBinomial(sample, successesNum) {

    // Probabilidad introducida por el usuario
    let inputProb = parseFloat(document.getElementById("pX").value).toFixed(2);

    // Cáculo de la Distribución Binomial
    return parseFloat(((calculateFactorial(sample)/(calculateFactorial(successesNum)*calculateFactorial(sample-successesNum)))*Math.pow(inputProb,successesNum)*Math.pow(1-inputProb,sample-successesNum)));

}


/** 
 * @name calculateFactorial
 * @description Calcula y devuelve el factorial del número recibido como parámetro
 * @param {number} num - Número recibido para calcular su factorial
 * @return {number} - Factorial calculado
 */
 
function calculateFactorial(num) {

    if (num == 0){
        num = 1;
    } else {
        for (let i=(num-1); i>0; i--) {
            num = num*i;           
        } 
    }
    return num;

}


/**
 * @name initBarChart
 * @description Inicializa el que será el gráfico de barras empleado en la pestaña "Varias Monedas"
 * @param {void}
 * @return {void}
 */

function initBarChart(){
    
    const data = {
        labels: [],
        datasets: [{    
            // Dataset [0] - Frecuencia simulada
            label:  "", 
            data: [], 
            backgroundColor: 'rgba(54, 162, 235, 0.2)', 
            borderColor: 'rgba(54, 162, 235, 1)', 
            borderWidth: 0, 
            xAxisID: "x-axis-simulated",
            barPercentage: 0.5,
        },
        {
            // Dataset[1] - Frecuencia teórica
            label: "", 
            data: [], 
            backgroundColor: 'rgba(255, 255, 255, 0.5)', 
            borderColor: 'rgba(255, 0, 0, 1)', 
            borderWidth: 2, 
            xAxisID: "x-axis-theoretical",
            barPercentage: 0.5,
        }],
    };

    const config = {
        type: 'bar',
        data,        
        options: {           
            responsive: true,
        //    maintainAspectRatio: false, - propiedad para que el gráfico se vea bien en pantallas pequeñas
            scales: {
                xAxes: [{
                    id: "x-axis-theoretical",
                    scaleLabel: {
                        display: true,
                        labelString: "", 
                        fontColor: "#2980b9",
                      },
                },
                {
                    display: false, 
                    offset: true,
                    id: "x-axis-simulated",
                }],
                yAxes: [{                           
                    ticks: { 
                        beginAtZero: true,
                        suggestedMax: 0,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "" ,
                        fontColor: "#2980b9",
                      },
             }],                 
            },
        },
    }; 

    myChart = new Chart(ctx,config);

}


/**
 * @name showChartCoins
 * @description Actualiza y muestra en pantalla un gráfico de barras para la pestaña "Varias monedas"
 * @param {array} frequencies - frequencies[0] Frecuencia simulada tras realizar los lanzamientos de las monedas
 *                            - frequencies[1] Frecuencia teórica según la probabilidad de “P(x = Cara)” introducida por el usuario
 *  @return {void}
 */

function showChartCoins(frequencies) {
       
    // Leyendas del gráfico de barras   
    let legend = ["es", "en", "fr"];
    legend["es"] = ["Frecuencia Simulada", "Frecuencia Teórica", "Número de Caras obtenidas", "Frecuencia relativa (%)"];
    legend["en"] = ["Simulated Frequency", "Theoretical Frequency","Number of Right sides obtained", "Relative frequency (%)"];
    legend["fr"] = ["Fréquence Simulée", "Fréquence Théorique", "Nombre de Visages obtenus", "Fréquence relative (%)"];
    
    // Contenedor que incluirá la gráfica
    document.querySelector(".graphic").style.display = "flex";
    
    // Etiquetas que van en el eje X 
    let xLabels = new Array(frequencies[0].length);
    for(let i=0; i<frequencies[0].length; i++) {
        xLabels[i] = i;
    }

    // Actualización del gráfico de líneas
    myChart.data.labels = xLabels;
    myChart.data.datasets[0].data = frequencies[0];
    myChart.data.datasets[1].data = frequencies[1];
    myChart.data.datasets[0].label = legend[langActive][0];
    myChart.data.datasets[1].label = legend[langActive][1];
    myChart.config.options.scales.xAxes[0].scaleLabel.labelString = legend[langActive][2];
    myChart.config.options.scales.yAxes[0].scaleLabel.labelString = legend[langActive][3];
    myChart.update();  

}


/**
 * @name showCoinsLegend
 * @description Muestra las imágenes que representan el resultado del lanzamiento 
 *              y la leyenda inferior correspondiente para la pestaña "Varias monedas"
 * @param {number} coinsNum - Número de monedas a lanzar [2-8] 
 * @return {void}
 */

function showCoinsLegend(coinsNum) {

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
    
    // Leyenda inferior
    document.querySelector(".bottomLegend").style.display = "flex"; 
    document.querySelector(".divText1").style.display = "block";
    document.getElementById("label1").innerHTML = legend[langActive][0]; 
    document.getElementById("text1").innerHTML = parseInt(simulations[(simulations.length)-1]); 
    document.querySelector(".divText2").style.display = "block";
    document.getElementById("label2").innerHTML = legend[langActive][1]; 
    document.getElementById("text2").innerHTML = ""; 
    
    for (let i=0; i<=coinsNum; i++) {
        document.querySelector(divText[i+2]).style.display = "block";
        document.getElementById(labels[i+2]).innerHTML = i + ":"; 
        document.getElementById(texts[i+2]).innerHTML = parseFloat((simulations[i]/simulations[(simulations.length)-1])*100).toFixed(2);  
    }   

}