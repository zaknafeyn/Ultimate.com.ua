<?
	include($_SERVER["DOCUMENT_ROOT"]."/include/globals.php");
    $lang = "ru";
    $TITLE_chat = "��� :: ULTIMATE ������ �� ������� (����)";
	include($_SERVER["DOCUMENT_ROOT"]."/include/header.php");

	include ("c_config.php");
	include ("vars.php");

    $action='';
    if (isset($_POST['action'])) $action = $_POST['action'];
	if ($action=="register") {

        ?><style>.i{ font-size: 12px; border: thin; color: black; width: 150px}</style><?

	    if (isset($_POST['name'])){$name = $_POST['name'];}
	    if (isset($_POST['new_id'])){$new_id = $_POST['new_id'];}
	    if (isset($_POST['pasw1'])){$pasw1 = $_POST['pasw1'];}
	    if (isset($_POST['pasw2'])){$pasw2 = $_POST['pasw2'];}
	    if (isset($_POST['sex'])){$sex = $_POST['sex'];}
	    if (isset($_POST['nick_color'])){$nick_color = $_POST['nick_color'];} else { $nick_color='000000'; }
	    if (isset($_POST['mes_color'])){$mes_color = $_POST['mes_color'];} else { $mes_color='000000'; }
	    if (isset($_POST['email'])){$email = $_POST['email'];}else{$email='';}
	    if (isset($_POST['top2bot'])){$top2bot = $_POST['top2bot'];}else{$top2bot='0';}

	    if (!isset($c)){$c="";}
	    if (!isset($new_id)){$new_id="";}
	    if (!isset($name)){$name="";}
	    if (!isset($pasw1)){$pasw1="+++";}
	    if (!isset($pasw2)){$pasw2="---";}
	    if (!isset($sex)){$sex="u";}
	    if (($sex != "m")&&($sex != "w")){$sex="u";}

        if ($new_id == "1"){
	        # ����������� ������ ��������

	        $err=0;
	        $t_name = $name;
	        $t_name = trim_nick_name($t_name);
	        if ($t_name==""){$t_name="error";}

	        $t_pasw1 = $pasw1;
	        $t_pasw1 = sp_c_m_s($t_pasw1);
	        if ($t_pasw1==""){$t_pasw1="error1";}

	        $t_pasw2 = $pasw2;
	        $t_pasw2 = sp_c_m_s($t_pasw2);
	        if ($t_pasw2==""){$t_pasw2="error2";}
	        if (strlen($name) < 2){$t_pasw2=$pasw2."error";}
	        if ((strlen($name) == 2)&&($name{0} == $name{1})){$t_pasw2=$pasw2."error";}

	        if (($name != $t_name) ||
	        	($pasw1 != $t_pasw1)||
	        	($pasw2 != $t_pasw2) ||
	        	($pasw1 != $pasw2)) {
                ?><center><h3 style="color:black">����� ��� ������ ������ �����������!</h3></center><?
	        	$err=1;
            } else {

	            $sql = "SELECT * FROM my4_users WHERE name LIKE '%$t_name%'";
	            $rst = $db->sql_query($sql) or die("<p>$sql<p>".mysql_error());
	            $count = 0;
	            while ($line = $db->sql_fetchrow($rst, MYSQL_ASSOC))
	                if (strtoupper($line['name'])==strtoupper($name))
	                    $count+=1;

	            if (($count == 0)&&($err==0)) {
	                $sql = "INSERT INTO my4_users (name,pass,rights,regdate,top2bot,refresh,sex,email,nick_color,mes_color,bg)
	                VALUES('$name','".substr(md5($pasw1),0,9)."','guest',".time().",$top2bot,'5','$sex','$email','$nick_color','$mes_color',1)";
	                $rst = $db->sql_query($sql) or die("<p>$sql<p>".mysql_error());

	                ?><center>
	                    <table width="100%" cellpadding="5" cellspacing="1">
	                        <tr><td align="center"><h3 style="color:black">�� ������� ������ �����������!</h3></td></tr>
	                        <tr><td>
	                            <form name="enter" action="index.php" method="POST" style="margin-top: 1; margin-bottom: 1;">
	                            <table cellspacing="0" ceppladding="2" border="0" align="center">
	                                <tr><td><p class="f12b">�����<br><input class="i" name=name value="<?php print $name; ?>" type=text></td><td>
	                                <tr><td><p class="f12b">������<br><input class="i" name=pasw value="<?php print $pasw1; ?>" type=password></td><td>
	                                <tr><td align="center"><p><input class="b" value="����� � ���" type="Submit" style="cursor:hand;"></td></tr>
	                            </table>
	                            </form>
	                        </td></tr>
	                    </table>
	                </center>
	                <?php
	                exit;
	            }

	            if (($count != 0)&&($err==0)){ ?><center><h3 style="color:black">��� ��� ��� ������!</h3></center><?php }
			}
	    }

?>

	<h2><a href="index.php">���</a></h2>
    <form name="regform" action="index.php" method="POST">
	<input type="hidden" name="action" value="register">
	<table width="100%" cellpadding="5" cellspacing="1">
  	<tr><td align="center"><h3>�����������</h3></td>
    </tr>
		<tr>
    	<td valign="top" align="center">
      	<table>
      		<tr><td><p>�����<br><input class="i" name="name" value="" type="text"></td></tr>
					<tr><td><p>������<br><input class="i" name=pasw1 value="" type="password"></td></tr>
					<tr><td><p>��������� ������<br><input class="i" name=pasw2 value="" type="password"></td></tr>
	        <tr>
          	<td><p>���� ����
	            <br>
	            <select class="i" onchange="document.forms[0].nick_color.value = this.options[this.selectedIndex].value;">
	            <option value='000000'>- �������� -</option>
	            <?php
	              $co = sizeof($color_array[0]);
	              for ($i=0;$i<$co;$i++){
                	?><option style='background: <?php echo $color_array[1][$i]; ?>; color: <?php echo $color_array[1][$i]; ?>;' value='<?php echo $color_array[1][$i]; ?>'><?php echo $color_array[0][$i]; ?></option><?php
	              }
	            ?>
	            </select>
              <input class="i" name='nick_color' value="<?php echo $nick_color; ?>" size=6 maxlength=6>
	          </td>
	        </tr>
	        <tr>
		        <td><p>���� ���������
	            <br>
	            <select class="i" onchange="document.forms[0].mes_color.value = this.options[this.selectedIndex].value;">
	            <option value='000000'>- �������� -</option>
	            <?php
	              $co = sizeof($color_array[0]);
	              for ($i=0;$i<$co;$i++){
                	?><option style='background: <?php echo $color_array[1][$i]; ?>; color: <?php echo $color_array[1][$i]; ?>;' value='<?php echo $color_array[1][$i]; ?>'><?php echo $color_array[0][$i]; ?></option><?php
	              }
	            ?>
	            </select>
              <input class="i" name='mes_color' value="<?php echo $mes_color; ?>" size=6 maxlength=6>
	        	</td>
	        </tr>
	        <tr><td><p>e-mail<br><input class="i" type=text name="email" value='<?php echo $email; ?>' maxlength="30" size="15"></td></tr>
					<tr><td><p>������� <input type="radio" style="border: none;	width: 20px;" name="sex" value="m"><img src="/chat/images/i_m.gif" border=0>&nbsp;<input type="radio" style="border: none; width: 20px;" name="sex" value="w"><img src="/chat/images/i_w.gif" border=0></td></tr>
					<tr><td><p>����� ��������� <input type="radio" style="border: none; width: 20px;" name="top2bot" value="0" checked>������&nbsp;<input type="radio" style="border: none; width: 20px;" name="top2bot" value="1">�����</td></tr>
        </table>
      </td>
    </tr>
    <tr><td align=center>
	    <input type="hidden" name="new_id" value="1">
	    <input name="p_send" value="������������������" type="submit" style='cursor:hand;'><br>
    </td></tr>
  </table>

</form>

<?
	} else {

	$name = '';
	$pasw = '';
	if (isset($_POST['name'])){$name = $_POST['name'];}
	if (isset($_POST['pasw'])){$pasw = $_POST['pasw'];}

	$count = 0;
	$sql = "SELECT * FROM my4_users WHERE name LIKE '%$name%'";
	$rst = $db->sql_query($sql) or die("$sql<p>".mysql_error());
	while ($line = $db->sql_fetchrow($rst, MYSQL_ASSOC))
	    if ( (strtoupper($line['name']) == strtoupper($name)) && (substr(md5($pasw),0,9) == $line['pass']) ) {
	        $count++;
	        $id_user = $line['id_user'];
		}

    if ($count!=0) {

global $server_time;
global $sleep_period;

	$mytime = time();
	$ip = getenv ("REMOTE_ADDR");
	$sex = get_user_param($id_user,"sex");
	$st = get_user_param($id_user,"rights");
	$initst = get_user_param($id_user,"initst");
	if ($initst=='') $initst='�����';

	$sql = "SELECT * FROM my4_session WHERE id_user=$id_user";
  $rst = $db->sql_query($sql) or die("<p>$sql<p>".mysql_error());
  if ($db->sql_affectedrows($rst)!=0) {
  	// ��� � ����
    $line = $db->sql_fetchrow($rst, MYSQL_ASSOC);
    $mid = $line['mid'];
	  $sql = "UPDATE my4_session SET lasttime=$mytime, lut=$mytime WHERE id_user=$id_user";
  } else {
  	// � ���� ��� - ���������
		$mid=sp_my_id($name,$ip);
	  $sql = "INSERT INTO my4_session (mid,id_user,ip,lasttime,rights,sex,status,lut)
    	VALUES('$mid',$id_user,'$ip',$mytime,'$st','$sex','$initst',$mytime)";
    say_enter($id_user);
# ���������� � ����� �����
	sp_put_nil($id_user);
  }
	$rst = $db->sql_query($sql) or die("$sql<p>".mysql_error());


?>

	<iframe name="chat" id="chat" src="enter.php?mid=<?php print $mid; ?>" scrolling="yes" frameborder="0" width="100%" height="100%">
	</iframe>

<?

} else {

?>
	<table width=100% cellspacing=0 cellpadding=0 border=0>
		<tr valign=top>
			<td width=165 bgcolor=#409C27 height=100%>
            	<p>������ � ����:
                	<?php
						sp_check_users_ip_name(0);
	                    $sql = "SELECT * FROM my4_session s LEFT JOIN my4_users u ON s.id_user=u.id_user";
	                    $rst = $db->sql_query($sql) or die("<p>$sql<p>".mysql_error());
                        if ($db->sql_affectedrows($rst)) {
                        	$ntime = time() + $server_time;
	                        print "<table cellspacing=2 cellpadding=0>";
	                        while ($line = $db->sql_fetchrow($rst)) {
	                            //if (($ntime - $line['lasttime'])<$sleep_period) {
	                                $id_user1 = $line['id_user'];
	                                $sex1 = get_user_param($id_user1, "sex");
	                                if ($sex1=="") $sex1="u";
	                                $name1 = get_user_param($id_user1, "name");
	                                  if ($avatar_file = get_user_param($id_user1,"avatar")) {
	                                    $user_image = "<img src=\"avatars/$avatar_file\" style=\"border:none\">";
	                                  } else {
	                                    $user_image = "<img src=\"images/i_$sex1.gif\" style=\"border:none\">";
	                                  }
	                                  echo "<tr><td align=center>$user_image</td>";
	                                  echo "<td valign=center><font style=\"font-size: 13px;\" color=$sex_color[$sex1]>&nbsp;$name1</font>";
	                            //} else {
	                            //    say_disconnected($line['id_user']);
	                            //}
	                        }
	                        echo "</table>";
                        }
                    ?>
            </td>

            <td>
				<center><h2><a href="/chat/">���</a></h2></center>
	            <table border="0" width="100%"><FORM METHOD=POST ACTION="index.php">
	                <tr align="center">
	                    <td width align="right">�����:
	                    <INPUT style="width:80px;" TYPE="text" NAME="name"></td>
                    	<td align="left">������:
	                    <INPUT style="width:80px;" TYPE="password" NAME="pasw"></td>
                    </tr>
	                <tr align="center">
                    	<td colspan="2" align="center"><INPUT style="width=100px;" TYPE="submit" NAME="submit" value="����"></td>
	                </tr></FORM>
	                <tr align="center">
                    	<td colspan="2" align="center">
                        	<form method="post" action="" name="f1">
							<input type="hidden" name="action" value="register">
                            <INPUT style="width=100px;" TYPE="submit" value="�����������">
                            </form>
                        </td>
	                </tr></FORM>
                </table>

            </td>

        </tr>
        <tr>
        	<td colspan="2">
            	<table width="100%">
                	<tr><td>
            			<p><br /><h3>��������� ��������� � ����:</h3></p>
                    </td></tr>
                	<tr><td style="background-color: #D6F5D6">
	                    <?
	                        $sql = "SELECT * FROM my4_messages WHERE private=0 AND who_id<>0 ORDER BY mtime DESC LIMIT 25";
	                        $rst = $db->sql_query ($sql) or die ("<p>$sql<p>".mysql_error());
	                        while ($line = $db->sql_fetchrow($rst)) {
                            	$who = preg_replace("/<\/?a[^>]*>/","",$line['who']);
                            	$whom = preg_replace("/<\/?a[^>]*>/","",$line['whom']);
                            	print "<br />".$who.$whom = $whom.$line[message];
	                        }
	                    ?>
                    </td></tr>
                </table>
            </td>
        </tr>


    </table>
<?

}

}
    $FEEDBACK_chat = "��������";
	include($_SERVER["DOCUMENT_ROOT"]."/include/footer.php");

?>