<?php

function list_settings($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "config` SET `online`= '".$_POST['Status']."' WHERE `type` LIKE 'list' AND `data` LIKE '".$section."' ";
	$db->query($sql);
}

function list_insertmainsection($db,$settings,$section)
{
	global $config;
	$sql = "INSERT INTO `" . $config["dbprefix"] . "config` (`online`,`type`, `key`, `data`) VALUES(1,'list','display','".$section."') ";
	$db->query($sql);
}

function list_removemainsection($db,$settings,$section)
{
	global $config;
	$sql = "DELETE FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'list' AND `key` LIKE 'display' AND `data` LIKE '".$section."' ";
	$db->query($sql);
}

function list_group($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `wiki` = '".$_POST['group']."' WHERE `key` LIKE 'display' AND `data` LIKE '".$section."' ";
	$db->query($sql);
}

function list_gui($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['title']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'title' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['color']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'color' ";
	$db->query($sql);
	$sql = "UPDATE `" . $config["dbprefix"] . "source_config` SET `data`= '".$_POST['priority']."' WHERE `wiki` LIKE '".$section."' AND `key` LIKE 'priority' ";
	$db->query($sql);
}

function list_urls($db,$settings,$section)
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

function list_vorlage($db,$settings,$section)
{
	global $config;
	$vorlagen = explode("\n",$_POST['vorlage']);
	
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_main` WHERE 1";
	$db->query($sql);
	
	foreach($vorlagen AS $vorlage)
	{
		if(trim($vorlage)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_main`(`online`, `category`) VALUES (1,'".trim($vorlage)."')";
			$db->query($sql);
		}
	}
}

function list_include_vorlage($db,$settings,$section)
{
	global $config;
	$exclude_categorys = explode("\n",$_POST['vorlage']);
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'source' AND `type` LIKE 'include'";
	$db->query($sql);
	
	foreach($exclude_categorys AS $exclude)
	{
		if(trim($exclude)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('source','include','".trim($exclude)."')";
			$db->query($sql);
		}
	}
}

function list_foot($db,$settings,$section)
{
	global $config;
	$foot = $_POST['foot'];
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'foot' AND `type` LIKE 'main'";
	$db->query($sql);
	
	if(trim($foot)!= "")
	{
		$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('foot','main','".trim($foot)."')";
		$db->query($sql);
	}
}

function list_head($db,$settings,$section)
{
	global $config;
	$head = $_POST['head'];
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'head' AND `type` LIKE 'main'";
	$db->query($sql);
	if(trim($head)!= "")
	{
		$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('head','main','".trim($head)."')";
		$db->query($sql);
	}
}

function list_body($db,$settings,$section)
{
	global $config;
	$body = $_POST['body'];
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'body' AND `type` LIKE 'main'";
	$db->query($sql);
	if(trim($body)!= "")
	{
		$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('body','main','".trim($body)."')";
		$db->query($sql);
	}
}

function list_id($db,$settings,$section)
{
	global $config;
	$id = $_POST['id'];
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'main' AND `type` LIKE 'id'";
	$db->query($sql);
	if(trim($id)!= "")
	{
		$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('main','id','".trim($id)."')";
		$db->query($sql);
	}
}

