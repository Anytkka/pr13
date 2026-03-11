<?php
	session_start();
	include("./settings/connect_datebase.php");
	
	if (isset($_SESSION['user'])) {
		if($_SESSION['user'] != -1) {
			
			$user_query = $mysqli->query("SELECT * FROM `users` WHERE `id` = ".$_SESSION['user']);
			while($user_read = $user_query->fetch_row()) {
				if($user_read[4] == 0) header("Location: user.php");
				else if($user_read[4] == 1) header("Location: admin.php");
			}
		}
 	}
?>
<html>
	<head> 
		<meta charset="utf-8">
		<title> Регистрация </title>
		
		<script src="https://code.jquery.com/jquery-1.8.3.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="top-menu">
			<a href=#><img src = "img/logo1.png"/></a>
			<div class="name">
				<a href="index.php">
					<div class="subname">БЗОПАСНОСТЬ  ВЕБ-ПРИЛОЖЕНИЙ</div>
					Пермский авиационный техникум им. А. Д. Швецова
				</a>
			</div>
		</div>
		<div class="space"> </div>
		<div class="main">
			<div class="content">
				<div class = "login">
					<div class="name">Регистрация</div>
				
					<div class = "sub-name">Логин:</div>
					<input name="_login" type="text" placeholder="" onkeypress="return PressToEnter(event)"/>
					<div class = "sub-name">Пароль:</div>
					<input name="_password" type="password" placeholder="" onkeypress="return PressToEnter(event)"/>
					<div class = "sub-name">Повторите пароль:</div>
					<input name="_passwordCopy" type="password" placeholder="" onkeypress="return PressToEnter(event)"/>
					<div class = "sub-name">Фотография:</div>
					<input name="photo" type="file" accept=".png, .jpg, .jpeg, image/png, image/jpeg" onchange="previewImage(this)"/>

					<!--  предпросмотр -->
					<img id="preview" src="#" alt="Предпросмотр" style="width: 150px; height: 150px; object-fit: cover; margin-top: 10px; border: 1px solid #ccc; display: none;">
					<div id="formatMessage" style="margin-top: 5px; font-size: 14px;"></div>
					
					<a href="login.php">Вернуться</a>
					<input type="button" class="button" value="Зайти" onclick="RegIn()" style="margin-top: 0px;"/>
					<img src = "img/loading.gif" class="loading" style="margin-top: 0px;"/>
				</div>
				
				<div class="footer">
					© КГАПОУ "Авиатехникум", 2020
					<a href=#>Конфиденциальность</a>
					<a href=#>Условия</a>
				</div>
			</div>
		</div>
		
		<script>
			var loading = document.getElementsByClassName("loading")[0];
			var button = document.getElementsByClassName("button")[0];
					//  функция предпросмотра изображения
					function previewImage(input) {
		var preview = document.getElementById('preview');
		
		if (input.files && input.files[0]) {
			var file = input.files[0];
			var fileName = file.name;
			
			// Проверка формата
			if(fileName.match(/\.(png|jpg|jpeg|gif)$/i)) {
				// Формат правильный
				document.getElementById('formatMessage').innerHTML = 'Норм Формат: ' + fileName.split('.').pop();
				document.getElementById('formatMessage').style.color = 'green';
				
				// Предпросмотр
				var reader = new FileReader();
				reader.onload = function(e) {
					preview.src = e.target.result;
					preview.style.display = 'block';
				}
				reader.readAsDataURL(file);
			} else {
				// Формат неправильный
				document.getElementById('formatMessage').innerHTML = 'БЕЕ Ошибка! Только png, jpg, jpeg, gif';
				document.getElementById('formatMessage').style.color = 'red';
				preview.style.display = 'none';
				input.value = '';
			}
		}
	}
	
				
			function RegIn() {
				var _login = document.getElementsByName("_login")[0].value;
				var _password = document.getElementsByName("_password")[0].value;
				var _passwordCopy = document.getElementsByName("_passwordCopy")[0].value;
				var photoInput = document.querySelector('input[name="photo"]');
				
				var photoFile = photoInput.files[0];
				if(photoFile == undefined) {
					alert("Выберите файл.");
					return;
				}
				
				if(_login != "") {
					if(_password != "") {
						if(_password == _passwordCopy) {
							loading.style.display = "block";
							button.className = "button_diactive";

							var data = new FormData();
							data.append("login", _login);
							data.append("password", _password);
							data.append("photo", photoFile);
							
							// AJAX запрос
							$.ajax({
								url         : 'ajax/regin_user.php',
								type        : 'POST', // важно!
								data        : data,
								cache       : false,
								dataType    : 'html',
								// отключаем обработку передаваемых данных, пусть передаются как есть
								processData : false,
								// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
								contentType : false, 
								// функция успешного ответа сервера
								success: function (_data) {
									console.log("Авторизация прошла успешно, id: " +_data);
									if(_data == -1) {
										alert("Пользователь с таким логином существует.");
										loading.style.display = "none";
										button.className = "button";
									} else {
										location.reload();
										loading.style.display = "none";
										button.className = "button";
									}
								},
								// функция ошибки
								error: function( ){
									console.log('Системная ошибка!');
									loading.style.display = "none";
									button.className = "button";
								}
							});
						} else alert("Пароли не совподают.");
					} else alert("Введите пароль.");
				} else alert("Введите логин.");
			}
	
			
			function PressToEnter(e) {
				if (e.keyCode == 13) {
					var _login = document.getElementsByName("_login")[0].value;
					var _password = document.getElementsByName("_password")[0].value;
					var _passwordCopy = document.getElementsByName("_passwordCopy")[0].value;
					
					if(_password != "") {
						if(_login != "") {
							if(_passwordCopy != "") {
								RegIn();
							}
						}
					}
				}
			}
			
		</script>
	</body>
</html>