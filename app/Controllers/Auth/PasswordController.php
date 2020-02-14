<?php

namespace App\Controllers\Auth;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Core\Managers\FormValidator\FormValidator;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class PasswordController
{
    public function reset()
    {
        $users = database()->select('users', '*');
        return view('password_reset/index', ['users' => $users]);
    }

    public function token()
    {
        $date = Carbon::now();
        $interval = CarbonInterval::make('1hour');
        $laterThisDay = $date->add($interval)->format(DATE_ATOM);
        $token = generateNewString();

        database()->update(
            'users', [
            'token' => $token,
            'tokenExpire_at' => $laterThisDay,
        ], [
            "email" => $_POST['email']

        ]);

        require_once 'vendor/autoload.php';
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  //mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'd0ca269bd39eff';   //username
            $mail->Password = '0e97dd2dec24f5';   //password
            $mail->Port = 2525;                    //smtp port

            $mail->setFrom('noreply@' . config('app.name') . '.net', '' . config('app.name'));
            $mail->addAddress('' . $_POST['email']);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = "
	            Hi,<br><br>
	            
	            In order to reset your password, please click on the link below:<br>
	            <a href='/password_reset/$token
	            '>http://localhost:8000/password_reset/$token</a><br><br>
	            
	            Kind Regards,<br>
	            " . config('app.name') . " Team
	        ";

            if ($mail->send()) {
                echo "<alert>Please Check Your Email Inbox!</alert>";
            } else {
                echo "<alert>Something Wrong Just Happened! Please try again!</alert>";
            }
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }

    public function newPass(array $params)
    {
        $user = database()->select('users', '*',[
            "token"=>$params['token'],
        ]);
        return view('password_reset/index', ['user' => $user]);
    }

    public function update(array $params)
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
            return redirect('/password_reset/'.$params['token']);
        }

        require_once 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        $user = database()->select('users', '*',['token'=>$params['token']]);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  //mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'd0ca269bd39eff';   //username
            $mail->Password = '0e97dd2dec24f5';   //password
            $mail->Port = 2525;                    //smtp port

            $mail->setFrom('noreply@' . config('app.name') . '.net', '' . config('app.name'));
            $mail->addAddress('' . $user[0]['email'], ''.$user[0]['name']);

            $mail->isHTML(true);
            $mail->Subject = 'Password reset successful';
            $mail->Body = 'You have successfully changed your password!';

            if (!$mail->send()) {
                echo "<script>
                        alert('Please try again later.');
                        window.location.href='/';
                      </script>";
            } else {
                echo "<script>
                        alert('Password reset successful.');
                        window.location.href='/auth/login';
                      </script>";
            }

            database()->update(
                'users', [
                'password' => md5($_POST['password']),
                'token'=> null,
                'tokenExpire_at'=>null,
            ],[
                'token'=>$params['token'],
            ]);

        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }
}
