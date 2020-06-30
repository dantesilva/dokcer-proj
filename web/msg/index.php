<?php
?>
<!doctype html>
<html>
<head>

<meta charset="utf-8"/>
<style>
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>

function submit(id, call, returnform) {
	var data = {};
	data.call = call;
	$(id).find('[name]').each(function(i, e) {
		var name = $(e).attr('name');
		data[name] = $(e).val();
	});

	$.post({ url: './ajax.php', data: data, success: function(data) {
		alert("Enviado com sucesso");
	} });
	return false;
}


</script>

</head>
<body>


<div class="page" id="formularioDetail">
	<p>
		Email<br/>
		<input type ="text" name="email" placeholder="Digita seu e-mail"/>
	</p>
	<p>
		Nome<br/>
		<input type ="text" name="nome" placeholder="Digita seu nome"/>
	</p>
	<p>
		Mensagem<br/>
		<textarea name="mensagem" placeholder="Mensagem"></textarea>
	</p>
	<p>
		<input type="button" value="Submit" onclick="return submit('#formularioDetail', 'formularioSave')"/>
	</p>
</div>


</body>
</html>
