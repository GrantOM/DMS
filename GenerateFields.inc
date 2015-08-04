<?php
//function that adds a label
function label($name, $label) {
	echo "<label>$label " .
			"<span class=\"small\"></span> ".
			"</label>";
}
//function that adds a styled label
function label_styled($name, $label, $small) {
	echo "<label>$label " .
		"<span class=\"small\">$small</span> ".
		"</label>";
}

//function that takes an element from an array and assigns that element to the name of a select box
function posted_value($name) {
	if(isset($_POST[$name]))
		return htmlspecialchars($_POST[$name]);
	else
		return '';
}

//adds an error label to an input field
function error_label($errors, $name) {
	if (isset($errors[$name]))
		echo "<span id=\"", $name, "_Error\" class=\"error\">", $errors[$name], "</span>";
	else
		echo "<span id=\"", $name, "_Error\" class=\"error\"> </span>";

}

//creates non-error labelled checked text box
function input_text($name, $label, $small) {
	echo '<div class="required_field">';
	label_styled($name, $label, $small);
	$value = posted_value($name);
	echo "<input type=\"text\" id=\"$name\" name=\"$name\" value=\"$value\"/>";
	echo '</div>';
}
//creates a text box with an error label
function input_text_checked($errors, $name, $label, $small) {
	echo '<div class="required_field">';
	label_styled($name, $label, $small);
	$value = posted_value($name);
	echo "<input type=\"text\" id=\"$name\" name=\"$name\" value=\"$value\" required=\"required\"/>";
	error_label($errors, $name);
	echo '</div>';
}

//creates hidden input
function input_hidden($name, $label, $value, $small) {
	echo '<div class="required_field">';
	label_styled($name, $label, $small);
	echo "<input type=\"hidden\" id=\"$name\" name=\"$name\" value=\"$value\"/>";
	echo '</div>';
}
	
function input_hidden_checked($errors, $name, $label, $value, $small) {
	echo '<div class="required_field">';
	label_styled($name, $label, $small);
	echo "<input type=\"hidden\" id=\"$name\" name=\"$name\" value=\"$value\"/>";
	error_label($errors, $name);
	echo '</div>';
}

//creates password input box
function input_password($name, $label, $small) {
	echo '<div class="required_field">';
	label_styled($name, $label, $small);
	$value = posted_value($name);
	echo "<input type=\"password\" id=\"$name\" name=\"$name\" value=\"$value\" required=\"required\"/>";
	echo '</div>';
}	

function input_password_checked($errors, $name, $label, $small) {
	echo '<div class="required_field">';
	label_styled($name, $label, $small);
	$value = posted_value($name);
	echo "<input type=\"password\" id=\"$name\" name=\"$name\" value=\"$value\" required=\"required\"/>";
	error_label($errors, $name);
	echo '</div>';
}

//creates textarea box
function input_textarea($name, $label) {
	echo '<div class="required_field">';
	label($name, $label);
	echo ':<br/>';
	$value = posted_value($name);
	echo "<textarea name=\"$name\" id=\"$name\" value=\"$value\" rows=\"3\" cols=\"40\">$value</textarea>";
	echo '</div>';
}
	
function input_textarea_checked($errors, $name, $label) {
	echo '<div class="required_field">';
	label($name, $label);
	echo ':<br/>';
	$value = posted_value($name);
	error_label($errors, $name);
	echo "<textarea name=\"$name\" id=\"$name\" value=\"$value\" rows=\"3\" cols=\"40\">$value</textarea>";
	echo '</div>';
}

//creates select menu
function select($name, $values, $label) {
	echo '<div class="required_field_select">';
	label($name, $label);
	echo "<select id=\"$name\" name=\"$name\" required=\"required\">";
	foreach ($values as $value => $display)
		{
		$selected = ($value==posted_value($name))?'selected="selected"':'';
		echo "<option $selected value=\"$value\">$display</option>";
		}
	echo '</select>';
}
?>