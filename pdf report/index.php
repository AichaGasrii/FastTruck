<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf= new Dompdf();

// $html = '
	// <h1>CODESTAR TECHNOLOGIES</h1>
	// <p>We are the frontiers in innovation</p>
// ';
if(isset($_POST['submit'])){
		
	//$html = $_POST['exam'];

	//$dompdf->loadHtml($html);

	$page = file_get_contents("cat.html");
	$dompdf->loadHtml($page);

	$dompdf->setPaper('A4','landscape');
	$dompdf->render();
	//$file = $dompdf->stream("codestar",array("Attachment"=>0));
	$output = $dompdf->output();
	file_put_contents('Brochure.pdf', $output);
}                                                                                                                     

	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
	<script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
  </head>
  <body>
    <form action="index.php" method="POST">
	<h1>Creating PDF Report</h1>
	<textarea name="exam" cols="60" rows="15"></textarea>
	<script>CKEDITOR.replace( 'exam' );</script>
	<button type="submit" name="submit" value="btn">Click</button>
	</form>
  </body>
</html>
