<?php

function login($db)
{
	global $config;
	$numuser = 0;
	$pw = "";
	
	if(isset($_GET["logout"]))
	{
		if($_GET["logout"] == "now")
		{
			if(session_status() != PHP_SESSION_NONE)
			{
				session_destroy();
			}
		}
		$_SESSION['us'] = "";
		$_SESSION['pw'] = "";
	}
	if(isset($_POST["name"]))
	{
		$_SESSION['us'] = $_POST["name"];
		$_SESSION['pw'] = $_POST["pw"];
	}
	
	if(isset($_SESSION['us']))
	{
		$user = $db->real_escape_string($_SESSION['us']);
		$sql = "SELECT `pw` FROM `" . $config['dbprefix'] . "user` WHERE `user` LIKE '$user'";
		$res = $db->query($sql);
		$numuser = $res->num_rows;
		if($numuser == 1)
		{
			$row = $res->fetch_array(MYSQLI_ASSOC);
			$pw = $row['pw'];
		}
		$res->close();
		
		if(password_verify($_SESSION['pw'], $pw))
		{
			return "OK";
		}
	}
	
	if(isset($_POST["name"]) && ($config['log']!="NO"))
	{
		append_file("log/login.txt","\n" . date(DATE_RFC822) . "\t" . $_SESSION['us'] . "\t" . $_SESSION['pw']);
	}
	
	return '<div align="center"><p style="color: #3C003C;"> <br><b>Login</b><br> </p>
		<form action="index.php" method="post">

		<table width="180" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
				<td>
					User:&nbsp;<br>&nbsp;
				</td>
				<td>
					<input name="name"><br> 
				</td>
			</tr>
			<tr valign="top">
				<td>
					Passwort:&nbsp;<br>&nbsp;
				</td>
				<td>
					<input type="password" name="pw"><br> 
				</td>
			</tr>
			<tr valign="top">
				<td> 
				</td>
				<td>
					<div align="right"><input type="submit" value="Login"><div>
				</td>
			</tr>
		</table>
		</form></div>';
}

?>