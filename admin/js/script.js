
				////////////////////////////////////
				// JAVA-SCRIPT ADMIN (31.03.17)/////
				////////////////////////////////////

$(document).ready(function(){

	// Fait apparaître les 'pop-up box' d'information
	$('[data-toggle="tooltip"]').tooltip(); 


	// Fonction qui permet de verifier et de récupérer le contenu $_GET de l'url
	$.urlParam = function(name){
	    var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);

	    if (results==null){
	       return null;
	    }
	    else{
	       return results[1] || 0;
	    }
	}


	// On stocke l'id de l'expo en cours 
	//(liste_oeuvre.php)
	var id_expo = $.urlParam('id_expo');


	// On stocke l'id de l'expo en cours de "map" 
	//(gallery.php)
	var id_expo_map = $.urlParam('id_map');



				/*****************************
					Gestion des alertes expo
				*****************************/


	// Requete Ajax alerter des expo non prête

	$.ajax({
		type: 'POST',
			
		url: 'ajax_alert.php',
			
		datatype: 'html',

		success: function(datatype) {
			console.log(datatype);
			if(datatype.message == false) {
				return false;
			}
			else {
				if(datatype != '') {
					
					$("#alert_nav").on("mouseover", function () {
    					$('#alert_retour').html(datatype).addClass("color_header");
					});

					$("#alert_nav").on("mouseout", function () {
    					$('#alert_retour').html('').removeClass("color_header");
					});
				}
			}
		},

		error: function() {
			alert('erreur');
		},

	});



				/***************************
					Drag And Drop sur map
				****************************/


	// Fonction pour positionner les oeuvres sur la "map" lors de l'aperçu de l'expo 
	//(apercu_exposition.php)
	$('.fixed_map').each( function() {
		var id = $('.fixed_map').attr('value');
		$('.droppable[value="'+id+'"]').children().hide();
		$('.fixed_map[value="'+id+'"]').appendTo('.droppable[value="'+id+'"]');
	});


	// Requete pour aller chercher les oeuvres qui ont deja une map_position
	// (gallery.php)
	$.ajax({
		type: 'POST',
			
		url: 'ajax_map.php',
			
		data: {id_expo_map : id_expo_map},

		success: function(data) {
			if(data.message == false) {
				return false;
			}
			else {
				if(data != '') {
					var list = data;
					var res = list.split("-");

					for(var i = 0; i< res.length; i ++) {
						var index = res[i];
						var id_map =  index.split(",");
						var oeuvre_id = id_map[0];
						var map_id = id_map[1];
						$('.droppable[value="'+map_id+'"]').children().hide();
						var out_dom = $('.draggable[value="'+oeuvre_id+'"]').appendTo('.droppable[value="'+map_id+'"]');
					}
				}
			}
		},

		error: function() {
			alert('erreur');
		},
	});


	// Gestion du Draggable
	// (gallery.php)
	$('.draggable').draggable({ 
		snap: ".ui-widget-header",
	});


	// Gestion du Droppable
	// (gallery.php)
	$('.droppable').droppable({

		drop: function(event, ui) {
	  		var map_id = $(this).attr('value');
	  		var oeuvre_id = $(ui.draggable).attr('value');
	  		
	  		$.ajax({
				type: 'POST',
			
				url: 'ajax_map.php',
			
				data: {map_id : map_id, oeuvre_id : oeuvre_id, id_expo_map : id_expo_map},

				success: function(data) {
					if(data.message == false) {
						return false;
					}
					// If datatype it's true
					else {
						return true;
					}
				},

				error: function() {
					alert('Une erreur est survenue');
				},
			});
	  	},

		out: function(event,ui) {	
			console.log('sortie');
			// $(this).appendTo('.map');
			// var out_dom = $('.draggable[value="'+id+'"]').appendTo('.map');
		}
	});



				/********************************
					Satut des exposition (toogle)
				*********************************/


	// Requête Ajax pour aller chercher les expositions validées (toogle)
	//(exposition.php)
	$.ajax({
		type: 'POST',
			
		url: 'ajax_search_oeuvre_expo.php',
			
		datatype: 'html',

		success: function(datatype) {
			if(datatype.message == false) {
				return false;
			}
			else {
				if(datatype != '') {
					var list = datatype;
					var res = list.split(" ");

					for(var i = 0; i< res.length; i ++) {
						
						$("input[name='check']").each(function() {
							var input = $(this);

							if(input.attr('value') == res[i]) {
								input.prop( "checked", true );
							} 
						});
					}
				}
			}
		},

		error: function() {
			alert('erreur');
		},

	});

	// Fonction pour changer le statut d'une exposition(ready or not) (toogle)
	//(exposition.php)
	$("input[name='check']").change(function() {

	    if($(this).is(':checked')) {
	    	   var id_check = $(this).attr('value');
	    	   var statut = 1;
	    }

	    else if($(this).prop('checked', false)){
	    	var id_check = $(this).attr('value');
	    	var statut = 0;
	    }

	   $.ajax({

			type: 'POST',
			
			url: 'ajax_search_oeuvre_expo.php',
			
			data: {id_check : id_check, statut : statut},

			success: function(data) {
				if(data.message == false) {
					return false;
				}

				// If datatype it's true
				else {
					return true;
				}
			},

			error: function() {
				alert('Une erreur est survenue');
			},
		});

	});



				/***************************************
					Gestion des oeuvres dans une expo
				***************************************/


	// Requête Ajax pour aller chercher la liste des oeuvres associées à une exposition (left side-bar)
	//(liste_oeuvre.php)
	$.ajax({

		type: 'POST',
		
		url: 'ajax_search_oeuvre_expo.php',
		
		data: {id_expo : id_expo}, 

		success: function(data) {
			
			$('#title_expo').html(data);

			if(data.message == false) {
				return false;
			}

			// If datatype it's true
			else {
				return true;
			}
		},

		error: function() {
			$('#error_succes').html('Une erreur est survenue').addClass("alert alert-warning");
		},
	});


	// Fonction pour delete les oeuvres liées à une exposition
	//(liste_oeuvre.php)
	$("#oeuvre_expo").on("click","#delete", function() {
		
		// On récupère l'id de l'oeuvre que l'on souhaite retirer de la liste
		var id_delete = $(this).attr('value');

		$.ajax({

			type: 'POST',
			
			url: 'ajax_search_oeuvre_expo.php',
			
			data: {id_delete : id_delete, id_expo : id_expo},

			success: function(data) {
			
				$('#error_succes').html('Oeuvre supprimée').addClass("alert alert-info");;

				if(data.message == false) {
					return false;
				}

				// If datatype it's true
				else {
					//Requête Ajax pour actualiser la liste des oeuvres
					//'ajax_search_oeuvre_expo.php'
					$.ajax({

						type: 'POST',
						
						url: 'ajax_search_oeuvre_expo.php',
						
						data: {id_expo : id_expo},

						success: function(data) {
							
							$('#title_expo').html(data);

							if(data.message == false) {
								return false;
							}

							// If datatype it's true
							else {
								return true;
							}
						},

						error: function() {
							$('#error_succes').html('Une erreur est survenue').addClass("alert alert-warning");
						},
					});
				}
			},

			// Si la requête Ajax écoue
			error: function() {
				$('#error_succes').html('Une erreur est survenue').addClass("alert alert-warning");
			},
		});
	});


	// Fonction pour ajouter des oeuvres à une exposition
	//(liste_oeuvre.php)
	$('#liste_oeuvre').ready( function() {

		// Requête Ajax pour lister toutes les oeuvres
		$.ajax
		({

			type: 'POST',
			
			url: 'ajax_search_oeuvre.php',
			
			datatype: 'html',

			success: function(datatype) {
				
				$('#liste_oeuvre').html(datatype);

				if(datatype.message == false) {
					return false;
				}

				// If datatype it's true
				else {
					var tab = [];

					// On crée l'évènement click d'une oeuvre
					$("#liste_oeuvre .thumbnail").on("click", function() {

						// On vide le champ de réponse
						$('#error_succes').html('');

						// Avec le toogleClass on active ou desactive une classe 
						$(this).toggleClass('color_toogle');

						// Si la classe est activé alors on va chercher l'id de l'oeuvre pour la stocker dans 'tab'
						if($(this).hasClass('color_toogle')) {
							var oeuvre_id = $(this).attr('value');
							tab.push(oeuvre_id);
							return tab; 
						}

						// Si la classe n'est pas active on sort l'id de l'oeuvre de 'tab'
						else if(!$(this).hasClass('color_toogle')) {
							var index = tab.indexOf($(this).attr('value'));
							delete tab[index];
							return tab;
						}
					});

					//Fonction enregistrer
					$('#valider_liste').on("click", function() {

						if(tab != '' && id_expo != '') {

							$.ajax({

								type: 'POST',

								url: 'ajax_search_oeuvre.php',

								data: {tab : tab, id_expo : id_expo},

								success: function(data) {

									$("#error_succes").html('Oeuvre(s) enregistrée(s)').addClass("alert alert-info");
									tab = [];
									$("#liste_oeuvre .thumbnail").removeClass('color_toogle');

									if(data.message == false) {
										return false;
									}

									// If data it's true
									else {
										// Requête Ajax pour actualiser la liste
										$.ajax({

											type: 'POST',
											
											url: 'ajax_search_oeuvre_expo.php',
											
											data: {id_expo : id_expo},

											success: function(data) {
												
												$('#title_expo').html(data);

												if(data.message == false) {
													return false;
												}

												// If datatype it's true
												else {
													return true;
												}
											},

											error: function() {
												$('#error_succes').html('Une erreur est survenue').addClass("alert alert-warning");
											},
										});
									}
								},

								error: function() {
									$('#error_succes').html('Une erreur est survenue').addClass("alert alert-warning");
								}
							});
						}
					});
				}
			},

			error: function() {
				$('#error_succes').html('Une erreur est survenue').addClass("alert alert-warning");
			}

		});
	
	});



				/***********************************
					"Moteur" de recherche artiste
				***********************************/


	//µFonction pour gérer le formulaire de recherche des artistes
	//(artist.php)
	$('#q').keyup( function() {
		
	    var field = $(this);
	    $('#results').html('');
	  
	 	if(field.val().length == 0) {
	 		$('#ask_ajax').show();
	 	}
	    
	    else if(field.val().length > 0){
	    	$('#ask_ajax').hide();
	    			
			$('#q').keypress(function(e) {
			    if(e.which == 13) {
			    	return false;	
			    }
			});
	      
	      	// Requête Ajax pour lister les artistes 'ajax_search_artist.php'
	    	$.ajax
	    	({
	  			type : 'POST', 
				url : 'ajax_search_artist.php' , 
				data : 'q='+$(this).val() , 
		
				success : function(data) { 
					$('#results').html(data);
				},

				error : function() {
					alert('Désolé, une erreur est survenue');	
				},

				complete: function() {
					console.log('Requête Ajax exécuté avec succès');
				}
	    	});
	    }
	    else {
	    	alert("Erreur Ajax : Aucune donnée reçue");
	    }
	});
		


				/****************
					Scroll Top
				****************/


	//µFonction pour lancer le scroll au top
	$("a[href='#top']").click(function() {
		  $("html, body").animate({ scrollTop: 0 }, "slow");
	});

});


