<?php view('layouts/header'); ?>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-4 ">
                <div class="page-header text-uppercase d-flex justify-content-center">
                    <h2>Registration Form</h2>
                </div>
                <?php if (flashMessage()->get()): ?>
                    <div class="alert alert-danger">
                        <?php echo flashMessage()->get(); ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="/register">
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                               value="<?php echo input()->get('username'); ?>">
                   </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo input()->get('email'); ?>">
                    </div>
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
                        <button type="submit" class="btn btn-success mx-1 my-2">
                            Register
                        </button>
                        <button type="reset" class="btn btn-primary mx-1 my-2">
                            Reset
                        </button>
                        <a href='/' class='btn btn-secondary mx-1 my-2'>
                            Return
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php view('layouts/footer'); ?>