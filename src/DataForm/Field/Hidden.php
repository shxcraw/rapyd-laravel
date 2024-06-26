<?php namespace Zofe\Rapyd\DataForm\Field;


class Hidden extends Field
{
    public $type = "hidden";

    public function build()
    {
        $output = "";

        if (parent::build() === false) return;

        switch ($this->status) {
            case "disabled":
            case "show":
                break;

            case "create":
            case "modify":
            case "hidden":
                $output = html()->hidden($this->name, $this->value);
                break;

            default:
        }
        $this->output = "\n" . $output . "\n" . $this->extra_output . "\n";
    }

}
