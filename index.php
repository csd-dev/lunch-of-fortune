<?php
error_reporting(E_ALL);
include_once("config.php");

function make_seed()
{
    return floor(time() / (60*60*24));
}

function trim_value(&$value)
{
    $value = trim($value);
}

$string = file_get_contents('https://jsonblob.com/api/jsonBlob/' . $JSON_API_KEY);
$json_a = json_decode($string, true);

$seed = make_seed();

mt_srand($seed);
$randval = mt_rand(0, count($json_a)-1);

$vals = array_values($json_a);
array_walk($vals, 'trim_value');
sort($vals);

$hour = date('H', time());
$min = date('i', time());

if ($hour > $WINNER_HOUR or ($hour >= $WINNER_HOUR and $min >= $WINNER_MIN)) {
    $winner = $vals[$randval];
    $editbtn = '<button  class="btn btn-danger btn-block">It is too late to edit your votes today!</button>';
} else {
    $winner = 'The winner will be announced after ' . $WINNER_HOUR . ':' . $WINNER_MIN;
    $editbtn = '<a class="btn btn-primary btn-block"
                    target="_blank"
                    href="https://jsonblob.com/'. $JSON_API_KEY . '">
                    Edit votes
                    </a>';
}

?>

<html>
<head>
    <title>Lunch of Fortune</title>
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
</head>
<body>

<hr>
<div class="jumbotron text-center">
    <div class="container">
        <h1>SUGGESTION FOR YOUR LUNCH TODAY:</h1>
        <div class="alert alert-info" role="alert">
            <h2><?php echo $winner; ?></h2>
        </div>
    </div>
</div>
<hr>

<div class="container">
    <div class="row">
        <div class="col-md-4">
         <pre><?php print_r($vals); ?></pre>
        </div>
        <div class="col-md-4">
            <pre><?php print_r($json_a); ?></pre>
            <p><?php echo $editbtn; ?></p>
        </div>
        <div class="col-md-4">
            <?php
            if (isset($_REQUEST['debug'])) {
                echo '<p>Rand value: ' . $randval . '</p>';
                echo '<p>Seed: ' . $seed . '</p>';
            }
            ?>
        </div>
    </div>
</div>
<hr>
<footer class="container text-center">
    <p>CsD 2018 &copy; <a href="https://github.com/csd-dev/lunch-of-fortune" target="_blank">GitHub - Lunch of Fortune</a></p>
    <p><?php echo $hour. ':' . $min; ?></p>
</footer>
</body>
</html>
