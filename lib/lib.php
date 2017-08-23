<?php

function append_file($file,$data)
{
	$fp = fopen($file, "a");
	fputs ($fp, $data);
	fclose ($fp);
}

function umlaute($change)
{
	return str_replace(array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´"), array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", ""), $change);
}

function status($status)
{
	switch ($status)
	{
		case 0:
			$display = 'offline'; 
		break;
		
		case 1:
		case 2:
			$display = 'aktiv'; 
		break;

		case 3:
		case 4:
			$display = 'aktiviert'; 
		break;
		
		default:
			$display = 'unbekannt';
		break;
	}
	return $display;
}

?>