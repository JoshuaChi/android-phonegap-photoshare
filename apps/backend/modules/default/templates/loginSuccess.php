<form id='loginForm' class="box" method='post' action='<?php echo url_for("@login"); ?>'>
  <div data-role="fieldcontain">
      <label for="name">Username:</label>
      <input type="text" name="name" id="name" value=""  />
  </div>	
  
  <div data-role="fieldcontain">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" value="" />
  </div>	
	<div data-inline="true" class="ui-grid-a">
    <div class="ui-block-b"><button type="submit" data-theme="a" id="loginSubmit">Submit</button></div>
  </div>      
</form>