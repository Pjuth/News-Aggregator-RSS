<?php

namespace App\Http\Controllers;

use App\Feed;
use DateTime;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function index()
    {
        $feeds = Feed::all();
        $storage = Storage::disk('local');

        $result = [];

        foreach ($feeds as $feed) {
            $name = $feed->name . '-' . $feed->category . '.xml';
            $content = $storage->get($name);
            $xml = new SimpleXmlElement($content);
            foreach ($xml->channel->item as $entry) {
                $date = self::getDate("$entry->pubDate");
                $items = [
                    'title'       => "$entry->title",
                    'link'        => "$entry->link",
                    'description' => str_replace('Skaitykite daugiau...', '', strip_tags("$entry->description")),
                    'pubDate'     => $date,
                    'category'    => $feed->category,
                ];
                array_push($result, $items);
            }
        }

        return json_encode($result);
    }

    private static function getDate($date)
    {
        $date1 = new DateTime();
        $date2 = new DateTime($date);
        $min = $date1->diff($date2)->i + $date1->diff($date2)->h * 60 + $date1->diff($date2)->d * 1440;

        return $min;
    }
}
