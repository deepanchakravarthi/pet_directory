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
			{{ trans('words.mail_reg_header') }}
			</td>
  		</tr>
  		<tr>
    		<td align="left" valign="middle"><table width="700" border="0" cellspacing="0" cellpadding="0" align="center" class="fborder">
 	    <tr>
    		<td height="35" valign="middle" class="content" style="padding:10px 0;">{{ trans('words.mail_hi') }} {{ $name }},<br><br>

			{{ trans('words.thank_for_reg') }} {{ SITE_NAME }}.
			<br><br>
			@if(isset($customtext) && $customtext != '')
			{{ $customtext }}<br><br>
			@endif
			<strong>{{ trans('words.email') }}:</strong> {{ $email }}<br>
			<strong>{{ trans('words.password') }}:</strong> {{ $password }}
			<br><br>
			{{ trans('words.mail_visit_link') }} {{ SITE_NAME }}.<br>
			{{ URL::to('index') }}
			<!--Before you can login, you first need to active your account.  To do so, please follow this link:
			<br>
			{{ URL::to('confirm', array($id)) }}-->
			<br><br>
			{{ trans('words.mail_team') }}, {{ SITE_NAME }}	</td>
	   </tr>
	  </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#02acd8" style="border-radius:0 0 5px 5px;"><table width="680" border="0" align="center" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="535" height="40" align="center" class="copy">&copy; <?php echo date("Y");?> {{ SITE_NAME }}</td>
        </tr>
    </tbody></table></td>
  </tr>
</table>
			
</body>
</html>