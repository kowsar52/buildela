<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<?php include_once "includes/header.php";?>
    <div class="login-up-wrapper bg-white">
        <div class="login-up-wrapper-inner">
            <div class="container">
                <div class="row mx-auto justify-content-center">
                    <div class="col-md-6 pr-0">
                        <div class="login-form py-5">

                            <?php
                            if(isset($_GET['resetpsw']))
                            {
                            ?>

                                <div class="login-heading h2 py-2">Update Password</div>
                                <form id="setnewpass">

                                    <div class="form-group mb-3">
                                        <label for="pass1">Password</label>
                                        <input type="pass1" class="f-field-input-2 w-input" required id="pass1" placeholder="my.name@example.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="c_pass">Confirm Password</label>
                                        <input type="pass" class="f-field-input-2 w-input" required id="c_pass" placeholder="my.name@example.com">
                                    </div>
                                    <input type="hidden" name="" id="reset_Code" value="<?=$_GET['resetpsw']?>">
                                    <div class="btn-div-general pt-2 text-center">
                                        <button type="submit" class="f-button-neutral-3 w-button set_password_btn ">Update</button>
                                    </div>
                                </form>

                            <?php
				            }else{
					        ?>
                                <h1 class="login-heading h2 py-2">Recover Password</h1>
                                <form id="recoverPassword">
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="f-field-input-2 w-input" required id="email" placeholder="my.name@example.com">
                                    </div>
                                    <div class="btn-div-general pt-2 text-center">
                                        <button type="submit" class="f-button-neutral-3 w-button password_recover_btn">Recover</button>
                                    </div>
                                </form>
                            <?php
                            }
				            ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<style>
    .login-up-wrapper{
      min-height: calc(100vh - 436px);
    }
    .password_recover_btn,.set_password_btn{
      border-radius: 8px;
    }
	form#recoverPassword {
    padding: 15px 0px;
}
button.btn-bg-general.btn-block.text-white.text-center.px-5.py-2.text-decoration-none.font-weight-bold.rounded.password_recover_btn {
    color: #fff;
    padding: 10px 20px;
    margin-top: 20px;
}
input#email {
    border: solid 2px #696969;
    padding: 10px;

}
	</style>
<?php include_once "includes/footer-no-cta.php"?>