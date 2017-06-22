<?php

namespace Tohtamysh\Helper;

use Carbon\Carbon;
use File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Helper
{
    /**
     * Replace russian string to latin string
     * @param string $text Russian string
     * @param string $separator
     * @param string $space_separator
     * @return string
     */
    public function translit($text, $separator = '_', $space_separator = '_')
    {
        $array_replace = [
            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ё" => "E",
            "Ж" => "J",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "TS",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SCH",
            "Ъ" => $separator,
            "Ы" => "YI",
            "Ь" => $separator,
            "Э" => "E",
            "Ю" => "YU",
            "Я" => "YA",
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "e",
            "ж" => "j",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "y",
            "ы" => "yi",
            "ь" => $separator,
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
        ];

        foreach ($array_replace as $rus => $lat) {
            $text = mb_eregi_replace($rus, $lat, $text);
        }

        $text = preg_replace('/[^a-zA-Z0-9]/','', str_replace(' ', $space_separator, $text));

        return mb_strtolower($text);
    }


    /**
     * Return correct russian ending
     *
     * Example: ending(55, 'дом', 'дома', 'домов') return 'домов'
     *
     * @param int $count
     * @param string $one
     * @param string $two
     * @param string $five
     * @return string
     */
    public function ending($count, $one, $two, $five)
    {
        return ($count % 10 == 1 && $count % 100 != 11) ? $one : ($count % 10 >= 2 && $count % 10 <= 4 && ($count % 100 < 10 || $count % 100 >= 20) ? $two : $five);
    }


    /**
     * Get russian date
     * @param string $date
     * @param $param string
     * @param bool $title Convert output string case
     * @return bool|string
     */
    public function russianDate($date, $param, $title = false)
    {
        $date = Carbon::parse($date);

        $days_week = ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'];

        $days_week_mini = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

        $month = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

        $month_one = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];

        $month_mini = ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];

        if ($param == 'dayweek') {
            $out = $days_week[$date->format('w')];
        } elseif ($param == 'dayweekmini') {
            $out = $days_week_mini[$date->format('w')];
        } elseif ($param == 'month') {
            $out = $month[$date->format('n') - 1];
        } elseif ($param == 'monthone') {
            $out = $month_one[$date->format('n') - 1];
        } elseif ($param == 'monthmini') {
            $out = $month_mini[$date->format('n') - 1];
        } elseif ($param == 'current') {
            if ($date->isToday()) {
                $out = 'сегодня';
            } elseif ($date->isYesterday()) {
                $out = 'вчера';
            } else {
                $out = $date->format('j') . ' ' . $month[$date->format('n') - 1];
            }
        } else {
            return false;
        }

        return $title ? mb_convert_case($out, MB_CASE_TITLE, "UTF-8") : $out;
    }

    /**
     * Optimization image with Imagemagick without loss of quality.
     * Supported formats PNG and JPEG
     * @param string $filePath
     */
    public function optimizeImage($filePath)
    {
        $mymeType = File::mimeType($filePath);
        if ($mymeType === 'image/jpeg') {
            $command = '/usr/bin/convert ' . $filePath . ' -sampling-factor 4:2:0 -strip -quality 85 -interlace JPEG -colorspace RGB ' . $filePath;
        }
        if ($mymeType === 'image/png') {
            $command = '/usr/bin/convert ' . $filePath . ' -strip ' . $filePath;
        }
        if (isset($command)) {
            $process = new Process($command);
            $process->run();
        }
    }
}
