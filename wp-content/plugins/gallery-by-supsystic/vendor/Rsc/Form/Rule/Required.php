<?php


class Rsc_Form_Rule_Required implements Rsc_Form_Rule_Interface
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
     * @var string
     */
    public $message;

    /**
     * Constructor
     * @param string $label Field label
     * @param null $parameters An array of parameters
     */
    public function __construct($label, $parameters = null)
    {
        $this->label = $label;
        $this->parameters = $parameters;
    }

    /**
     * Validate field data
     * @param mixed $field Field data
     * @return bool TRUE if field is valid, FALSE otherwise
     */
    public function validate($field)
    {
        if (is_array($field)) {
            return (count($field) >= 1);
        }

        if (extension_loaded('mbstring')) {
            return (mb_strlen(trim($field), strtoupper(get_bloginfo('charset'))) >= 1);
        }

        return (strlen(trim($field)) >= 1);
    }

    /**
     * Returns error message
     * @return string
     */
    public function getMessage()
    {
        if ($this->message !== null) {
            return sprintf($this->message, $this->label);
        }

        return sprintf(__('The %s field cannot be empty', 'rsc-framework'), $this->label);
    }

    /**
     * Set error message
     * @param string $message Error message
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;
    }

    /**
     * Creates the new instance of the rule for chaining
     * <code>
     *      Rsc_Form_Rule_Required::create('Control label', $params)->setMessage('The field %s is required');
     * </code>
     * @param string $label Field label
     * @param null $parameters An array of parameters
     * @return Rsc_Form_Rule_Required
     */
    public static function create($label, $parameters = null)
    {
        return new self($label, $parameters);
    }
} 