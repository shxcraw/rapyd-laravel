<?php

namespace Zofe\Rapyd\DataForm\Field;

// Mapping to HTML5 Input type
// http://www.w3.org/TR/html-markup/input.number.html
class Number extends Field
{
    public $type = "number";
    public $clause = "where";
    public $rule = ["integer"];

    public function build()
    {
        $output = "";

        if (parent::build() === false) {
            return;
        }

        switch ($this->status) {
            case "disabled":
            case "show":

                if ($this->type == 'hidden' || $this->value == "") {
                    $output = "";
                } elseif ((!isset($this->value))) {
                    $output = $this->layout['null_label'];
                } else {
                    $output = $this->value;
                }
                $output = "<div class='help-block'>" . $output . "&nbsp;</div>";
                break;

            case "create":
            case "modify":
                $output = html()->number($this->name, $this->value)->attributes($this->attributes);
                break;

            case "hidden":
                $output = html()->hidden($this->name, $this->value);
                break;

            default:
        }
        $this->output = "\n" . $output . "\n" . $this->extra_output . "\n";
    }

}
