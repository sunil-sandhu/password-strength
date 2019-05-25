<?php


function detect_any_uppercase($string) {
    //Comparison operator. Returns true if lowercase changes string
    return strtolower($string) != $string;
}


function detect_any_lowercase($string) {
    //true if uppercase changes string
    return strtoupper($string) != $string;
}


function count_numbers($string) {
    return preg_match_all('/[0-9]/', $string);
}

function count_symbols($string) {
    // You have to decide which symbols count
    // Regex /W is any non-letter, non-number: but this could be too broad
    // Better to list the ones that count
    // To write a regex here, you start with '', then inside that some square brackets [], then inside the square brackets is everything you want to include
    // Escape regex symbols to get their literal values - preg_quote helps facilitate that
    $regex = '/[' . preg_quote('!@£$%^&*-_+=?') . ']/';
    return preg_match_all($regex, $string);
}


function password_strength($password) {
    $strength = 0;
    $possible_points = 12;
    $length = strlen($password);


    if(detect_any_uppercase($password)) {
        $strength += 1;
    }

    if(detect_any_lowercase($password)) {
        $strength += 1;
    }

//    echo count_numbers($password);
//    echo count_symbols($password);

    // this adds points for numbers but limits the total possible to 2
    $strength += min(count_numbers($password), 2);
    // same again for symbols
    $strength += min(count_symbols($password), 2);


    if($length >= 8) {
        $strength += 2;
        $strength += min(($length - 8) * 0.5, 4);
    }


    $strength_percent = $strength / (float) $possible_points;
    $rating = floor($strength_percent * 10);
    return $rating;

}

$password = $_POST['rate'];
$rating = password_strength($password);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Strength</title>


    <style>
        #meter div {
            height: 20px;
            width: 20px;
            margin: 0 1px 0 0;
            padding: 0;
            float: left;
            background-color: #DDDDDD;
        }

        #meter div.rating-1, #meter div.rating-2 {
            background-color: red;
        }

        #meter div.rating-3, #meter div.rating-4 {
            background-color: orange;
        }

        #meter div.rating-5, #meter div.rating-6 {
            background-color: yellow;
        }

        #meter div.rating-7, #meter div.rating-8 {
            background-color: greenyellow;
        }

        #meter div.rating-9, #meter div.rating-10 {
            background-color: green;
        }


    </style>
</head>
<body>

<p>Your password strength is: <?php echo $rating; ?></p>

<div id="meter">
    <?php
    for($i=0; $i < 10; $i++) {
    echo "<div";
    if($rating > $i) {
        echo " class=\"rating-{$rating}\"";
    }
    echo "></div>";
    }
    ?>
</div>


<br>
<br>
<form action="passwordstrength.php" method="post">

    Password: <input type="text" name="rate" value="">
    <br>
    <input type="submit" value="Submit">

</form>

</body>
</html>