<?php

namespace App\Controllers;

use Core\Managers\FormValidator\FormValidator;
use Carbon\Carbon;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class RegistrationController
{

    public function create()
    {
        return view('register/index');
    }

    public function store()
    {

        $validator = FormValidator::get();
        $validator->validate($_POST, ['password' => [
            'required',
            'min:6',
            'max:20',
            'upper:/[A-Z]/',
            'char:#[^a-z0-9]+#i',
            'match:'.$_POST['confirm_password'].'',
        ]]);

        if ($validator->failed()) {
            input()->save($_POST);
            return redirect('/register');
        }

        database()->insert(
            'users', [
                'name' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password']),
                'created_at' => Carbon::now()->format(DATE_ATOM),
            ]
        );
        require_once 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  //mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'd0ca269bd39eff';   //username
            $mail->Password = '0e97dd2dec24f5';   //password
            $mail->Port = 2525;                    //smtp port

            $mail->setFrom('noreply@' . config('app.name') . '.net', '' . config('app.name'));
            $mail->addAddress('' . $_POST['email'], '' . $_POST['username']);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to ' . config('app.name');
            $mail->Body = 'Welcome, ' . $_POST['username'] . '!';

            if (!$mail->send()) {
                echo "<script>
                        alert('Please try again later.');
                        window.location.href='/';
                      </script>";
            } else {
                echo "<script>
                        alert('Registration successful.');
                        window.location.href='/auth/login';
                      </script>";
            }

        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }

}