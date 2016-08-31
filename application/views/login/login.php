
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php $this->load->view('include/header'); ?>
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }
        </style>
    </head>

    <body>
        <div class="container">

            <form action="" method="post" accept-charset="utf-8" class="form-signin" name="login" id="login">            
                <!-- center><img src="http://192.168.254.201/phpzon_medicina/public/img/144.jpg" class="img-circle"></center -->

	  <?php print $this->session->flashdata('erroLogin'); ?>
                <div class="control-group  success">

                    <label for="inputError">Login</label>
                    <input type="text" class="input-xlarge" name="username" value="" placeholder="nome@email.com"  />            
                </div>
                <div class="control-group  success">
                    <label for="inputError">Senha</label>
                    <input type="password"class="input-xlarge"  name="password" value="" placeholder="Senha"  />            
                </div>

                <input type="submit" name="" value="Entrar" class="btn btn-success"  />
                <!-- input type="button" name="" value="Google" onclick="window.location='<?php #print site_url('login/loginGoogle/?voltar=' . site_url()); ?>'" class="btn btn-danger"  / -->


            </form>


        </div> <!-- /container -->

	<?php print $this->load->view('include/javascript'); ?>

    </body>
</html>
