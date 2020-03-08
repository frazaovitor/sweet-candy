<?php


class Rsc_Form_Rule_Regex implements Rsc_Form_Rule_Interface
{

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $parameters;

    /**
     * @var string
     */
    public $message;

    /**
     * Constructor
     * @param string $label Field label
     * @param string $parameters Rule parameters
     * @throws InvalidArgumentException
     */
    function __construct($label, $parameters = null)
    {
        $this->label = $label;

        if (!is_string($parameters)) {
            throw new InvalidArgumentException(sprintf('Parameter of form rule Regex must be a string, %s given', gettype($parameters)));
        }

        $this->parameters = $parameters;
    }

    /**
     * Validate specified field
     * @param mixed $field Field data
     * @return bool
     */
    function validate($field)
    {
        return (preg_match($this->parameters, $field));
    }

    /**
     * Returns rule error message
     * @return string
     */
    function getMessage()
    {
        if ($this->message !== null) {
            return sprintf($this->message, $this->label);
        }

        return sprintf(__('The %s field does not match with regex', 'rsc-framework'), $this->label);
    }

    /**
     * Sets the error message
     * @param string $message Error message
     * @return Rsc_Form_Rule_Regex
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Creates the new instance
     * @param string $label Field label
     * @param string $parameters Rule parameters
     * @return Rsc_Form_Rule_Regex
     */
    public static function create($label, $parameters)
    {
        return new self($label, $parameters);
    }
}