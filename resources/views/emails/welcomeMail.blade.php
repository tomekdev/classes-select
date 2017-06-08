<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		
		<style>
		
		body,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		.h1,
		.h2,
		.h3,
		.h4 {
		  font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;
		  font-weight: 300;
		}
		h5,
		h6 {
		  font-weight: 400;
		}
		a,
		a:hover,
		a:focus {
		  color: #009688;
		}
		.btn {
		  border: none;
		  border-radius: 2px;
		  position: relative;
		  padding: 8px 30px;
		  margin: 10px 1px;
		  font-size: 14px;
		  font-weight: 500;
		  text-transform: uppercase;
		  letter-spacing: 0;
		  will-change: box-shadow, transform;
		  -webkit-transition: -webkit-box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
			   -o-transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
				  transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
		  outline: 0;
		  cursor: pointer;
		  text-decoration: none;
		  background: transparent;
		}
		.btn::-moz-focus-inner,
		.input-group-btn .btn::-moz-focus-inner {
		  border: 0;
		}
		.btn.btn-raised.btn-primary{
		  background-color: #009688;
		  color: rgba(255,255,255, 0.84);
		}
		.btn.btn-raised:not(.btn-link) {
		  -webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
				  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
		}
		.btn.btn-raised:not(.btn-link):hover.btn-primary{
		  background-color: #00aa9a;
		}
		.btn.btn-raised:not(.btn-link):focus{
		  -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.18), 0 8px 16px rgba(0, 0, 0, 0.36);
				  box-shadow: 0 0 8px rgba(0, 0, 0, 0.18), 0 8px 16px rgba(0, 0, 0, 0.36);
		}
		.form-group {
		  padding-bottom: 7px;
		  margin: 28px 0 0 0;
		  text-align:justify;
		}
		.navbar {
		  background-color: #009688;
		  border: 0;
		  border-radius: 0;
		}
		.panel {
			text-align:center;
			max-width:500px;
			margin:auto;
		  -webkit-box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12), 0 1px 6px 0 rgba(0, 0, 0, 0.12);
				  box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12), 0 1px 6px 0 rgba(0, 0, 0, 0.12);
		}
		.panel.panel-primary > .panel-heading {
		  background-color: #009688;
		  color: rgba(255,255,255, 0.84); 
		}
		.panel-body {
		  background-color:white;
		  padding: 15px;
		  
		}
		.panel-heading {
		  padding: 5px 5px;
		  border-top-left-radius: 3px;
		  border-top-right-radius: 3px;
		}
		
		.frame{
			padding:30px;
		}
		</style>
		
	</head>
    <body style="background-color: #EEEEEE;">
	<div class="navbar">
				<a href="/"><img src="https://wu.po.opole.pl/wp-content/uploads/2014/07/logo-3-640x360.png" style="max-height:60px" /></a>
	</div>		
			<div class="frame">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2>Pierwsze kroki</h2>
					</div>
					<div class="panel-body">
						<form action="" method="post">
							<div class="form-group">
								<h5>Witaj {{$name}}!</h>
								<br>
								 <p>W systemie utworzono Twoje konto. Aby je aktywować wybierz poniższy przycisk.</p>
							</div>
								<a href="{{$url}}" class="btn btn-primary btn-raised">Rozpocznij</a>
						</form>
					</div>
				</div>
			</div>
    </body>
</html>