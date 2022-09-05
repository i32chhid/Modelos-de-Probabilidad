/*
     UNIVERSIDAD DE CÓRDOBA
     Escuela Politécnica Superior de Córdoba
     Departamento de Estadística, Econometría, Investigación Operativa, Organización de Empresas y
     Economía Aplicada

     Simulación de Modelos de Probabilidad con Javanzamiento de dados y monedas
     Autor: David Checa Hidalgo
     Director: Roberto Espejo Mohedano
     Curso 2021 - 2022
*/

/* CÓDIGO JAVASCRIPT COMÚN PARA LAS PESTAÑAS "Un dado" Y "Varios dados" */

/**
 * @name calcDiceSideNum
 * @description Cuenta el número de veces que sale cada una de las caras del dado (1-6)
 * @param {string} diceType - Tipo de dado seleccionado (Perfecto / Trucado)
 * @param {number} randomNum - Número aleatorio entre 0 y 1
 * @return {number} - Cara del dado obtenida
 */

function calcDiceSideNum(diceType, randomNum) {

    // Id´s de las entradas "P(x = y)"
    let pXyId = [];
    document.querySelectorAll(".diceProb input").forEach((el) => {
        pXyId.push(el.id);                                                                       
    });

    // Valores de todas las P(x = y)
    let pXy = [];
    if (diceType === "Perfecto" || diceType === "Perfect" || diceType === "Parfait") {
        pXy[0] = parseFloat(1/6).toFixed(2);
    } else {
        pXy[0] = parseFloat(document.getElementById(pXyId[0]).value).toFixed(2);
    }

    // Cálculo de las fronteras que representan cada valor del dado
    for (let i=1; i<6; i++){
        let current = parseFloat(document.getElementById(pXyId[i]).value);
        if (diceType === "Perfecto" || diceType === "Perfect" || diceType === "Parfait") {
            pXy[i] = parseFloat(parseFloat(1/6) * (i+1)).toFixed(2);
        } else {
            pXy[i] = parseFloat(parseFloat(current) + parseFloat(pXy[i-1])).toFixed(2);
        }
    }

    // Número de veces que sale cada puntuación del dado

    // Cara 1
    if (randomNum <= pXy[0]) {
        return 1;

    // Cara 2
    }else if (randomNum > pXy[0] && randomNum <= pXy[1]) {
        return 2;

    // Cara 3
    }else if (randomNum > pXy[1] && randomNum <= pXy[2]) {
        return 3;

    // Cara 4
    }else if (randomNum > pXy[2] && randomNum <= pXy[3]) {
        return 4;

    // Cara 5
    }else if (randomNum > pXy[3] && randomNum <= pXy[4]) {
        return 5;

    // Cara 6
    }else if (randomNum > pXy[4] && randomNum <= pXy[5]) {
        return 6;
    }

}