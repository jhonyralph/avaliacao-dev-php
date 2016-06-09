/**
 *  Document   : main.js
 *  Author     : Jonathan
 *  Description: Costumização padrão de scripts
 */

var webApp = function() {
	
	var fileStyle = function (){
		$(":file").filestyle();
	}
	
	var selectStyle = function (){
		$("select").selectpicker({});
	}
	
	var formValidator = function (){
		$("form.validator").validator();
	}
	
	return {
        init: function () {
        	selectStyle();
        	fileStyle();
        	formValidator();
        }
    };
	
}();

// Inicializa webApp quando a página carregar
$(document).ready(function(){
	webApp.init();
});