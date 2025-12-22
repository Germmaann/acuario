<?php
/**
 * Mailer simple con soporte SMTP básico (AUTH LOGIN) y envío directo
 * Nota: Implementación mínima. Para entornos productivos se recomienda PHPMailer.
 */
class Mailer {
    private string $host;
    private int $port;
    private string $user;
    private string $pass;
    private string $from;
    private string $fromName;
    private string $secure; // '' | 'ssl'

    public function __construct() {
        $this->host = MAIL_SMTP_HOST;
        $this->port = (int)MAIL_SMTP_PORT;
        $this->user = MAIL_SMTP_USER;
        $this->pass = MAIL_SMTP_PASS;
        $this->from = MAIL_FROM;
        $this->fromName = MAIL_FROM_NAME;
        $this->secure = MAIL_SMTP_SECURE === 'ssl' ? 'ssl' : '';
    }

    /**
     * Enviar correo de texto plano. Retorna true/false.
     */
    public function send(string $to, string $subject, string $body): bool {
        // Si no hay host definido, intentar mail() nativo
        if (empty($this->host)) {
            return $this->sendNative($to, $subject, $body);
        }
        return $this->sendSmtp($to, $subject, $body);
    }

    private function sendNative(string $to, string $subject, string $body): bool {
        $headers = [];
        $headers[] = 'From: ' . $this->formatAddress($this->from, $this->fromName);
        $headers[] = 'Reply-To: ' . $this->from;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/plain; charset=UTF-8';
        return mail($to, $subject, $body, implode("\r\n", $headers));
    }

    private function sendSmtp(string $to, string $subject, string $body): bool {
        $host = $this->secure === 'ssl' ? 'ssl://' . $this->host : $this->host;
        $fp = @fsockopen($host, $this->port, $errno, $errstr, 10);
        if (!$fp) {
            return false;
        }

        $read = function() use ($fp) {
            return fgets($fp, 515);
        };
        $write = function($data) use ($fp) {
            fwrite($fp, $data . "\r\n");
        };

        $read(); // banner
        $write('EHLO acuario.local');
        $read();

        if (!empty($this->user)) {
            $write('AUTH LOGIN');
            $read();
            $write(base64_encode($this->user));
            $read();
            $write(base64_encode($this->pass));
            $read();
        }

        $write('MAIL FROM: <' . $this->from . '>');
        $read();
        $write('RCPT TO: <' . $to . '>');
        $read();
        $write('DATA');
        $read();

        $headers = [];
        $headers[] = 'From: ' . $this->formatAddress($this->from, $this->fromName);
        $headers[] = 'To: ' . $to;
        $headers[] = 'Subject: ' . $subject;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/plain; charset=UTF-8';

        $message = implode("\r\n", $headers) . "\r\n\r\n" . $body . "\r\n.";
        $write($message);
        $read();

        $write('QUIT');
        fclose($fp);
        return true;
    }

    private function formatAddress(string $email, string $name): string {
        return sprintf('"%s" <%s>', addslashes($name), $email);
    }
}
