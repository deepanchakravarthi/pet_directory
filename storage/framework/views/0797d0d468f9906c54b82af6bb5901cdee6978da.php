<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: WELCOME ::</title>
<style>
body{
margin:0px;
padding:0px;
background:#f3f3f3;
font-family: Arial, Helvetica, sans-serif;
font-size:14px;
color:#aaaaaa;
margin-top:25px;
}
.padd{
padding-left:10px;
color:#032242;
}
a{
color:#1c9ac8;
text-decoration:none;
}
.fborder{
border:1px solid #e5e5e5;
background:#FFF;
border-radius:5px;
moz-border-radius:5px;
webkit-border-radius:5px;
padding:20px;
}
.content { color:#484848;}
.copy{
color:#fff;
}
</style>
</head>

	<body>
		<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" >
	  	 <tr bgcolor="#02acd8" >
    		<td width="168" height="50" align="center" valign="middle" class="padd" style="border-radius:5px 5px 0 0;">
			<?php echo e(SITE_NAME); ?>

			</td>
  		</tr>
  		<tr>
    		<td align="left" valign="middle"><table width="700" border="0" cellspacing="0" cellpadding="0" align="center" class="fborder">
 	    <tr>
    		<td height="35" valign="middle" class="content" style="padding:10px 0;"><?php echo e(trans('words.mail_hi')); ?> <?php echo e($name); ?>,<br><br>
			<?php echo e(trans('words.mail_sub_active')); ?>

			<br><br>
			<?php echo e(trans('words.mail_visit_link')); ?> <?php echo e(SITE_NAME); ?>.<br>
			<?php echo e(URL::to('index')); ?>

			<br><br>
			<?php echo e(trans('words.mail_team')); ?>, <?php echo e(SITE_NAME); ?>	</td>
	   </tr>
	  </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#02acd8" style="border-radius:0 0 5px 5px;"><table width="680" border="0" align="center" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="535" height="40" align="center" class="copy">&copy; <?php echo date("Y");?> <?php echo e(SITE_NAME); ?></td>
        </tr>
    </tbody></table></td>
  </tr>
</table>
			
</body>
</html>