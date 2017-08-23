<?php

function wiki_settings($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "config` SET `online`= '".$_POST['Status']."' WHERE `type` LIKE 'article' AND `data` LIKE '".$section."' ";
	$db->query($sql);
}

function wiki_gui($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['title']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'title' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['color']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'color' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['priority']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'priority' ";
	$db->query($sql);
}

function wiki_urls($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['url']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'url' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['api']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'api_url' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['logo']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'logo' ";
	$db->query($sql);
}

function wiki_categorys($db,$settings,$section)
{
	global $config;
	$categorys = explode("\n",$_POST['categorys']);
	
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_main` WHERE 1";
	$db->query($sql);
	
	foreach($categorys AS $category)
	{
		if(trim($category)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_main`(`online`, `category`) VALUES (1,'".trim($category)."')";
			$db->query($sql);
		}
	}
}

function wiki_exclude_categorys($db,$settings,$section)
{
	global $config;
	$exclude_categorys = explode("\n",$_POST['categorys']);
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'source' AND `type` LIKE 'exclude'";
	$db->query($sql);
	
	foreach($exclude_categorys AS $exclude)
	{
		if(trim($exclude)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('source','exclude','".trim($exclude)."')";
			$db->query($sql);
		}
	}
}

function wiki_feature_status($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_township_features` SET `online`= '".$_POST['Status']."' WHERE `type` LIKE 'binary' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function wiki_feature_info_true($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_township_features` SET `info_true`= '".$_POST['info_true']."' WHERE `type` LIKE 'binary' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function wiki_feature_info_false($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_township_features` SET `info_false`= '".$_POST['info_false']."' WHERE `type` LIKE 'binary' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function wiki_feature_feature_alias($db,$settings,$section)
{
	global $config;
	$alias_array = explode("\n",$_POST['alias']);
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_township_features_alias` WHERE `feature` LIKE '".$_POST['feature']."'";
	$db->query($sql);
	
	foreach($alias_array AS $alias)
	{
		if(trim($alias)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_township_features_alias`(`feature`, `alias`) VALUES ('".$_POST['feature']."','".trim($alias)."')";
			$db->query($sql);
		}
	}
}

function wiki_feature_new_feature($db,$settings,$section)
{
	global $config;
	$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_township_features`(`online`, `feature`, `type`) VALUES (3,'".$_POST['new']."','binary')";
	$db->query($sql);
	
	$sql = "ALTER TABLE `" . $config["dbprefix"] . $section . "_township_data` ADD `".umlaute($_POST['new'])."` INT NOT NULL";
	$db->query($sql);
}


function wiki_display($db,$settings,$section)
{
	global $config;
	$display = "";
	$display .= '<h1>'.$section.'</h1>';
	
	
	$display .= '<div class="box_b">';
	// Status
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `online` FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'article' AND `key` LIKE 'display' AND `data` LIKE '".$section."' ";
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
		$display .= '<td style="width:80px;">Titel: </td><td style="width:500px;"><input name="title" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//color
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'color'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Farbe: </td><td><input name="color" value="'.$row['data'].'" size="60"></td>';
		$display .= '</tr>';
	}
	$res->close();
	
	//priority
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "source_config` WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'priority'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= '<tr valign="top">';
		$display .= '<td>Priority: </td><td><input name="priority" value="'.$row['data'].'" size="60"></td>';
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
	
	$display .= '<tr valign="top">';
	$display .= '<td></td><td><div align="right"><input type="submit" value="ändern"></div></td>';
	$display .= '</tr></table></div>';
	
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_a">';
	//categorys
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=categorys&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `category` FROM `" . $config["dbprefix"] . $section . "_main` WHERE 1";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Quelle <br>Kategorien:</td><td style="width:500px;"><textarea name="categorys" cols="60" rows="6">';
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= $row['category']."\n";
	}
	$display = rtrim($display);
	$res->close();
	$display .= '</textarea></td>';
	$display .= '</tr>';
	
	$display .= '<tr valign="top">';
	$display .= '<td></td><td><div align="right"><input type="submit" value="ändern"></div></td>';
	$display .= '</tr></table></div>';
	
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_b">';
	// exclude
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=exclude_categorys&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'source' AND `type` LIKE 'exclude'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Quelle ohne: </td><td style="width:500px;"><textarea name="categorys" cols="60" rows="6">';
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= $row['data']."\n";
	}
	$display = rtrim($display);
	$res->close();
	$display .= '</textarea></td>';
	$display .= '</tr>';
	
	$display .= '<tr valign="top">';
	$display .= '<td></td><td><div align="right"><input type="submit" value="ändern"></div></td>';
	$display .= '</tr></table></div>';
	
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_a">';
	// feature
	$sql = "SELECT `feature`, `online`, `info_true`, `info_false` FROM `" . $config["dbprefix"] . $section . "_township_features` WHERE `type` LIKE 'binary'";
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
		$sql = "SELECT `alias` FROM `" . $config["dbprefix"] . $section . "_township_features_alias` WHERE `feature` LIKE '".$key."'";
		$res = $db->query($sql);
		$display .= '<tr valign="top"><td>Alias: </td><td>';
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

function wiki_select($db,$settings)
{
	global $config;
	$select = "";
	$select .= "<h1>config wikis</h1>";
	$select .= '<div class="box_a">';
	
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'article' AND `key` LIKE 'display'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$select .= '<a href="index.php?settings='.$settings.'&acton=display&section='.$row['data'].'">'.$row['data']."</a><br>";
	}
	
	$select .= '</div>';
	
	return $select;
}

function get_wiki($db,$settings)
{
	$wiki = "";
	$acton = "";
	$section = "";
	
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
		case "display":
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "settings":
			wiki_settings($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "gui":
			wiki_gui($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "urls":
			wiki_urls($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "categorys":
			wiki_categorys($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "exclude_categorys":
			wiki_exclude_categorys($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "feature_status":
			wiki_feature_status($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "info_true":
			wiki_feature_info_true($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "info_false":
			wiki_feature_info_false($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "feature_alias":
			wiki_feature_feature_alias($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		case "new_feature":
			wiki_feature_new_feature($db,$settings,$section);
			$wiki .= wiki_display($db,$settings,$section); 
		break;
		
		default:
			$wiki .= wiki_select($db,$settings);
		break;
	}
	
	return $wiki;
}

?>