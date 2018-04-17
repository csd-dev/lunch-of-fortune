<?php
error_reporting(E_ALL);
include_once("config.php");

function make_seed()
{
  return floor(time() / (60*60*24));
}

$string = file_get_contents('https://jsonblob.com/api/jsonBlob/' . $JSON_API_KEY);
$json_a = json_decode($string, true);

$seed = make_seed();

mt_srand($seed);
$randval = mt_rand(0, count($json_a)-1);

$vals = array_values($json_a);
sort($vals);

?>

<html>
<head>
	<title>Lunch of Fortune</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>

	<hr>
	<div class="jumbotron text-center">
		<div class="container">
			<h1>SUGGESTION FOR YOUR LUNCH TODAY:</h1>
			<div class="alert alert-info" role="alert">
				<h2><?php echo $vals[$randval];?></h2>
			</div>
		</div>
	</div>
	<hr>

	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<pre>
<?php print_r($json_a); ?>
				</pre>
				<p>
					<a class="btn btn-primary btn-block" stlye="margin-top: 50px;" target="_blank" href="https://jsonblob.com/<?php echo $JSON_API_KEY; ?>">Edit votes</a>
				</p>
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
</body>
</html>
