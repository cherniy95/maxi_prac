$(document).ready(function(){
	$("#cat-button").click(function(){
		$.ajax({
			type: 'POST',
			url: 'menu.php',
			async: true,
			success: function(data){
				$("#cat-menu-wrap").html(data);
			}
		});
		$("#cat-menu-wrap").toggle();
		
	});
});

function submitContactForm()
{
	if ( !($("#tel").val() == '' && $("#email").val() == '') ) {
		if ( /.+@.+\..+/.test( $("#email").val() ) ) {
			if ( /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/.test( $("#tel").val() ) ) {
				$("#popup-form").submit()
			} else {
				alert('Неправильный номер телефона');
			}
		} else {
			alert('Неправильный адрес электронной почты');
		}
	} else {
		alert('Пожалуйста, оставьте свои телефон и почту');
	}
}