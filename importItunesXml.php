<?php

// Use Zend_Loader from here on in
require_once ('application/global.php');
Zend_Loader::loadClass('ItunesTrack');

$libraryFile = 'iTunes Music Library.xml';

$keyMap = array(
    'Track ID'      => 'trackId',
    'Name'          => 'name',
    'Artist'        => 'artist',
    'Album Artist'  => 'albumArtist',
    'Album'         => 'album',
    'Genre'         => 'genre',
    'Kind'          => 'kind',
    'Size'          => 'size',
    'Total Time'    => 'totalTime',
    'Track Number'  => 'trackNumber',
    'Track Count'   => 'trackCount',
    'Disc Number'   => 'discNumber',
    'Disc Count'    => 'discCount',
    'Year'          => 'year',
    'Date Modified' => 'dateModified',
    'Date Added'    => 'dateAdded',
    'Bit Rate'      => 'bitRate',
    'Sample Rate'   => 'sampleRate',
    'Comments'      => 'comments',
    'Play Count'    => 'playCount',
    'Play Date'     => 'playDate',
    'Play Date UTC' => 'playDateUtc',
    'Persistent ID' => 'persistentId',
    'Track Type'    => 'trackType',
    'Location'      => 'location',
);


$table = new ItunesTrack();

// delete all current rows
echo "deleting existing data... ";
$table->delete('1 = 1');
echo "done\n";

echo "processing xml...\n";
$track = $table->createRow();

$depth = 0;
$elements = array();

$inTracks       = FALSE;
$inTrack        = FALSE;
$inElement      = FALSE;
$tracksDepth    = -1;
$leftTracks     = 0;
$prevData        = '';

function startElement($parser, $name, $attrs)
{
    global $depth, $elements, $tracksDepth;

    //echo "startElement $depth $name\n";
    $elements[$depth++] = $name;
}

function endElement($parser, $name)
{
    global $depth, $elements, $tracksDepth, $leftTracks, $inTracks;

    if ($depth == $tracksDepth && $leftTracks++ == 1) {
        echo "\nLeaving Tracks\n";
        $inTracks = !$inTracks;
    }

    $depth--;
}

function tagContent($parser, $data) {
    global $depth, $elements, $tracksDepth, $inTracks, $inTrack, $prevData, $keyMap, $table, $track;

    $data = trim($data);
    $curDepth = $depth - 1;
    $curElement = $elements[$curDepth];

    if (strlen($data)) {
        //echo "tagContent $curDepth $curElement:$data:\n";

        if ($data == 'Tracks') {
            $inTracks = !$inTracks;
            $tracksDepth = $depth;
            echo "Entering Tracks\n";
        }

        if ($inTracks) {

            if ($data == 'Track ID') {
                //echo "New Track ($prevData)\n";

                if (!$inTrack) {
                    $inTrack = !$inTrack;
                }
                elseif (isset($track->trackId)) {
                    //print_r($track);
                    $track->save();
                    echo "+";
                    flush();
                    $track = $table->createRow();
                }

                $track = $table->createRow();
            }

            if ($inTrack) {
                if (isset($keyMap[$prevData])) {
                    $prop = $keyMap[$prevData];
                    $type = strToLower($curElement);

                    //echo ">> trackData $prop:$type:$data:\n";

                    switch ($type) {
                        case 'integer':
                            $value = (int) $data;
                            break;
                        case 'string':
                            $value = (string) $data;
                            break;
                        case 'date':
                            $value = (string) $data;
                            break;
                        default:
                            break;
                    }

                    if ($prop == 'location')
                        $value = str_replace('file://localhost/Volumes/music/', '', $value);

                    if (isset($track->$prop))
                        $track->$prop = $value;
                }
            }
        }
        $prevData = $data;
    }
}

$xml_parser = xml_parser_create();

xml_set_element_handler($xml_parser, 'startElement', 'endElement');
xml_set_character_data_handler($xml_parser, 'tagContent');

if (!($fp = fopen($libraryFile, "r"))) {
    die("could not open XML input");
}

while ($data = fread($fp, 4096)) {
    if (!xml_parse($xml_parser, $data, feof($fp))) {
        die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}
xml_parser_free($xml_parser);


echo " done\n";
