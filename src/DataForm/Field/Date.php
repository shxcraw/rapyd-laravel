<?php

namespace Zofe\Rapyd\DataForm\Field;

use Zofe\Rapyd\Rapyd;

class Date extends Field
{
    public $type = "date";
    public $format = 'm/d/Y';
    public $language = 'en';
    public $clause = "where";


    public function __construct($name, $label, &$model = null, &$model_relations = null)
    {
        parent::__construct($name, $label, $model, $model_relations);
        $this->language = config('app.locale', $this->language);
        $this->format = config('rapyd.fields.date.format', $this->format);
    }

    /**
     * overwrite new value to store a iso date
     */
    public function getNewValue()
    {
        parent::getNewValue();
        $this->new_value = $this->humanDateToIso($this->new_value);
    }

    /**
     * convert from current user format to iso date
     */
    protected function humanDateToIso($humandate)
    {
        $datetime = \DateTime::createFromFormat($this->format, $humandate);
        if (!$datetime) return null;

        $humandate = $datetime->format('Y-m-d');
        return $humandate;
    }

    /**
     * set instarnal preview date format
     * @param $format valid php date format
     * @param string $language valid DatePicker language string http://bootstrap-datepicker.readthedocs.org/en/release/options.html#language
     */
    public function format($format, $language = 'en')
    {
        $this->format = $format;
        $this->language = $language;

        return $this;
    }

    public function build()
    {
        $output = "";

        unset($this->attributes['type']);
        if (parent::build() === false) return;

        switch ($this->status) {

            case "show":
                if (!isset($this->value)) {
                    $value = $this->layout['null_label'];
                } else {
                    $value = $this->isoDateToHuman($this->value);
                }
                $output = $value;
                $output = "<div class='help-block'>" . $output . "&nbsp;</div>";
                break;

            case "create":
            case "modify":
                if ($this->value != "") {
                    if (!$this->is_refill) {
                        $this->value = $this->isoDateToHuman($this->value);
                    }
                }

                Rapyd::css('datepicker/datepicker3.css');
                Rapyd::js('datepicker/bootstrap-datepicker.js');
                if ($this->language != "en") {
                    Rapyd::js('datepicker/locales/bootstrap-datepicker.' . $this->language . '.js');
                }

                $output = html()->text($this->name, $this->value)->attributes($this->attributes);
                Rapyd::script("
                        $('#" . $this->name . "').datepicker({
                            format: '{$this->formatToDate()}',
                            language: '{$this->language}',
                            todayBtn: 'linked',
                            autoclose: true
                        });");

                break;
            case "hidden":
                $output = html()->hidden($this->db_name, $this->value);
                break;
            default:
        }
        $this->output = $output;
    }

    /**
     * convert from iso date to user format
     * fix empty value and remove H:i:s
     */
    protected function isoDateToHuman($isodate)
    {
        $isodate = str_replace(" 00:00:00", "", $isodate);
        $datetime = \DateTime::createFromFormat('Y-m-d', $isodate);
        if (!$datetime || $isodate == '0000-00-00') return '';

        $isodate = $datetime->format($this->format);
        return $isodate;
    }

    /**
     * simple translation from php date format to DatePicker format
     * only basic translation of numeric timestamps m/d/Y, d/m/Y, ...
     * @param $format valid php date format http://www.php.net/manual/it/function.date.php
     * @return string valid datepicker format http://bootstrap-datepicker.readthedocs.org/en/release/options.html#format
     */
    protected function formatToDate()
    {
        $format = $this->format;
        $format = str_replace(array('d', 'm', 'Y'),
            array('dd', 'mm', 'yyyy'),
            $format
        );

        return $format;

        /* todo (non zero-filled, and names for days and months)
        d, dd: Numeric date, no leading zero and leading zero, respectively. Eg, 5, 05.
        D, DD: Abbreviated and full weekday names, respectively. Eg, Mon, Monday.
        m, mm: Numeric month, no leading zero and leading zero, respectively. Eg, 7, 07.
        M, MM: Abbreviated and full month names, respectively. Eg, Jan, January
        yy, yyyy: 2- and 4-digit years, respectively. Eg, 12, 2012.
        */
    }

}
