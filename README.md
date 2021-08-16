# Pinciuc v2 ZF

My personal website built with Zend Framework and using my XSLT Zend_View
templating engine. Circa 2005-2008. This was definitely a work in progress at
rewriting my original custom PHP website in Zend Framework so there is plenty
of commented code and some unfinished classes and other files.

No ORM, though it looks like I started to work on implementing `Zend_Db`.
Instead I used a custom ODBC Db class and CRUD functions with SQL queries in
the models (ah, the good old days). Used the Flickr REST API to pull and
cache gallery and photo information. Used Blogger RSS feeds to pull and
cache data for a couple of blogs.

Some code to track my Photography gear, including lenses.

My music collection was always a big part of my website, and I include code
that allowed me to display all of the artists, albums, tracks and cover art in
various ways, alont with playback statistics whcih were kept in the database.
I display the ID3 tags from the music files, and was able to log into the
original site (thought I don't believe I implemented this here yet) to stream
my music collection at various selectable bitrates, which I did quite often
while working :)

A custom PHP script to read and import data from an iTunes Music Library XML
files to populate the music library section of the site.

I experimented with expanding this to my DVD collection, which I would rip and
add to the site. I setup a video streaming server and could stream movies in
MP4 format using rtsp.

I also provide an API backend for a Flash game that I wrote (*Flashteroids*, a
Flash version of the arcade classic *Asteroids*) to track high scores.
