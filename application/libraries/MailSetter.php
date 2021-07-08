<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dotenv\Dotenv;

class MailSetter
{
    public function set($mailer)
    {
        $dotenv = Dotenv::createImmutable(FCPATH);
        $dotenv->load();

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

        if ($_ENV['mail_smtp']) {
            $mailer->isSMTP();
        }

        $mailer->Host = $_ENV['mail_host'];
        $mailer->SMTPAuth = $_ENV['mail_auth'];
        $mailer->Username = $_ENV['mail_username'];
        $mailer->Password = $_ENV['mail_password'];
        $mailer->SMTPSecure = $_ENV['mail_secure'];
        $mailer->Port = $_ENV['mail_port'];

		return $mailer;
    }
}
