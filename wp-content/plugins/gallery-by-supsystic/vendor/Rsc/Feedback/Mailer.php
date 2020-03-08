<?php


class Rsc_Feedback_Mailer
{
    /**
     * @var array
     */
    private $emails;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $attachments;

    /**
     * @var string
     */
    private $pattern = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i';

    /**
     * Constructor
     *
     * @param array $emails The intended recipient(s). Multiple recipients may be specified using an array or a comma-separated string.
     * @param string $subject The subject of the message.
     * @param string $message Message content.
     * @param array $headers Mail headers to send with the message. For the string version, each header line (beginning with From:, Cc:, etc.) is delimited with a newline ("\r\n")
     * @param array $attachments Files to attach: a single filename, an array of filenames, or a newline-delimited string list of multiple filenames.
     */
    public function __construct(array $emails = array(), $subject = '', $message = '', array $headers = array(), array $attachments = array())
    {
        $this->emails = $this->setEmails($emails);
        $this->subject = $this->setSubject($subject);
        $this->message = $this->setMessage($message);
        $this->headers = $this->setHeaders($headers);
        $this->attachments = $this->setAttachments($attachments);
    }

    /**
     * Send the email
     *
     * @return bool
     */
    public function send()
    {
        return wp_mail($this->emails, $this->subject, $this->message, $this->headers, $this->attachments);
    }

    /**
     * Sets the headers
     *
     * @param array $headers
     * @throws InvalidArgumentException If the headers is not an array or not a string
     * @return Rsc_Feedback_Mailer
     */
    public function setHeaders(array $headers)
    {
        if (!is_array($headers)) {
            throw new InvalidArgumentException(sprintf(__('The headers must be an array, %s given', 'rsc-framework'), gettype($headers)));
        }

        $this->headers = $headers;

        return $this;
    }

    /**
     * Adds the header
     *
     * @param string $key Header key (from, cc, bcc, etc.)
     * @param string $value Header value
     */
    public function addHeader($key, $value)
    {
        $this->headers[] = sprintf('%s: %s', ucfirst($key), $value);
    }

    /**
     * Sets the attachments
     *
     * @param array $attachments
     * @return Rsc_Feedback_Mailer
     * @throws InvalidArgumentException If the attachments is not an array or not a string
     */
    public function setAttachments(array $attachments)
    {
        if (!is_array($attachments)) {
            throw new InvalidArgumentException(sprintf(__('The attachments must be an array, %s given', 'rsc-framework'), gettype($attachments)));
        }

        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Adds the attachment
     *
     * @param string|object $attachment Path to the attachment
     * @throws InvalidArgumentException
     */
    public function addAttachment($attachment)
    {
        if (is_object($attachment) && !method_exists($attachment, '__toString')) {
            throw new InvalidArgumentException(__('The object must implement __toString method', 'rsc-framework'));
        }

        $this->attachments[] = $attachment;
    }

    /**
     * Sets the emails
     *
     * @param array $emails
     * @throws LogicException
     * @throws InvalidArgumentException
     * @return Rsc_Feedback_Mailer
     */
    public function setEmails(array $emails)
    {
        $this->emails = array();

        if (!is_array($emails)) {
            throw new InvalidArgumentException(sprintf(__('The emails must be an array, %s given'), gettype($emails)));
        }

        if (empty($emails)) {
            throw new LogicException(__('Expected array of email addresses, but given an empty array'), 'rsc-framework');
        }

        foreach ($emails as $email) {
            if (!preg_match($this->pattern, $email)) {
                throw new InvalidArgumentException(sprintf(__('The email address "%s" is not comply with the RFC2822', 'rsc-framework'), $email));
            }

            $this->emails[] = $email;
        }

        return $this;
    }

    /**
     * Returns the emails
     *
     * @return array
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Checks whether the specific email address is in mailing list
     *
     * @param string $email
     * @return bool
     */
    public function hasEmail($email)
    {
        if (empty($this->emails)) {
            return false;
        }

        if (false !== $emails = array_flip($this->emails)) {
           return isset($emails[$email]);
        }

        return false;
    }

    /**
     * Sets the message
     *
     * @param string $message
     * @return Rsc_Feedback_Mailer
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Returns the message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the subject
     *
     * @param string $subject
     * @return Rsc_Feedback_Mailer
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Returns the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}