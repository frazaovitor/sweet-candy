<?php

/**
 * Class Rsc_Feedback_SupportMailer
 * @package Rsc\Feedback
 */
class Rsc_Feedback_SupportMailer
{
    /**
     * @var Rsc_Feedback_Mailer
     */
    private $mailer;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Constructor
     *
     * @param Rsc_Feedback_Mailer $mailer
     * @param string $subject
     * @param string $message
     * @param array $parameters
     */
    public function __construct(Rsc_Feedback_Mailer $mailer = null, $subject = '', $message = '', array $parameters = array())
    {
        $this->mailer = (is_null($mailer) ? new Rsc_Feedback_Mailer() : $mailer);

        $this->mailer->setSubject($subject);
        $this->mailer->setMessage($message);

        $this->parameters = $parameters;
    }

    /**
     * Sets the message
     *
     * @param string $message
     * @return Rsc_Feedback_SupportMailer
     */
    public function setMessage($message)
    {
        $this->mailer->setMessage($message);

        return $this;
    }

    /**
     * Sets the subject
     *
     * @param string $subject
     * @return Rsc_Feedback_SupportMailer
     */
    public function setSubject($subject)
    {
        $this->mailer->setSubject($subject);

        return $this;
    }

    /**
     * Sets the parameters
     *
     * @param array $parameters
     * @return Rsc_Feedback_SupportMailer
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Adds the parameter
     *
     * @param string $name
     * @param string $value
     */
    public function addParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Sends the message
     *
     * @throws InvalidArgumentException
     * @return bool
     */
    public function send()
    {
        return $this->mailer->send();
    }

    protected function parametersToString()
    {
        if (empty($this->parameters)) {
            return null;
        }

        $parameters = '';

        foreach ($this->parameters as $name => $value) {
            $parameters .= str_replace('_', ' ', $this->escape($name));
            $parameters .= $this->escape($value) . PHP_EOL;
        }

        return $parameters;
    }

    protected function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, get_bloginfo('charset'));
    }
}