<?php namespace Zofe\Rapyd\DataForm\Field;


class Select extends Field
{

    public $type = "select";
    public $description = "";
    public $clause = "where";

    public function getValue()
    {
        parent::getValue();
        foreach ($this->options as $value => $description) {
            if ($this->value == $value) {
                $this->description = $description;
            }
        }
    }

    public function build()
    {
        $output = "";

        unset($this->attributes['type'], $this->attributes['size']);
        if (parent::build() === false)
            return;

        switch ($this->status) {
            case "disabled":
            case "show":
                if (!isset($this->value)) {
                    $output = $this->layout['null_label'];
                } else {
                    $output = $this->description;
                }
                $output = "<div class='help-block'>" . $output . "&nbsp;</div>";
                break;

            case "create":
            case "modify":
                $output = html()->select($this->name, $this->options, $this->value)->attributes($this->attributes) . $this->extra_output;
                break;

            case "hidden":
                $output = html()->hidden($this->name, $this->value);
                break;

            default:
        }
        $this->output = $output;
    }

}
