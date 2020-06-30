<?php
?>
<html>
<head>

<meta charset="utf-8"/>
<style>
nav { display: none; width: 100%; background: gray; color: white; padding: 10px; }
nav>* { display: inline-block; padding: 0px 5px; }
nav>*+* { border-left: 1px solid white; }
th { text-align: left; padding: 3px 10px; }
td { padding: 3px 10px; }
.page { display: none; }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>

$(function() {
	showForm('#login');
});


function showForm(id) {
	$('.page').hide();
	$(id).show();
	if (id != '#login') {
		$('nav').show();
	} else {
		$('nav').hide();
	}

	if ($(id).attr("onshow")) {
		eval($(id).attr("onshow"));
	}
}

function submit(id, call, returnform) {
	var data = {};
	data.call = call;
	$(id).find('[name]').each(function(i, e) {
		var name = $(e).attr('name');
		data[name] = $(e).val();
	});

	$.post({ url: './ajax.php', data: data, success: function(data) {
		showForm(returnform);
	} });
}

function loadEmpresaList() {
	var data = {};
	data.call = "empresaList";
	$.post({ url: './ajax.php', data: data, success: function(data) {
		var body = $('#empresaList tbody').empty();

		data.list.forEach(function(row) {
			var tr = 
				$('<tr/>').append(
					$('<td/>').text(row["codigo"]),
					$('<td/>').text(row["nome"])
				);
			tr.click(function() {
				loadEmpresaDetail(row["id"]);
			});
			body.append(
					tr
			);
		});

	} });
}

function loadEmpresaDetail(id) {
	showForm('#empresaDetail');
	var data = {};
	data.call = "empresaDetail";
	data.id = id;
	$.post({ url: './ajax.php', data: data, success: function(data) {
		$('#empresaDetail [name]').val('');
		for (var i in data) {
			$('#empresaDetail [name="'+i+'"]').val(data[i]);
		}
	 }});
}

function loadUsuarioList() {
	var data = {};
	data.call = "usuarioList";
	$.post({ url: './ajax.php', data: data, success: function(data) {
		var body = $('#usuarioList tbody').empty();

		data.list.forEach(function(row) {
			var tr = 
				$('<tr/>').append(
					$('<td/>').text(row["codigo"]),
					$('<td/>').text(row["nome"])
				);
			tr.click(function() {
				loadUsuarioDetail(row["id"]);
			});
			body.append(
					tr
			);
		});

	} });
}

function loadUsuarioDetail(id) {
	showForm('#usuarioDetail');
	var data = {};
	data.call = "usuarioDetail";
	data.id = id;
	$.post({ url: './ajax.php', data: data, success: function(data) {
		$('#usuarioDetail [name]').val('');

		var select = $('#usuarioDetail [name="id_empresa"]').empty();
		select.append($('<option/>').text("seleciona"));
		data.empresa.list.forEach(function(empresa) {
			select.append($('<option/>').text(empresa.nome).attr('value', empresa.id));
		})
		for (var i in data) {
			$('#usuarioDetail [name="'+i+'"]').val(data[i]);
		}
	 }});
}

function loadPacienteList() {
	var data = {};
	data.call = "pacienteList";
	$.post({ url: './ajax.php', data: data, success: function(data) {
		var body = $('#pacienteList tbody').empty();

		data.list.forEach(function(row) {
			var tr = 
				$('<tr/>').append(
					$('<td/>').text(row["codigo"]),
					$('<td/>').text(row["nome"])
				);
			tr.click(function() {
				loadPacienteDetail(row["id"]);
			});
			body.append(
					tr
			);
		});

	} });
}

function loadPacienteDetail(id) {
	showForm('#pacienteDetail');
	var data = {};
	data.call = "pacienteDetail";
	data.id = id;
	$.post({ url: './ajax.php', data: data, success: function(data) {
		$('#pacienteDetail [name]').val('');
		var select = $('#pacienteDetail [name="id_empresa"]').empty();
		select.append($('<option/>').text("seleciona"));
		data.empresa.list.forEach(function(empresa) {
			select.append($('<option/>').text(empresa.nome).attr('value', empresa.id));
		})
		for (var i in data) {
			$('#pacienteDetail [name="'+i+'"]').val(data[i]);
		}
	 }});
}

</script>

</head>
<body>

<nav>
	<div onclick="showForm('#empresaList')">Empresas</div>
	<div onclick="showForm('#usuarioList')">Usuários</div>
	<div onclick="showForm('#pacienteList')">Pacientes</div>
</nav>

<div class="page" id="login">
	<table>
		<tr><td>Login</td><td><input type="text" name="login"/></td></tr>
		<tr><td>Password</td><td><input type="password" name="password"/></td></tr>
	</table>
	<input type="button" value="Submit" onclick="submit('#login', 'login', '#empresaList')"/>
</div>



<div class="page" id="pacienteDetail">
	<table>
		<tr><td>Código</td><td><input type="text" name="codigo"/></td></tr>
		<tr><td>Nome</td><td><input type="text" name="nome"/></td></tr>
		<tr><td>Área</td><td><input type="area" name="area"/></td></tr>
		<tr><td>Empresa</td><td><select name="id_empresa"><option>Seleciona</option></select></td></tr>
	</table>
	<input type="hidden" name="id"/>
	<input type="button" value="Submit" onclick="submit('#pacienteDetail', 'pacienteSave', '#pacienteList')"/>
</div>

<div class="page" id="pacienteList" onshow="loadPacienteList()">
	<table>
		<thead>
			<th>Código</th>
			<th>Nome</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<input type="button" value="Novo" onclick="loadPacienteDetail(-1)"/>
</div>



<div class="page" id="usuarioDetail">
	<table>
		<tr><td>Código</td><td><input type="text" name="codigo"/></td></tr>
		<tr><td>Nome</td><td><input type="text" name="nome"/></td></tr>
		<tr><td>Senha</td><td><input type="password" name="password"/></td></tr>
		<tr><td>Empresa</td><td><select name="id_empresa"><option>Seleciona</option></select></td></tr>
	</table>
	<input type="hidden" name="id"/>
	<input type="button" value="Submit" onclick="submit('#usuarioDetail', 'usuarioSave', '#usuarioList')"/>
</div>

<div class="page" id="usuarioList" onshow="loadUsuarioList()">
	<table>
		<thead>
			<th>Código</th>
			<th>Nome</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<input type="button" value="Novo" onclick="loadUsuarioDetail(-1)"/>
</div>



<div class="page" id="empresaDetail">
	<table>
		<tr><td>Código</td><td><input type="text" name="codigo"/></td></tr>
		<tr><td>Nome</td><td><input type="text" name="nome"/></td></tr>
	</table>
	<input type="hidden" name="id"/>
	<input type="button" value="Submit" onclick="submit('#empresaDetail', 'empresaSave', '#empresaList')"/>
</div>

<div class="page" id="empresaList" onshow="loadEmpresaList()">
	<table>
		<thead>
			<th>Código</th>
			<th>Nome</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<input type="button" value="Novo" onclick="loadEmpresaDetail(-1)"/>
</div>

</body>
</html>
