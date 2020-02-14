<?php view('layouts/header'); ?>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-4 ">
                <div class="page-header text-uppercase d-flex justify-content-center">
                    <h2>Login Page</h2>
                </div>
                <?php if (flashMessage()->get()): ?>
                    <div class="alert alert-danger">
                        <?php echo flashMessage()->get(); ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="/auth/login">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                               name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mx-1 my-2">
                            Sign In
                        </button>
                        <a href='/password_reset' class='btn btn-warning mx-1 my-2'>
                            Forgot password?
                        </a>
                        <a href='/' class='btn btn-secondary mx-1 my-2'>
                            Return
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php view('layouts/footer'); ?>