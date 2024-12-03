<?php

namespace app\services\email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

abstract class EmailTemplate
{
    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->configure();
    }

    public function sendEmail(string $recipientEmail, array $data): void
    {
        try {
            $this->prepareEmail($recipientEmail, $data);
            $this->mail->send();
        } catch (Exception $e) {
            throw new \Exception("Erro ao enviar e-mail: {$this->mail->ErrorInfo}");
        }
    }

    protected function configure(): void
    {
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = '23f55dc1000d65';
        $this->mail->Password = '381dab61129c4b';
    }

    protected function prepareEmail(string $recipientEmail, array $data): void
    {
        $this->mail->setFrom('no-reply@mundopet.com', 'MundoPet');
        $this->mail->addAddress($recipientEmail);

        $this->mail->isHTML(true);
        $this->mail->Subject = $this->getSubject($data);
        $this->mail->Body = $this->getBody($data);
    }

    abstract protected function getSubject(array $data): string;

    abstract protected function getBody(array $data): string;
}
