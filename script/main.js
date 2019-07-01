function updateProduit(id){
	var qte = $('#qte' + id).val();

	$.ajax({
        type: "POST",
        url: './function/updateProduit.php',
        data:{id:id},
        success:function(html){   
        	window.location.assign(document.URL);
        },
        
   });
}

function addToPanier(id){
	var qte = $('#qte' + id).val();
	$.ajax({
        type: "POST",
        url: './function/addToPanier.php',
        data:{id_poisson:id, quantite:qte},
        success:function(html){   
        	window.location.assign(document.URL);
        },
       
   });
}

function removeFromPanier(id){
	var qte = $('#qte' + id).val();
	console.log(qte);
	$.ajax({
        type: "POST",
        url: './function/removeFromPanier.php',
        data:{id_poisson:id, quantite:qte},
        success:function(html){   
        	window.location.assign(document.URL);
        	console.log(qte);

        },
        
   });
}

function changeQuantity(id){
	var qte = $('#qte' + id).val();
	$.ajax({
        type: "POST",
        url: './function/changeQuantity.php',
        data:{id_poisson:id, quantite:qte},
        success:function(html){   
        	window.location.assign(document.URL);        	
        },
       
   });
}

function supprimerPoisson(id){
	$.ajax({
        type: "POST",
        data:{id_poisson:id},
        url: './function/supprimerPoisson.php',      
        success:function(html){  
        	window.location.assign('./index.php');     	
        	console.log(html);
        }      
   });
}
$(document).ready(function() {
    // Transition effect for navbar 
    $(window).scroll(function() {
      // checks if window is scrolled more than 50px, adds/removes solid class
      if($(this).scrollTop() > 50) { 
          $('.navbar').addClass('solid');
      } else {
          $('.navbar').removeClass('solid');
      }
      
    });
});