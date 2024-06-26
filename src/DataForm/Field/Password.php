<?php namespace Zofe\Rapyd\DataForm\Field;


class Password extends Field
{
    public $type = "password";

    public function build()
    {
        $output = "";

        if (parent::build() === false) return;

        switch ($this->status) {
            case "disabled":
            case "show":

                if ($this->type == 'hidden' || $this->value == "") {
                    $output = "";
                } elseif ((!isset($this->value))) {
                    $output = $this->layout['null_label'];
                } else {
                    $output = "********";
                }
                $output = "<div class='help-block'>" . $output . "&nbsp;</div>";
                break;

            case "create":
            case "modify":
                $output = html()->password($this->name)->attributes($this->attributes);
                break;

            case "hidden":
                $output = "";
                break;

            default:
        }
        $this->output = "\n" . $output . "\n" . $this->extra_output . "\n";
    }

}
