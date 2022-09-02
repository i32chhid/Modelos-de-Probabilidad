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

/* CÓDIGO JAVASCRIPT COMÚN PARA LAS PESTAÑAS "Una moneda" Y "Varias monedas" */

/**
 * @name validatePx
 * @description Comprueba que la "P(x = Cara)" introducida sea correcta (0,1] o, en caso contrario, muestra un mensaje de error
 * @param {void}
 * @return {boolean} - Devuelve "true" si la validación es correcta o "falso" en caso contrario
 */

function validatePx() {

    // Validación para la entrada "P(x = Cara)"
    let aCoinMsg = ["es", "en", "fr"];
    aCoinMsg["es"] = "P(x = Cara) ha de ser > 0 y <= 1";
    aCoinMsg["en"] = "P(x = Right side) has to be > 0 and <= 1";
    aCoinMsg["fr"] = "P(x = Face) doit être > 0 et <= 1";
    
    // Probabilidad de obtener cara introducida por el usuario 
    let pX = document.getElementById("pX").value; 

    if (pX > 0 && pX <=1) {

        // Desactivamos "P(x = Cara)" para que no pueda ser modificada
        document.getElementById("pX").setAttribute("disabled", ""); 
        return true;

    } else {
        document.getElementById("label_pX").style.color = "red";
        alert(aCoinMsg[langActive]);
        return false;
    } 

}


/**
 * @name calcCoinsProb
 * @description Calcula las probabilidades, simulada y teórica, de salir "Cara" al lanzar una o varias monedas al aire
 * @param {number} throws - Número de lanzamientos
 * @param {number} coinsNum - Número de monedas a lanzar [1-8]
 * @param {string} button - Nombre del botón pulsado por el usuario
 * @return {array} - array[0] Probabilidad (Una moneda) o frecuencia (Varias monedas) simulada tras realizar los lanzamientos
 *                 - array[1] Probabilidad (Una moneda) o frecuencia (Varias monedas) teórica según los datos introducidos por el usuario
 */

function calcCoinsProb(throws, coinsNum, button) {  
  
    
    let simulated = [];         // Probabilidad/Frecuencia simulada 
    let theoretical = [];       // Probabilidad/Frecuencia teórica

    // Id´s de los contenedores de las imágenes empleadas
    let divImg = [];
    document.querySelectorAll(".throwImages div").forEach((el) => {
        divImg.push(".".concat(el.className));                                                                           
    }); 
    
    // Id´s de las imágenes empleadas en la leyenda
    let coinsImg = []; 
    document.querySelectorAll(".throwImages img").forEach((el) => {
        coinsImg.push(el.id);                                                                           
    }); 
   
    // Número de lanzamientos a realizar
    for (let i=1; i<=throws; i++) {

        // Número de caras obtenidas en cada lanzamiento
        let rSideNum = 0;

        // Número de monedas a lanzar
        for (let j=1; j<=coinsNum; j++) {

            // En caso de obtener "Cara"
            if (generateRandom() <= document.getElementById("pX").value) {
                rSideNum = rSideNum + 1;

                if (button != "continuous") {

                    if (tabSelected == "aCoin") {
                        document.getElementById("image1").src = "./images/euro-face.png";  

                    // tabSelected == "severalCoins"
                    }else { 
                        document.querySelector(divImg[j-1]).style.display = "flex";
                        document.getElementById(coinsImg[j-1]).src = "./images/euro-face.png";
                    }

                // button == "continuous"
                }else if (tabSelected == "severalCoins") {  
                        document.querySelector(divImg[j-1]).style.display = "flex";
                        document.getElementById(coinsImg[j-1]).src = "./images/euro.gif";  
                }
                
            // En caso de obtener "Cruz"    
            } else {

                document.querySelector(divImg[j-1]).style.display = "flex";   
                if (button != "continuous") {

                    if (tabSelected == "aCoin") {
                        document.getElementById("image1").src = "./images/euro-reverse.png";

                    // tabSelected == "severalCoins"  
                    }else {  
                        document.getElementById(coinsImg[j-1]).src = "./images/euro-reverse.png";
                    }

                // button == "continuous"
                }else if (tabSelected == "severalCoins") {     
                        document.getElementById(coinsImg[j-1]).src = "./images/euro.gif";
                }   
            }
        }

        // Conteo de lanzamientos
        simulations[(simulations.length)-1] = parseInt(simulations[(simulations.length)-1]) + 1;
        
        // Conteo de caras/cruces obtenidas
        simulations[rSideNum] = parseInt(simulations[rSideNum]) + 1;

        // Probabilidad simulada cuando la pestaña "Una moneda" está activa
        if (tabSelected == "aCoin") {
            simulated.push((parseFloat((simulations[1]/simulations[(simulations.length)-1])).toFixed(2)));
        }        
    }

        // Frecuencias teórica y simulada cuando la pestaña "Varias monedas" está activa
        if (tabSelected == "severalCoins") {        
            for (i=0; i<=coinsNum; i++) {
                simulated.push((parseFloat((simulations[i]/simulations[(simulations.length)-1]))*100).toFixed(2));
                theoretical.push(((calculateBinomial(coinsNum, i))*100).toFixed(2));
            }

        // Probabilidad teórica cuando la pestaña "Una moneda" está activa    
        }else {
            theoretical = new Array (simulated.length).fill((parseFloat(document.getElementById("pX").value)).toFixed(2));
        }
        
    return [simulated, theoretical];

}