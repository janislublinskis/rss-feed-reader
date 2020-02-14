<?php use Carbon\Carbon;
use Carbon\CarbonInterval;

view('layouts/header');
;?>
<?php $url=str_replace('/password_reset/','',$_SERVER['REQUEST_URI']);?>
    <div class="container">
        <div class="row justify-content-center">
<?php if ($url==='/password_reset'): ?>
            <div class="col-md-6 col-md-offset-3" align="center">
                <img alt='APP logo' src="images/logo.png"><br><br>
                <div class="page-header text-uppercase d-flex justify-content-center">
                    <h2>Reset Password</h2>
                </div>
                <?php if (flashMessage()->get()): ?>
                    <div class="alert alert-danger">
                        <?php echo flashMessage()->get(); ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="/password_reset">
                    <!-- Email -->
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Your Email Address" value="<?php echo input()->get('email'); ?>">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success mx-1 my-2">
                            Reset password
                        </button>
                        <p id="response"></p>
                        <a href='/' class='btn btn-secondary mx-1 my-2'>
                            Return
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php else:?>
    <?php if($user[0]['tokenExpire_at'] > Carbon::now()->add(CarbonInterval::make('1s'))):?>
            <div class="col-md-4 ">
                <div class="page-header text-uppercase d-flex justify-content-center">
                    <h2>New Password</h2>
                </div>
                <?php if (flashMessage()->get()): ?>
                    <div class="alert alert-danger">
                        <?php echo flashMessage()->get(); ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="/password_reset/<?php echo $url?>">
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <!-- Confirm password -->
                    <div class="form-group">
                        <label for="confirm_password">Confirm password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <?php echo !empty(errors()->has('password')) ?
                            '<small class="form-text text-danger">' .
                            errors()->get('password') . '</small>' : "" ;
                        ?>
                    </div>
                    <div class="d-flex justify-content-center">
                        <!--Submit new password -->
                        <input type="hidden" name="_method" value="PUT"/>
                        <button type="submit" class="btn btn-success mx-1 my-2">
                            Submit
                        </button>
                        <!--Clear form -->
                        <button type="reset" class="btn btn-primary mx-1 my-2">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
    <?php else:?>
        <a href='/' class='btn btn-info mx-1 my-2'>
            Token you entered is no longer valid
        </a>
<?php endif; ?>
<?php endif; ?>
        </div>
    </div>
<?php view('layouts/footer'); ?>