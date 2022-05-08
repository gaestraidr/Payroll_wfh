<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class CalendarHelper
{
    public static function isTodayHoliday()
    {
        return CalendarHelper::isHolidayDate(now());
    }

    public static function isHolidayDate($date)
    {
        $holiday_data = CalendarHelper::getHolidayData();

        foreach ($holiday_data->holidays as $holiday)
            if (date('d-m', strtotime($holiday->date)) == date('d-m', strtotime($date)))
                return true;

        return false;
    }

    public static function getSpecifiedHolidayData($date)
    {
        $holiday_data = CalendarHelper::getHolidayData();

        foreach ($holiday_data->holidays as $holiday)
            if (date('d-m', strtotime($holiday->date)) == date('d-m', strtotime($date)))
                return $holiday;

        return NULL;
    }

    public static function getHolidayData()
    {
        if (Storage::disk('public')->missing('holiday-calendar.json'))
            CalendarHelper::gatherOrUpdateHolidayData();

        return json_decode(Storage::disk('public')->get('holiday-calendar.json'));
    }

    public static function gatherOrUpdateHolidayData()
    {
        $client = new Client();
        $data = $client->request('GET', 'https://holidayapi.com/v1/holidays', [
            'query' => [
                'country' => 'ID',
                'year' => 2020,
                'public' => true,
                'language' => 'ID',
                'key' => '372c9ff0-e45a-40a9-88d8-d75b87361dc4'
            ]
        ])->getBody();

        Storage::disk('public')->put('holiday-calendar.json', $data);
    }
}
