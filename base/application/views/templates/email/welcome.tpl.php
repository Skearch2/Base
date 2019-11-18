<html>
<body>
	<h1><?php echo sprintf(lang('email_welcome_heading'), $identity); ?></h1>
	<p><?php echo sprintf(lang('email_welcome_subheading'), anchor('myskearch/auth/activate/' . $id . '/' . $activation, lang('email_activate_link'))); ?></p>
</body>
</html>
