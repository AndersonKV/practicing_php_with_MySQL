<?php

include('config/db_connect.php');


$title = $email = $ingredients = '';
$errors = array('email' => '', 'title' => '', 'ingredients' => '');
// if(isset($_GET['submit'])) {
// 	echo $_GET['email'];
// 	echo $_GET['title'];
// 	echo $_GET['ingredients'];
// }


if(isset($_POST['submit'])) {

	//check email
	if(empty($_POST['email'])) {
		$errors['email'] = 'an email is required <br/>';
	} else {
		$email = $_POST['email'];

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'email deve ser um endereço de email válido';
		}
	}

	//check title
	if(empty($_POST['title'])) {
		$errors['title'] =  'o titulo é necessario <br/>';
	} else {
		$title = $_POST['title'];
		if(!preg_match('/^[a-zA-Z\s]+$/', $title)) {
			$errors['title'] = 'título deve ser apenas letras e espaços';
		}
	}

	//check ingredients
	if(empty($_POST['ingredients'])) {
		$errors['ingredients'] =  'pelo menos um ingrediente necessário <br/>';
	} else {
		$ingredients = $_POST['ingredients'];

		if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
			$errors['ingredients'] = 'ingrediente deve ser como uma lista separada';
		}
	}

	if(array_filter($errors)) {
		//echo 'errors in the form';
	} else {

		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

		//create sql
		$sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";
		
 		//save to db and check
		if(mysqli_query($conn, $sql)) {
			//sucess
			header('Location: index.php');
  		} else {
			//error
			echo 'query error: ' . mysqli_error($conn);
		}
 	}

} //end of POST CHECK


?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<section class="container grey-text">

		<h4 class="center">Add a Pizza</h4>

		<form class="white" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

			<div class="red-text"><?php echo $errors['email']; ?></div>
 			<label>Your Email:</label>
			<input type="text" name="email" value="<?php echo $email?>">

 			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php echo $title?>">

 			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<label>Ingredients (comma separated):</label>
			<input type="text" name="ingredients" value="<?php echo $ingredients?>">
 
			<div class="center">
				<input type="submit" name="submit" value="submit" 
					class="btn brand z-depth-0">
 			</div>
		</form>
					
	</section>

	<?php include('templates/footer.php'); ?>

</html>