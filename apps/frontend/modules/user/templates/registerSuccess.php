<form id='registerForm' class="loginbox" method='post' action='<?php echo url_for("user/register"); ?>'>
	<h3>Register for PicStorms</h3>
  <div data-role="fieldcontain">
      <label for="registerName">Username*</label>
      <input type="text" name="registerName" id="registerName" />
  </div>	
  
  <div data-role="fieldcontain">
      <label for="registerPassword">Password*</label>
      <input type="text" name="registerPassword" id="registerPassword" />
  </div>
  	
  <div data-role="fieldcontain">
      <label for="registerEmail">Email</label>
      <input type="email" name="registerEmail" id="registerEmail" />
  </div>
	<div data-inline="true" class="ui-grid-a">
   <div class="ui-block-b"><button type="submit" data-theme="a" id="registerSubmit">Submit</button></div>
  </div>      
</form>