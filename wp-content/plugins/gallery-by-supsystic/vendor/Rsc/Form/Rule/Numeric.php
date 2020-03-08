<?php


class Rsc_Form_Rule_Numeric implements Rsc_Form_Rule_Interface
{

    /**
     * @var string
     */
    public $label;

    /**
     * @var null
     */
    public $parameters;

    /**
     * @var string|null
     */
    public $message;

    /**
     * Constructor
     * @param string $label Field label
     * @param null $parameters Rule parameters
     */
    public function __construct($label, $parameters = null)
    {
        $this->label = $label;
        $this->parameters = $parameters;
    }

    /**
     * Validate specified field
     * @param mixed $field Field data
     * @return bool
     */
    public function validate($field)
    {
        return is_numeric($field);
    }

    /**
     * Returns rule error message
     * @return string
     */
    public function getMessage()
    {
        if ($this->message !== null) {
            return sprintf($this->message, $this->label);
        }

        return sprintf(__('The %s field must be a numeric'), $this->label);
    }

    /**
     * Set error message
     * @param string $message Error message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Creates the new instance
     * @param string $label Field label
     * @param null $parameters Rule parameters
     * @return Rsc_Form_Rule_Numeric
     */
    public static function create($label, $parameters)
    {
        return new self($label, $parameters);
    }
}