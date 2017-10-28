<?php
namespace App\View\Widget;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\I18n\Time;
use Cake\View\Form\ContextInterface;
use DateTimeInterface;
use DateTimeZone;

class DateTimeWidget extends \CrudView\View\Widget\DateTimeWidget
{

    /**
     * Renders a date time widget.
     *
     * @param array $data Data to render with.
     * @param \Cake\View\Form\ContextInterface $context The current form context.
     * @return string A generated select box.
     * @throws \RuntimeException When option data is invalid.
     */
    public function render(array $data, ContextInterface $context)
    {
        $id = $data['id'];
        $name = $data['name'];
        $val = $data['val'];
        $type = $data['type'];
        $required = $data['required'] ? 'required' : '';
        $disabled = isset($data['disabled']) && $data['disabled'] ? 'disabled' : '';
        $role = isset($data['role']) ? $data['role'] : 'datetime-picker';
        $format = null;
        $locale = isset($data['locale']) ? $data['locale'] : I18n::locale();

        $timezoneAware = Configure::read('CrudView.timezoneAwareDateTimeWidget');

        $timestamp = null;
        $timezoneOffset = null;

        if (isset($data['data-format'])) {
            $format = $this->_convertPHPToMomentFormat($data['data-format']);
        }

        if (!($val instanceof DateTimeInterface) && !empty($val)) {
            if ($type === 'date') {
                $val = Time::parseDate($val);
            } elseif ($type === 'time') {
                $val = Time::parseTime($val);
            } else {
                $val = Time::parseDateTime($val);
            }
        }

        if ($val) {
            if ($timezoneAware) {
                $timestamp = $val->format('U');
                $dateTimeZone = new DateTimeZone(date_default_timezone_get());
                $timezoneOffset = ($dateTimeZone->getOffset($val) / 60);
            }
            $val = $val->format($type === 'date' ? 'Y-m-d' : 'Y-m-d H:i:s');
        }

        if (!$format) {
            if ($type === 'date') {
                $format = 'L';
            } elseif ($type === 'time') {
                $format = 'LT';
            } else {
                $format = 'L LT';
            }
        }

        $icon = $type === 'time'
            ? 'time'
            : 'calendar';

        $widget = <<<html
            <div class="input-group $type">
                <input
                    type="text"
                    class="form-control"
                    name="$name"
                    value="$val"
                    id="$id"
                    role="$role"
                    data-locale="$locale"
                    data-format="$format"
html;
        if ($timezoneAware && isset($timestamp, $timezoneOffset)) {
            $widget .= <<<html
                    data-timestamp="$timestamp"
                    data-timezone-offset="$timezoneOffset"
html;
        }
        $widget .= <<<html
                    $required
                    $disabled
                />
                <label for="$id" class="input-group-addon">
                    <span class="glyphicon glyphicon-$icon"></span>
                </label>
            </div>
html;

        return $widget;
    }
}
