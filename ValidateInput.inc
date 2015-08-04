<?php
// check if email is valid, if not create error
function validateEmail(&$errors, $field_list, $field_name)
	{
	if (!isset($field_list[$field_name]))
	$errors[$field_name] = 'Cannot be left blank!';		//if the field is not set, display a message saying 'Cannot be left blank!'
	
	//if the regex string matching pattern (in this case a valid email address) does not match, display an error
	$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
	if (!preg_match($pattern, $field_list[$field_name]))
	$errors[$field_name] = 'Must be a valid email address!<br/>';	
	}

// check if name is valid, if not create error
function validateName(&$errors, $field_list, $field_name)
	{
	if (!isset($field_list[$field_name]))
	$errors[$field_name] = 'Cannot be left blank!';
	
	//if the regex string matching pattern (any lower or upper case letter) does not match, display an error
	$pattern = '/^[a-zA-Z]+$/';
	if (!preg_match($pattern, $field_list[$field_name]))
	$errors[$field_name] = 'Must enter a name<br/>';	
	}

// check if username is valid, if not create error
function validateUsername(&$errors, $field_list, $field_name)
	{
	if (!isset($field_list[$field_name]))
	$errors[$field_name] = 'Cannot be left blank!';
	
	//if the regex string matching pattern (any character, as long as there are between 4 to 20 of them) does not match, display an error
	$pattern = '/^.{4,20}$/';
	if (!preg_match($pattern, $field_list[$field_name]))
	$errors[$field_name] = 'Must enter a username of at least 4 - 20 characters<br/>';	
	}

// check if password is valid, if not create error 
function validatePassword(&$errors, $field_list, $field_name)
	{
	if (!isset($field_list[$field_name]))
	$errors[$field_name] = 'Cannot be left blank!';
	
	//if the regex string matching pattern (in this case any number or letter, as long as there are at least 6) does not match, display an error
	$pattern = '/^[a-zA-Z0-9]{6,}$/';
	if (!preg_match($pattern, $field_list[$field_name]))
	$errors[$field_name] = 'Password must be at least 6 characters long with no spaces or symbols<br/>';
	}

// check if passwords match, if not create error
function confirmPassword(&$errors, $field_list, $field_name_a, $field_name_b)
	{
	if($field_list[$field_name_a] != $field_list[$field_name_b]) 
	$errors[$field_name_a] = 'Passwords do not match!<br/>';
	}

// check if address is valid, if not create error
function validateAddress(&$errors, $field_list, $field_name)
	{
	if (!isset($field_list[$field_name]))
	$errors[$field_name] = 'Cannot be left blank!';
	
	//if the regex string matching pattern (in this case any characters that may be found in an address - letters, numbers, slash) does not match, display an error
	$pattern = '/^[a-zA-Z0-9\/ ]*[a-zA-Z0-9\/ ]+$/';
	if (!preg_match($pattern, $field_list[$field_name]))
	$errors[$field_name] = 'Must enter an address<br/>';
	}

// check if selected option is valid, if not create error
function validateSelect(&$errors, $field_list, $field_name)
	{
	//if the value of the selected option is 0, display an error
	$val = $field_list[$field_name];
	if (isset($val))
		if ($val == null)
			$errors[$field_name] = '<i>Please select one</i>';
	}
?>