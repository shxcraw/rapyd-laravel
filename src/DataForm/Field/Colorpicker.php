<?php

namespace Zofe\Rapyd\DataForm\Field;

use Zofe\Rapyd\Rapyd;

class Colorpicker extends Field
{
    public $type = "colorpicker";
    public $rule = ['regex:/^#[A-Fa-f0-9]{6}$/'];

    public function build()
    {
        $output = "";

        if (parent::build() === false) return;

        switch ($this->status) {

            case "show":
                $output = $this->value;
                $output = "<div class='help-block' style='background-color:" . $output . "'>&nbsp;</div>";
                break;

            case "create":
            case "modify":
                Rapyd::css('colorpicker/css/bootstrap-colorpicker.min.css');
                Rapyd::js('colorpicker/js/bootstrap-colorpicker.min.js');
                $output = html()->text($this->name, $this->value)->attributes($this->attributes);
                $output .= Rapyd::script("
                        $('#" . $this->name . "').colorpicker({
                            format: 'hex'
                        });");

                break;
            case "hidden":
                $output = html()->hidden($this->name, $this->value);
                break;
            default:
        }
        $this->output = $output;
    }

}
