<!DOCTYPE html>
<html>
  <head>
    <title>Foo</title>
		<style>
*{
	margin:0;
	padding:0;
	font-family:inherit;
	font-size:inherit;
}
html,body{
	font-family:Helvetica;
	font-size:11px;
}
table{
	text-align:left;
	border-collapse:collapse;
	position:relative;
	page-break-after:always;
	width:100%;
}
td{
	border:1px solid #e5e5e5;
	vertical-align:top;
	position:relative;
	page-break-inside:avoid;
}
td.epic,
td.id{
	background-color:#f4f4f4;
}
td.epic{
	text-decoration:underline;
}
td.feature{
	/*font-weight:bold;*/
}
td.id{
	width:7%;
	font-weight:bold;
}
td.feature{
	width:20%;
}
.epic{
	font-weight:bold;
}
.epic.big{
	font-size:1.5em;
	margin-bottom:1em;
	color:#5da4db;
}
.epic.big, td{
	padding:0.5em;
}
.notes{
	font-style:italic;
}
		</style>
  </head>
  <body>
<?php

error_reporting(E_ERROR);

$data = file_get_contents("data.tsv");
$data = explode(PHP_EOL, $data);
$lastepic = "";
$isfirst = true;
foreach($data as $linenum => $line){
  if(empty(trim($line))) continue;
  $line = explode("\t", $line);
  $id = $line[0];
  $epic = $line[1];
	$feature = $line[2];
	$description = trim($line[3]);
	$notes = trim($line[4]);

  if(empty($id)){
		if(!$isfirst){
			echo "</table>";
		}
		$isfirst = false;
    echo <<<HTML

  	<h2 class="epic big">$epic</h2>
		<table>
HTML;
    continue;
  }

  if($epic != $lastepic){
    $lastepic = $epic;
    echo <<<HTML

  		<tr>
				<td colspan="3" class="epic">$epic</td>
			</tr>
HTML;
  }

	$description = str_replace("**", "<br />&bull;", $description);
	$notes = str_replace("**", "<br />&bull;", $notes);
  echo <<<HTML

			<tr>
				<td class="id">ID &num;<span>$id</span></td>
			  <td class="feature">$feature</td>
				<td class="long">
					<p class="description">$description</p>
					<p class="notes">$notes</p>
				</td>
			</tr>
HTML;
}

?>
		</table>
  </body>
</html>