function list_head_feature($db,$settings,$section)
{
	global $config;
	$head_features = explode("\n",$_POST['head_feature']);
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'head' AND `type` LIKE 'feature'";
	$db->query($sql);
	
	foreach($head_features AS $head_feature)
	{
		if(trim($head_feature)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_config`(`key`, `type`, `data`) VALUES ('head','feature','".trim($head_feature)."')";
			$db->query($sql);
		}
	}
}

function list_feature_status($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_list_features` SET `online`= '".$_POST['Status']."' WHERE `type` LIKE 'text' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function list_feature_info_true($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_list_features` SET `info_true`= '".$_POST['info_true']."' WHERE `type` LIKE 'text' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function list_feature_info_false($db,$settings,$section)
{
	global $config;
	$sql = "UPDATE `" . $config["dbprefix"] . $section . "_list_features` SET `info_false`= '".$_POST['info_false']."' WHERE `type` LIKE 'text' AND `feature` LIKE '".$_POST['feature']."' ";
	$db->query($sql);
}

function list_feature_feature_alias($db,$settings,$section)
{
	global $config;
	$alias_array = explode("\n",$_POST['alias']);
	$sql = "DELETE FROM `" . $config["dbprefix"] . $section . "_list_features_alias` WHERE `feature` LIKE '".$_POST['feature']."'";
	$db->query($sql);
	
	foreach($alias_array AS $alias)
	{
		if(trim($alias)!= "")
		{
			$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_list_features_alias`(`feature`, `alias`) VALUES ('".$_POST['feature']."','".trim($alias)."')";
			$db->query($sql);
		}
	}
}

function list_feature_new_feature($db,$settings,$section)
{
	global $config;
	$sql = "INSERT INTO `" . $config["dbprefix"] . $section . "_list_features`(`online`, `feature`, `type`) VALUES (3,'".$_POST['new']."','text')";
	$db->query($sql);
	
	$sql = "ALTER TABLE `" . $config["dbprefix"] . $section . "_list_data` ADD `".umlaute($_POST['new'])."` TEXT NOT NULL";
	$db->query($sql);
}


function list_display($db,$settings,$section)
{
	global $config;
	$display = "";
	$display .= '<h1>'.$section.'</h1>';
	
	
	$display .= '<div class="box_b">';
	// Status
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `online` FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'list' AND `key` LIKE 'source' AND `data` LIKE '".$section."' ";
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
	$sql = "SELECT `online` FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'list' AND `key` LIKE 'display' AND `data` LIKE '".$section."' ";
	$res = $db->query($sql);
	$display .= '<tr valign="top"><td style="width:80px;">';
	$display .= 'Hauptliste:';
	$display .= '</td><td style="width:500px;">';
	
	$display_mainlist = 'Nein <a href="index.php?settings='.$settings.'&acton=insertmainsection&section='.$section.'">aktivieren</a>';
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display_mainlist = 'Ja <a href="index.php?settings='.$settings.'&acton=removemainsection&section='.$section.'">entfernen</a>';
	}
	$res->close();
	$display .= $display_mainlist;
	$display .= '</td>';
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
	//Vorlage
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=vorlage&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `category` FROM `" . $config["dbprefix"] . $section . "_main` WHERE 1";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Quelle <br>Vorlage:</td><td style="width:500px;"><textarea name="vorlage" cols="60" rows="6">';
	
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
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=include_vorlage&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'source' AND `type` LIKE 'include'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Quelle mit: (exklusiv)</td><td style="width:500px;"><textarea name="vorlage" cols="60" rows="6">';
	
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
	// foot
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=foot&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'foot' AND `type` LIKE 'main'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Tabellenfuß</td><td style="width:500px;"><input name="foot" value="';
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= $row['data']."\n";
	}
	$res->close();
	$display .= '" size="60"> <input type="submit" value="ändern">';
	$display .= '</td>';
	$display .= '</tr></table>';
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_a">';
	// head
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=head&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'head' AND `type` LIKE 'main'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Tabellenkopf</td><td style="width:500px;"><input name="head" value="';
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= $row['data']."\n";
	}
	$res->close();
	$display .= '" size="60"> <input type="submit" value="ändern">';
	$display .= '</td>';
	$display .= '</tr></table>';
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_a">';
	// body
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=body&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'body' AND `type` LIKE 'main'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Tabellenzeile</td><td style="width:500px;"><input name="body" value="';
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= $row['data']."\n";
	}
	$res->close();
	$display .= '" size="60"> <input type="submit" value="ändern">';
	$display .= '</td>';
	$display .= '</tr></table>';
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_b">';
	// id
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=id&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'main' AND `type` LIKE 'id'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">ID</td><td style="width:500px;"><input name="id" value="';
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$display .= $row['data']."\n";
	}
	$res->close();
	$display .= '" size="60"> <input type="submit" value="ändern">';
	$display .= '</td>';
	$display .= '</tr></table>';
	$display .= '</form>';
	$display .= '</div>';
	
	
	$display .= '<div class="box_b">';
	// head_feature
	$display .= '<form method="POST" action="index.php?settings='.$settings.'&acton=head_feature&section='.$section.'" enctype="multipart/form-data">';
	$display .= '<div align="center"><table border="0" cellpadding="0" cellspacing="0">';
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . $section . "_config` WHERE `key` LIKE 'head' AND `type` LIKE 'feature'";
	$res = $db->query($sql);
	
	$display .= '<tr valign="top">';
	$display .= '<td style="width:80px;">Features: (Kopf)</td><td style="width:500px;"><textarea name="head_feature" cols="60" rows="6">';
	
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
	$sql = "SELECT `feature`, `online`, `info_true`, `info_false` FROM `" . $config["dbprefix"] . $section . "_list_features` WHERE `type` LIKE 'text'";
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
		$sql = "SELECT `alias` FROM `" . $config["dbprefix"] . $section . "_list_features_alias` WHERE `feature` LIKE '".$key."'";
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

function list_select($db,$settings)
{
	global $config;
	$select = "";
	$select .= "<h1>config lists</h1>";
	$select .= '<div class="box_a">';
	
	$sql = "SELECT `data` FROM `" . $config["dbprefix"] . "config` WHERE `type` LIKE 'list' AND `key` LIKE 'source'";
	$res = $db->query($sql);
	
	while($row = $res->fetch_array(MYSQLI_ASSOC))
	{
		$select .= '<a href="index.php?settings='.$settings.'&acton=display&section='.$row['data'].'">'.$row['data']."</a><br>";
	}
	
	$select .= '</div>';
	
	return $select;
}

function get_list($db,$settings)
{
	$list = "";
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
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "settings":
			list_settings($db,$settings,$section); 
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "insertmainsection":
			list_insertmainsection($db,$settings,$section); 
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "removemainsection":
			list_removemainsection($db,$settings,$section); 
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "group":
			list_group($db,$settings,$section); 
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "gui":
			list_gui($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "urls":
			list_urls($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "vorlage":
			list_vorlage($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "include_vorlage":
			list_include_vorlage($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "foot":
			list_foot($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "head":
			list_head($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "body":
			list_body($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "id":
			list_id($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "head_feature":
			list_head_feature($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "feature_status":
			list_feature_status($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "info_true":
			list_feature_info_true($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "info_false":
			list_feature_info_false($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "feature_alias":
			list_feature_feature_alias($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		case "new_feature":
			list_feature_new_feature($db,$settings,$section);
			$list .= list_display($db,$settings,$section); 
		break;
		
		default:
			$list .= list_select($db,$settings);
		break;
	}
	
	return $list;
}

?>