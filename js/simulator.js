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

/* CÓDIGO JAVASCRIPT COMÚN PARA TODAS LAS PESTAÑAS*/

// Variables globales
var simulations = new Array(3).fill(0);     // Resultados de las simulaciones y nº de lanzamientos
var noStop;                                 // Controla los lanzamientos continuos
var tabSelected = "aCoin";                  // Pestaña seleccionada - Por defecto "Una moneda"

// Gráficos generados dependiendo del tipo de simulación seleccionada
var ctx = document.getElementById("myChart").getContext("2d");
var myChart;

initLineChart();


/**
 * @name showHelp
 * @description Muestra el texto de Ayuda en una ventana nueva del navegador web
 * @param {void}
 * @return {void}
 */

function showHelp() {  

    window.open("./php/help.php", "helpText");

}


// Bloque que se ejecuta al hacer click en las opciones del menú central de simulaciones
document.querySelectorAll(".simulation").forEach((el) =>
    el.addEventListener("click", function () {
        if (!this.classList.contains("clicked")) {
            clearMenu();
            this.classList.add("clicked");
        }
    })
);


/**
 * @name clearMenu
 * @description Limpia el menú de pestañas al hacer click sobre alguna de ellas
 * @param {void}
 * @return {void}
 */

function clearMenu() {

    document.querySelectorAll(".simulation").forEach((el) =>
        el.classList.remove("clicked"));

}


/**
 * @name start
 * @description Muestra las entradas de datos, botones necesarios para cada pestaña
 *              con sus valores por defecto y oculta el resto
 * @param {string} tab - Nombre de la pestaña activa del menú central
 * @return {void}
 */

function start(tab) {

    // Nombre de la pestaña seleccionada/activa
    tabSelected = tab;

    initialise();
       
    switch(tab) {

        // Pestaña "Una moneda"
        case "aCoin":
            document.querySelector(".divPx").style.display = "flex";
            document.querySelector(".divCoinsNum").style.display = "flex";
            document.getElementById("coinsNum").value = parseInt(1,10);
            document.getElementById("coinsNum").setAttribute("disabled", "");
            document.querySelector(".diceProb").style.display = "none";
            document.querySelector(".divDiceNum").style.display = "none";
            document.querySelector(".divDiceType").style.display = "none";
            break;

        // Pestaña "Varias monedas"
        case "severalCoins":
            document.querySelector(".divPx").style.display = "flex";
            document.querySelector(".divCoinsNum").style.display = "flex";
            document.getElementById("coinsNum").removeAttribute("disabled");
            document.getElementById("coinsNum").min = parseInt(2,10);
            document.getElementById("coinsNum").value = parseInt(2,10);
            document.querySelector(".diceProb").style.display = "none";
            document.querySelector(".divDiceNum").style.display = "none";
            document.querySelector(".divDiceType").style.display = "none";
            break;

        // Pestaña "Un dado"
        case "aDice":
            document.querySelector(".divDiceType").style.display = "flex";
            document.querySelector(".divDiceNum").style.display = "flex";
            document.getElementById("diceNum").setAttribute("disabled", "");
            document.getElementById("diceType").value = "";    
            document.querySelector(".divPx").style.display = "none";
            document.querySelector(".divCoinsNum").style.display = "none"; 
            break;

        // Pestaña "Varios dados"
        case "severalDice":
            document.querySelector(".divDiceType").style.display = "flex";
            document.getElementById("diceType").setAttribute("disabled", "");
            document.querySelector(".divDiceNum").style.display = "flex";
            document.getElementById("diceNum").removeAttribute("disabled");
            document.querySelector(".divPx").style.display = "none";
            document.querySelector(".divCoinsNum").style.display = "none";
            document.querySelector(".diceProb").style.display = "none";
            break;
    }

}


/**
 * @name initialise
 * @description Inicializa todas las variables y configura la pestaña actual a su estado inicial
 * @param {void}
 * @return {void}
 */

