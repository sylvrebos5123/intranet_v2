
//Modal box pour affichage agenda de l'utilisateur + agenda officiel
$("body").on("hidden.bs.modal", ".modal", function () {
          $(this).removeData("bs.modal");
  });
  $("#mon_agenda").click(function() { 
    //$('.modal ').modal ('show');
	//var name_img = $(this).attr('id');
	//var title_img=$(this).attr('alt');
	
	$("h4.modal-title").html('Mon agenda');
	$("div.modal-body").load("test.php");
	//$("div.modal-body").load("http://intranet.cpasixelles.be/coquille_intranet/index4.php");
	//$("div.modal-body").modal ({ remote : "http://intranet.cpasixelles.be/coquille_intranet/index4.php" } ," show ");
	//$("div.modal-body").html('coucou').fadeIn(1500);
	//$("div.modal-body").html( '<img src="./img_projects/'+name_img+'"/>').fadeIn(1500);
  });
  
  $("#agenda_officiel").click(function() { 
    
	
	$("h4.modal-title").html('Agenda officiel');
	$("div.modal-body").html('coucou');

  });
  

// Menu du haut, affichage étiquette lors du passage de la souris + slide ouvrant/fermant
$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 
	$('.my-tooltip').dropdown();
	$('.my-tooltip').tooltip();
});

// menu sidebar effet accordéon
$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();
		$next.slideToggle();
		$(".side-nav>li").removeClass('active');
		$this.parent().toggleClass('active');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('active');
			//alert($el.parent());
			//$(".side-nav>li:not("+$next+")").removeClass('active');
		};
	}	

	var accordion = new Accordion($('#accordion'), false);
});