<?php

namespace App\Http\Controllers;

use App\Feed;
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
                $items = [
                    'title'       => "$entry->title",
                    'link'        => "$entry->link",
                    'description' => str_replace('Skaitykite daugiau...', '', strip_tags("$entry->description")),
                    'pubDate'     => "$entry->pubDate",
                    'thumbnail'   => $entry->media->thumbnail,
                ];
                array_push($result, $items);
            }
        }

        return $result;
    }
}