function initialise() {

    // Inicialización de las variables a sus valores por defecto              
    document.getElementById("fixedNumber").options.selectedIndex = 0;
   
    // Detenemos el método de JavaScript "setInterval" si estuviera activo
    clearInterval(noStop);

    // Configuramos los elementos del DOM a su estado inicial
    document.querySelector(".stopBtn").style.display = "none";
    document.querySelector(".actionBtn").style.display = "flex";
    document.querySelector(".throwImages").style.display = "none";
    document.querySelector(".graphic").style.display = "none";
    document.querySelector(".bottomLegend").style.display = "none";
    document.querySelectorAll(".throwImages div").forEach((el) => {
        el.style.display = "none"
    });
    document.querySelectorAll(".throwImages img").forEach((el) => {
        el.style.height = "60px";
        el.style.width = "60px";
        el.src = "";
    });  
    document.querySelector(".graphic").style.width = "50%";
    document.querySelectorAll(".bottomLegend div").forEach((el) => {
        el.style.display = "none";
    });
    
    // Eliminamos gráficos anteriores
    myChart.destroy();

    switch(tabSelected){

        // Pestaña "Una Moneda"
        case "aCoin":
            document.getElementById("pX").value = parseFloat(0).toFixed(1);
            document.getElementById("pX").removeAttribute("disabled");
            document.getElementById("label_pX").style.color = "black";
            document.getElementById("label_coinsNum").style.color = "black";
            initLineChart();
            simulations.length = 3;
            break;
        
        // Pestaña "Varias monedas"
        case "severalCoins":
            document.getElementById("pX").value = parseFloat(0).toFixed(1);
            document.getElementById("pX").removeAttribute("disabled");
            document.getElementById("label_pX").style.color = "black";
            document.getElementById("coinsNum").value = parseInt(2,10);
            document.getElementById("coinsNum").removeAttribute("disabled");
            document.getElementById("label_coinsNum").style.color = "black";
            initBarChart();
            simulations.length = 10;
            break;

        // Pestaña "Un dado"
        case "aDice":
            document.getElementById("diceNum").value = parseInt(1,10);
            document.getElementById("label_diceNum").style.color = "black";
            document.getElementById("diceType").removeAttribute("disabled");
            document.getElementById("diceType").value = "";
            document.getElementById("label_diceType").style.color = "black";   
            document.querySelector(".diceProb").style.display = "none";
            document.getElementById("label_pX6").style.color = "black";
            initDoughnutChart();
            simulations.length = 7;
            break;

        // Pestaña "Varios dados"
        case "severalDice":
            document.getElementById("diceNum").value = parseInt(2,10);
            document.getElementById("diceNum").removeAttribute("disabled");
            document.getElementById("label_diceNum").style.color = "black";
            document.getElementById("diceType").options.item(1).selected = "selected";
            document.getElementById("label_diceType").style.color = "black";
            initBarChart();        
            simulations.length = 42;
            break;
    }

    // Inicializamos el vector dinámico a 0
    simulations.fill(0);

}


/**
 * @name simulate
 * @description Inicia la simulación correspondiente según la pestaña activa y el botón de acción
 *              seleccionado por el usuario
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {void}
 */

function simulate(button) {

    location.href = "#menu";

    switch(tabSelected) {

        // Pestaña "Una moneda"
        case "aCoin":   
            throwAcoin(button);
            break;
    
        // Pestaña "Varias monedas"
        case "severalCoins":
            throwCoins(button);
            break;
    
        // Pestaña "Un dado"
        case "aDice":
            throwAdice(button);               
            break;
    
        // Pestaña "Varios dados"
        case "severalDice":         
            throwDice(button);      
            break; 
    }

}


/**
 * @name generateRandom
 * @description Genera y devuelve un número entero aleatorio entre 0 y 1
 * @param {void}
 * @return {number} randomNum - Número generado
 */

function generateRandom() {

    let randomNum = Math.random();
    return randomNum;

}