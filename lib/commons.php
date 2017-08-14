<?php

function commons_settings($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "config` SET `online`= '".$_POST['Status']."' WHERE `type` LIKE 'commons' AND `data` LIKE '".$section."' ";
	$db->query($sql);
}

function commons_group($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `wiki` = '".$_POST['group']."' WHERE `key` LIKE 'display' AND `data` LIKE '".$section."' ";
	$db->query($sql);
}

function commons_gui($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['title']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'title' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['color']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'color' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['priority']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'priority' ";
	$db->query($sql);
}

function commons_urls($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['url']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'url' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['api']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'api_url' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['logo']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'logo' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['marker']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'marker' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['linktext']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'linktext' ";
	$db->query($sql);
}

function commons_feature_status($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_photos_features` SET `online`= '".$_POST['Status']."' WHERE `type` LIKE 'text' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function commons_feature_info_true($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_photos_features` SET `info_true`= '".$_POST['info_true']."' WHERE `type` LIKE 'text' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function commons_feature_info_false($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_photos_features` SET `info_false`= '".$_POST['info_false']."' WHERE `type` LIKE 'text' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function commons_feature_feature_alias($db,$settings,$section)
{
	global $config;
	$alias_array = explode("\n",$_POST['alias']);
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_photos_features_alias` WHERE `feature` LIKE '".$_POST['feature']."'";
	$db->query($sql);

	foreach($alias_array AS $alias)
	{
		if(trim($alias)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_photos_features_alias`(`feature`, `alias`) VALUES ('".$_POST['feature']."','".trim($alias)."')";
			$db->query($sql);
		}
	}
}

function commons_feature_new_feature($db,$settings,$section)
{
	global $config;
	$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_photos_features`(`online`, `feature`, `type`) VALUES (3,'".$_POST['new']."','text')";
	$db->query($sql);
	
	$sql = "ALTER TABLE `" . $config["dbprefix"] . $section . "_commonscat` ADD `".umlaute($_POST['new'])."` INT NOT NULL";
	$db->query($sql);
}


function commons_display($db,$settings,$section)
{
	global $config;
	$display = "";
	$display .= '<h1>'.$section.'</h1>';
	
	$display .= '<div class="box_b">';
	// Status
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `online` FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'commons' AND `key` LIKE 'display' AND `data` LIKE '".$section."' ";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$online = $row['online'];
		
		$display .= '<tr valign="top"><td style="width:80px;">';
		$display .= 'Status:';
		$display .= '</td><td style="width:500px;">';
		
		$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=settings&section='.$section.'" enctype="multipart/form-data">';
		
		$display .= status($online);
		
		$display .= ' <select name="Status">';
			$display .= '<option value="0">offline setzen</option>';
			$display .= '<option value="3">aktivien</option>';
		$display .= '</select>';
		
		$display .= ' <input type="submit" value="ändern">';
		$display .= '</form>';

		$display .= '</td>';
	}
	$res->close();
	$display .= '</tr></table></div>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_b">';
	// Status
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=group&section='.$section.'" enctype="multipart/form-data">';
	$sql = "SELECT `wiki` FROM `" . $config["dbprefix"] . "source_config` WHERE `key` LIKE 'display' AND `data` LIKE '".$section."' ";
	$res = $db->query($sql);
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td style="width:80px;">Gruppe: </td><td style="width:500px;"><input name="group" value="'.$row['wiki'].'" size="60"> <input type="submit" value="ändern"></td>';
		$display .= '</tr>';
	}
	$res->close();
	$display .= '</td>';
	$display .= '</tr></table>';
	$display .= '</form>';
	$display .= '</div>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_a">';
	// GUI
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=gui&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	//title
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'title'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td style="width:80px;">Titel: </td><td style="width:500px;"><input name="title" value='.$row['data'].' size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//color
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'color'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Farbe: </td><td><input name="color" value='.$row['data'].' size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//priority
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'priority'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Priority: </td><td><input name="priority" value='.$row['data'].' size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	$display .= '<tr valign="top">';
	$display .= '<td></td><td><div align="right"><input type="submit" value="ändern"></div></td>';
	$display .= '</tr></table></div>';
	
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_b">';
	// urls
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=urls&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	//url
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'url'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td style="width:80px;">URL: </td><td style="width:500px;"><input name="url" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//api
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'api_url'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>API: </td><td><input name="api" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//logo
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'logo'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Logo: </td><td><input name="logo" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//marker
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'marker'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Marker: </td><td><input name="marker" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//linktext
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'linktext'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Linktext: </td><td><input name="linktext" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	$display .= '<tr valign="top">';
	$display .= '<td></td><td><div align="right"><input type="submit" value="ändern"></div></td>';
	$display .= '</tr></table></div>';
	
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_a">';
	// feature
	$sql = "SELECT `feature`, `online`, `info_true`, `info_false` FROM `" . $config["dbprefix"] . $section . "_photos_features` WHERE `type` LIKE 'text'";
	$res = $db->query($sql);
	
	$features = array();
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$features[$row['feature']]['online'] = $row['online'];
		$features[$row['feature']]['info_true'] = $row['info_true'];
		$features[$row['feature']]['info_false'] = $row['info_false'];
	}
	$res->close();
	
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Features</td><td style="width:500px;"></td>';
	$display .= '</tr>';
	foreach($features AS $key => $feature)
	{
		// feature
		$display .= '<tr valign="top"><td><b>'.$key.'</b>: </td><td>';
		$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=feature_status&section='.$section.'" enctype="multipart/form-data">';
		$display .=  "Status: " . status($feature['online']);
			$display .= ' <select name="Status">';
				$display .= '<option value="0">offline setzen</option>';
				$display .= '<option value="3">aktivien</option>';
			$display .= '</select>';
		$display .= '<input type="hidden" name="feature" value="'.$key.'">';
		$display .= ' <input type="submit" value="ändern">';
		$display .= '</form>';
		$display .= "</td></tr>";
		
		// info_true
		$display .= '<tr valign="top"><td>Info existiert nicht: </td><td>';
		$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=info_true&section='.$section.'" enctype="multipart/form-data">';
		$display .= '<textarea name="info_true" cols="60" rows="6">';
			$display .= $feature['info_true'];
		$display .= '</textarea>';
		$display .= '<input type="hidden" name="feature" value="'.$key.'">';
		$display .= '<br><div align="right"><input type="submit" value="ändern"></div>';
		$display .= '</form>';
		$display .= "</td></tr>";
		
		// info_false
		$display .= '<tr valign="top"><td>Info existiert: </td><td>';
		$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=info_false&section='.$section.'" enctype="multipart/form-data">';
		$display .= '<textarea name="info_false" cols="60" rows="6">';
			$display .= $feature['info_false'];
		$display .= '</textarea>';
		$display .= '<input type="hidden" name="feature" value="'.$key.'">';
		$display .= '<br><div align="right"><input type="submit" value="ändern"></div>';
		$display .= '</form>';
		$display .= "</td></tr>";
		
		// alias
		$sql = "SELECT `alias` FROM `" . $config["dbprefix"] . $section . "_photos_features_alias` WHERE `feature` LIKE '".$key."'";
		$res = $db->query($sql);
		$display .= '<tr valign="top"><td>Category: </td><td>';
		$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=feature_alias&section='.$section.'" enctype="multipart/form-data">';
		$display .= '<textarea name="alias" cols="60" rows="6">';
		while($row = $res->fetch_array(MYSQLI_ASSOC))
		{
			$display .= $row['alias']."\n";
		}
		$display = rtrim($display);
		$res->close();
		$display .= '</textarea>';
		$display .= '<input type="hidden" name="feature" value="'.$key.'">';
		$display .= '<br><div align="right"><input type="submit" value="ändern"></div>';
		$display .= '</form>';
		$display .= "</td></tr>";
	}
	$display .= '<tr valign="top">';
	$display .= '<td>Neues Feature</td><td>';
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=new_feature&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<input name="new" size="60"> <input type="submit" value="hinzufügen"></td>';
	$display .= '</form>';
	$display .= '</tr>';
	$display .= '</table><p></p></div>';
	
	return $display;
}

function get_commons($db,$settings)
{
	$commons = "";
	$acton = "";
	$section = "commons";
	
	if(isset($_GET["acton"]))
	{
		$acton = $_GET["acton"];
	}
	
	if(isset($_GET["section"]))
	{
		$section = $_GET["section"];
	}
	
	switch ($acton)
	{
		case "settings":
			commons_settings($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "group":
			commons_group($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "gui":
			commons_gui($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "urls":
			commons_urls($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "feature_status":
			commons_feature_status($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "info_true":
			commons_feature_info_true($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "info_false":
			commons_feature_info_false($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "feature_alias":
			commons_feature_feature_alias($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		case "new_feature":
			commons_feature_new_feature($db,$settings,$section);
			$commons .= commons_display($db,$settings,$section);
		break;
		
		default:
			$commons .= commons_display($db,$settings,$section);
		break;
	}
	
	return $commons;
}

?>