var btn = document.getElementById('btn'),
 caja = document.getElementById('caja'),
 contador = 0;
 
 function cambio(){
     if (contador == 0){
         fakeimg.classList.add('sd');
         contador = 1;
     }
     else{
         fakeimg.classList.remove('caja');
         contador = 0;
     }
 }
 
  btn.addEventListener('click',cambio,true);