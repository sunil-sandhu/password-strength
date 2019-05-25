<?php
  

function random_char($string) {
  $i = mt_rand(0, strlen($string)-1);
  return $string[$i];
}

function random_string($length, $char_set) {
  $output = '';
  for($i=0; $i < $length; $i++) {
    $output .= random_char($char_set); 
  }
  return $output;
}

function generate_password($length) {
  // define character sets
  $lower = 'abcdefghijklmnopqrstuvwxyz';
  $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $numbers = '0123456789';
  $symbols = '$*?!-';
  
  // extract configuration flags into variables
  $use_lower = isset($_GET['lower']) ? $_GET['lower'] : '0';
  $use_upper = isset($_GET['upper']) ? $_GET['upper'] : '0';;
  $use_numbers = isset($_GET['numbers']) ? $_GET['numbers'] : '0';;
  $use_symbols = isset($_GET['symbols']) ? $_GET['symbols'] : '0';;

  $chars = '';
  if($use_lower == '1') { $chars .= $lower; }
  if($use_upper == '1') { $chars .= $upper; }
  if($use_numbers == '1') { $chars .= $numbers; }
  if($use_symbols == '1') { $chars .= $symbols; }
  
  return random_string($length, $chars);
}

$password = generate_password($_GET['length']);

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Password Generator</title>
  </head>
  <body>

    <p>Generated Password: <?php echo $password; ?></p>
    
    <p>Generate a new password using the form options.</p>
    <form action="" method="get">
      Length: <input type="text" name="length" value="<?php if(isset($_GET['length'])) { echo $_GET['length']; } ?>" /><br />
      <input type="checkbox" name="lower" value="1" <?php if($_GET['lower'] == 1) { echo 'checked'; } ?> /> Lowercase<br />
      <input type="checkbox" name="upper" value="1" <?php if($_GET['upper'] == 1) { echo 'checked'; } ?> /> Uppercase<br />
      <input type="checkbox" name="numbers" value="1" <?php if($_GET['numbers'] == 1) { echo 'checked'; } ?> /> Numbers<br />
      <input type="checkbox" name="symbols" value="1" <?php if($_GET['symbols'] == 1) { echo 'checked'; } ?> /> Symbols<br />
      <input type="submit" value="Submit" />
    </form>

  </body>
</html>
