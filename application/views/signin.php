<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sigin</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="container">
  		<div class="row"  style="height: 150px;">
  			<div class="col-md-6 col-md-offset-3">
  				<?php echo validation_errors('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;', '</div>'); ?>
  			</div>
  		</div>
	    <div class="row"> 
	    	<div class="col-md-4 col-md-offset-4">
			    <div class="panel panel-default">
            <div class="panel-body">
    					<?php echo form_open('signin/auth'); ?>
      					<div class="form-group">
      						<?php echo form_input('user', null, array('class' => 'form-control', 'placeholder' => 'User')); ?>
      					</div>
      					<div class="form-group">
      						<?php echo form_password('pass', null,  array('class' => 'form-control', 'placeholder' => 'Password')); ?>
      					</div>
      					<button type="submit" class="btn btn-primary pull-right">Ingresar</button>
              </form>
            </div>
          </div>
		    </div>
	    </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>