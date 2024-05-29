<?php

namespace Zofe\Rapyd\DataForm\Field;

class Numberrange extends Number
{
    public $type = "numberrange";
    public $multiple = true;
    public $clause = "wherebetween";

    public function getValue()
    {
        parent::getValue();
        $this->values = explode($this->serialization_sep, $this->value);
    }

    public function build()
    {
        $output = "";

        if (Field::build() === false) {
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

                $lower = html()->number($this->name . '[from]', @$this->values[0])->attributes($this->attributes);
                $upper = html()->number($this->name . '[to]', @$this->values[1])->attributes($this->attributes);

                $output = '
                            <div id="range_' . $this->name . '_container">
                                   <div class="input-group">
                                       <div class="input-group-addon">&ge;</div>
                                       ' . $lower . '
                                   </div>
                                   <div class="input-group">
                                        <div class="input-group-addon">&le;</div>
                                        ' . $upper . '
                                   </div>
                            </div>';
                break;

            case "hidden":
                $output = html()->hidden($this->name, $this->value);
                break;

            default:
        }
        $this->output = "\n" . $output . "\n" . $this->extra_output . "\n";
    }

}
