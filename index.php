<?php


// ~~~~~~~~~~~~~~~~Picking random words from a dictionary ~~~~~~~~~~~~~~~~ //

function read_dictionary($filename="")
{
    $dictionary_file = "{$filename}";
    return file($dictionary_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
// the file function takes the file and turns it into an array. With the use of the flags, I could now echo $lines[0] and that would give us the first word in the file
}


function pick_random($array) {
    $i = mt_rand(0, count($array) - 1);
    return $array[$i];
}

function pick_random_symbol() {
    $symbols = '$*?!-';
    $i = mt_rand(0, strlen($symbols) - 1);
    return $symbols[$i];
}

function pick_random_number($digits=1) {
    $min = pow(10, ($digits -1));
    $max = pow(10, $digits) - 1;
    return strval(mt_rand($min, $max));
}

function pick_random_word($words, $length) {
    $select_words = filter_words_by_length($words, $length);
    return pick_random($select_words);
}

function filter_words_by_length($array, $length) {
    $select_words = array();
    foreach($array as $word) {
        if(strlen($word) == $length) {
            $select_words[] = $word;
        }
    }
    return $select_words;
}

$basic_words = read_dictionary('friendly_words.txt');
// echo $basic_words[0];

$length = 10;
$word_count = 2;
$digit_count = 1;
$symbol_count = 1;
$avg_word_length = ($length - $digit_count - $symbol_count) / $word_count;

$password = "";
$next_word_length = mt_rand($avg_word_length - 1, $avg_word_length + 1);

$password .= pick_random_word($basic_words, $next_word_length);


$password .= pick_random_symbol(); //appends a symbol to the end of the password
$password .= pick_random_number($digit_count);



echo $password;
//echo "<br>";
//echo strlen($password);



function random_char($string) {
    $i = random_int(0, strlen($string)-1);
    return $string[$i];
}

function random_string($length, $char_set) {
    $output = '';
    for($i=0; $i < $length; $i++) {
        $output .= random_char($char_set);
    }
    return $output;
}

function generate_password($options) {
    // define character sets
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $symbols = '$*?!-';

    // extract configuration flags into variables
    $use_lower = isset($options['lower']) ? $options['lower'] : '0';
    $use_upper = isset($options['upper']) ? $options['upper'] : '0';
    $use_numbers = isset($options['numbers']) ? $options['numbers'] : '0';
    $use_symbols = isset($options['symbols']) ? $options['symbols'] : '0';

    $chars = '';
    if($use_lower == '1') { $chars .= $lower; }
    if($use_upper == '1') { $chars .= $upper; }
    if($use_numbers == '1') { $chars .= $numbers; }
    if($use_symbols == '1') { $chars .= $symbols; }

    $length = isset($options['length']) ? $_GET['length'] : 8; //the end of this ternary operator should make the characer length default to 8, but doesn't seem to be working


    return random_string($length, $chars);
}

$options = array(
    'length' => isset($_GET['length']),
    'lower' =>  isset($_GET['lower']),
    'upper' =>  isset($_GET['upper']),
    'numbers' =>  isset($_GET['numbers']),
    'symbols' =>  isset($_GET['symbols'])
);

$password = generate_password($options);


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
    <input type="checkbox" name="lower" value="1" <?php if(isset($_GET['lower']) == 1) { echo 'checked'; } ?> /> Lowercase<br />
    <input type="checkbox" name="upper" value="1" <?php if(isset($_GET['upper']) == 1) { echo 'checked'; } ?> /> Uppercase<br />
    <input type="checkbox" name="numbers" value="1" <?php if(isset($_GET['numbers']) == 1) { echo 'checked'; } ?> /> Numbers<br />
    <input type="checkbox" name="symbols" value="1" <?php if(isset($_GET['symbols']) == 1) { echo 'checked'; } ?> /> Symbols<br />
    <input type="submit" value="Submit" />
</form>

</body>
</html>
