let btnSet = document.querySelector('#btn_rate');
let Input1 = document.querySelector('#review-rate-1');
let Input2 = document.querySelector('#review-rate-2');
let Input3 = document.querySelector('#review-rate-3');
let Input4 = document.querySelector('#review-rate-4');
let Input5 = document.querySelector('#review-rate-5');
let result = document.querySelector('#result');

btnSet.addEventListener('click',()=>{
    if (Input1.checked){
        result.value = 1;
    }
    if (Input2.checked){
        result.value = 2;
    }
    if (Input3.checked){
        result.value = 3;
    }
    if (Input4.checked){
        result.value = 4;
    }
    if (Input5.checked){
        result.value = 5;
    }

});



