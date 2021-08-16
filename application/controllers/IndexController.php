<?php
/** BaseController */
Zend_Loader::loadClass('BaseController');

class IndexController extends BaseController
{

    public function indexAction()
    {
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_Query');
        Zend_Loader::loadClass('Zend_Cache');

        Zend_Loader::loadClass('Gallery');

        $gdClient   = new Zend_Gdata();

        $cacheName = 'myBloggerBlogConduit';
        $cacheLife = 1200; // cache lifetime of 20 minutes

        if (!$conduitXml = $this->tryCache($cacheName, $cacheLife)) {
            // cache miss
            $query      = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . Zend_Registry::get('config')->blogs->blogger->conduitBlogId . '/posts/default');
            $conduit    = $gdClient->getFeed($query);
            $conduitXml = $conduit->getXML();
            $conduitXml = $this->saveCache($conduitXml, $cacheName, $cacheLife);
        }

        $cacheName = 'myBloggerBlogDivert';
        $cacheLife = 1200; // cache lifetime of 20 minutes

        if (!$divertXml = $this->tryCache($cacheName, $cacheLife)) {
            // cache miss
            $query      = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . Zend_Registry::get('config')->blogs->blogger->divertBlogId . '/posts/default');
            $divert     = $gdClient->getFeed($query);
            $divertXml  = $divert->getXML();
            $divertXml  = $this->saveCache($divertXml, $cacheName, $cacheLife);
        }

        $dom = &$this->view->dom;

        $domBlogs      = $dom->createElement('blogs');
        $domConduit    = $dom->createElement('conduit');
        $domDivert     = $dom->createElement('divert');

        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML($conduitXml);
        $domConduit->appendChild($fragment);

        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML($divertXml);
        $domDivert->appendChild($fragment);

        $domBlogs->appendChild($domConduit);
        $domBlogs->appendChild($domDivert);

        $this->view->dom->appendChild($domBlogs);

        // get the feature photo
        /*
        $gallery = new Gallery(40);
        $gallery->get_media();
        $randomId = rand(0, count($gallery->media) - 1);
        $media = $gallery->media[$randomId];

        $this->_xmlSerializer->setOption(XML_SERIALIZER_OPTION_ROOT_NAME, 'featuredMedia');
        $this->_xmlSerializer->serialize($media);
        $this->view->xml .= $this->_xmlSerializer->getSerializedData();
        */

        // get the recent feedback

        //Zend_Debug::dump($this->view->xml);
    }
}


/*
<atom:feed>
-
  <atom:author>
<atom:name>Silent Rob</atom:name>
</atom:author>
<atom:id>tag:blogger.com,1999:blog-1020538993066458697</atom:id>
<atom:link href="http://silentrob-theconduit.blogspot.com/" rel="alternate" type="text/html"/>
<atom:link href="http://silentrob-theconduit.blogspot.com/feeds/posts/default" rel="http://schemas.google.com/g/2005#feed" type="application/atom+xml"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default" rel="self" type="application/atom+xml"/>
<atom:title type="text">The Conduit</atom:title>
<atom:updated>2008-04-25T14:18:11.456-07:00</atom:updated>
<atom:generator uri="http://www.blogger.com" version="7.00">Blogger</atom:generator>
-
  <atom:entry>
-
  <atom:author>
<atom:name>Silent Rob</atom:name>
</atom:author>
<atom:category term="photography" scheme="http://www.blogger.com/atom/ns#"/>
<atom:category term="technology" scheme="http://www.blogger.com/atom/ns#"/>
-
  <atom:id>
tag:blogger.com,1999:blog-1020538993066458697.post-8770790793233938622
</atom:id>
<atom:link href="http://silentrob-theconduit.blogspot.com/2007/06/google-maps-street-view.html" rel="alternate" type="text/html" title="Google Maps "Street View""/>
<atom:link href="http://www.blogger.com/comment.g?blogID=1020538993066458697&postID=8770790793233938622" rel="replies" type="text/html" title="1 Comments"/>
<atom:link href="http://silentrob-theconduit.blogspot.com/feeds/8770790793233938622/comments/default" rel="replies" type="application/atom+xml" title="Post Comments"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default/8770790793233938622" rel="self" type="application/atom+xml"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default/8770790793233938622" rel="edit" type="application/atom+xml"/>
<atom:title type="text">Google Maps "Street View"</atom:title>
<atom:updated>2008-04-25T14:01:42.332-07:00</atom:updated>
-
  <atom:content type="html">
<a href="http://www.google.com/">Google</a> has added another new feature to its <a href="http://maps.google.com/">Maps</a> application: Street View. In five U.S. cities (<a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=new+york,+ny&amp;ie=UTF8&amp;ll=40.714476,-74.007339&amp;spn=0.413242,0.475159&amp;t=h&amp;z=11&amp;om=1&amp;layer=c">New York</a>, <a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=miami,+fl&amp;ie=UTF8&amp;ll=25.728777,-80.237274&amp;spn=0.491144,0.475159&amp;t=h&amp;z=11&amp;om=1&amp;layer=c">Miami</a>, <a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=san+francisco,+ca&amp;ie=UTF8&amp;t=h&amp;om=1&amp;layer=c&amp;ll=37.651209,-122.261353&amp;spn=0.863309,0.950317&amp;z=10">San Francisco</a>, <a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=las+vegas,+nv&amp;ie=UTF8&amp;ll=36.17188,-115.13974&amp;spn=0.220055,0.237579&amp;t=h&amp;z=12&amp;om=1&amp;layer=c">Las Vegas</a>, and <a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=denver,+co&amp;ie=UTF8&amp;ll=39.74004,-104.99227&amp;spn=0.419231,0.475159&amp;t=h&amp;z=11&amp;om=1&amp;layer=c">Denver</a>) you can now switch to a street-level panoramic photo view of wherever you click on the map. Very impressive.<br /><br />My guess is that they roof-mounted eight (judging by the seams in the panoramas) digital cameras in a circular formation on a vehicle and drove the streets (nearly <em>all</em> of them!). They trigger the shutters in the camera array every ten meters or so (perhaps the array is linked to the vehicle's odometer or wheel somehow to ensure even spacing). Of course, since the field of view of the lens is known, a computer can stitch the resulting image sets into 360 degree panoramas automatically, and via GPS coordinates (stored at the time of shutter release), can place the panoramas on the map. Voila!<br /><br />I thought it wise to check in on the folks who created this new function down in sunny Mountain View, California and what do you know, it seems they've planted a little <a href="http://maps.google.com/?ie=UTF8&amp;t=h&amp;om=1&amp;layer=c&amp;cbll=37.420894,-122.084098&amp;cbp=1,359.112944596381,0.501364070476615,0&amp;ll=37.421874,-122.084042&amp;spn=0.003451,0.003841&amp;z=18">easter egg</a> for us: the joyous geeks can be found posing on the lawn in front of the Googleplex carrying an odd assortment of shovels, rakes, flags, balloons and more.
</atom:content>
<atom:published>2007-06-04T15:16:00.000-07:00</atom:published>
</atom:entry>
-
  <atom:entry>
-
  <atom:author>
<atom:name>Silent Rob</atom:name>
</atom:author>
<atom:category term="personal" scheme="http://www.blogger.com/atom/ns#"/>
<atom:category term="culture" scheme="http://www.blogger.com/atom/ns#"/>
-
  <atom:id>
tag:blogger.com,1999:blog-1020538993066458697.post-3163044657527453511
</atom:id>
<atom:link href="http://silentrob-theconduit.blogspot.com/2006/11/on-copy-protection.html" rel="alternate" type="text/html" title="On copy protection"/>
<atom:link href="http://www.blogger.com/comment.g?blogID=1020538993066458697&postID=3163044657527453511" rel="replies" type="text/html" title="0 Comments"/>
<atom:link href="http://silentrob-theconduit.blogspot.com/feeds/3163044657527453511/comments/default" rel="replies" type="application/atom+xml" title="Post Comments"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default/3163044657527453511" rel="self" type="application/atom+xml"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default/3163044657527453511" rel="edit" type="application/atom+xml"/>
<atom:title type="text">On copy protection</atom:title>
<atom:updated>2008-04-25T14:04:09.268-07:00</atom:updated>
-
  <atom:content type="html">
Being that I work in the music industry, that I'm a developer by trade and a hobbyist photographer, I certainly can understand why companies and individuals want to protect their intellectual property. However, I am also a consumer, and I'm putting it mildly when I say that it drives me crazy when I can't use a product that I legitimately purchased at a store because of the copy protection technology on the disc.<br /><br />The most recent incident is my experience with the new PC game <a href="http://www.atari.com/nwn2/UK/index.php">Neverwinter Nights 2</a>, a role-playing game from <a href="http://www.obsidianent.com/">Obsidian</a> and published by <a href="http://www.atari.com/">Atari</a>. I cannot play the game on my PC. I installed it, entered the CD key, updated it to the latest version with the built-in patch tool, but it just won't run. The game contains copy protection software by <a href="http://www.securom.com/">SecuROM</a> that attempts to verify that an original installation disc is in the drive when you launch the game. My disc is in the drive, but the program tells me that "An original disc cannot be found or authenticated."<br /><br />I've been emailing the SecuROM technical support people, who've had me install a new .exe (executable file) in the program directory. Same problem. Their latest email says that I'm trying to use the game from a "backup disc"--right! I am using the <em>original installation disc</em> that I <em>purchased</em>. Backup discs are for pirates... arrr!<br /><br />This is almost as bad as the <a href="http://www.oasisinet.com/">Oasis</a> CD that I can't play in my car stereo because it has copy-protection technology on it, and my car stereo is a CD-ROM-based device from <a href="http://www.clarion.com/">Clarion</a> that can play MP3s burned onto CD-R.<br /><br />Copy protection sucks. Why does it seem that copy protection only hurts the people who actually buy the disc? Pirates always find a way around it, and they can use copied discs to their heart's content, but people who actually pay for it with their hard-earned money get screwed.
</atom:content>
<atom:published>2006-11-30T12:14:00.000-08:00</atom:published>
</atom:entry>
-
  <atom:entry>
-
  <atom:author>
<atom:name>Silent Rob</atom:name>
</atom:author>
<atom:category term="photography" scheme="http://www.blogger.com/atom/ns#"/>
<atom:category term="personal" scheme="http://www.blogger.com/atom/ns#"/>
-
  <atom:id>
tag:blogger.com,1999:blog-1020538993066458697.post-664052862100848800
</atom:id>
<atom:link href="http://silentrob-theconduit.blogspot.com/2006/10/last-batch-of-photos-from-newfoundland.html" rel="alternate" type="text/html" title="Last batch of photos from Newfoundland"/>
<atom:link href="http://www.blogger.com/comment.g?blogID=1020538993066458697&postID=664052862100848800" rel="replies" type="text/html" title="0 Comments"/>
<atom:link href="http://silentrob-theconduit.blogspot.com/feeds/664052862100848800/comments/default" rel="replies" type="application/atom+xml" title="Post Comments"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default/664052862100848800" rel="self" type="application/atom+xml"/>
<atom:link href="http://www.blogger.com/feeds/1020538993066458697/posts/default/664052862100848800" rel="edit" type="application/atom+xml"/>
<atom:title type="text">Last batch of photos from Newfoundland</atom:title>
<atom:updated>2008-04-25T14:12:34.944-07:00</atom:updated>
-
  <atom:content type="html">
Finally! I've finished processing the last photos from Newfoundland. <a href="/photos/gallery/122/page/3">This batch</a> consists of 20 photos from our boat cruise on Western Brook Pond. The "pond" is actually a landlocked fjord, 30km in length and perhaps a few kilometres wide at the mouth, with 2000' cliffs of four billion year-old granite (Consider that Earth itself is "only" 10 billion years old). Pretty amazing stuff.  It's no wonder <a href="http://www.pc.gc.ca/pn-np/nl/grosmorne/index_e.asp">Gros Morne</a> is a <a href="http://www.unesco.org/whc/sites/419.htm">UNESCO World Heritage site</a>. The cruise is a must do for anyone visiting the park.<br /><br />I've been working on some new techniques for processing my photos, especially black and white conversions. I'm applying a more liberal amount of dodging and burning, maintaing the full scale of luminances but trying to add more drama and emphasis to match what I originally felt when I made the photo. There will be a few more galleries posted over the next couple weeks where I hope to display some of the results. Please feel free to comment on anything you like or dislike!
</atom:content>
<atom:published>2006-10-10T11:47:00.000-07:00</atom:published>
</atom:entry>
<openSearch:totalResults>3</openSearch:totalResults>
<openSearch:startIndex>1</openSearch:startIndex>
<openSearch:itemsPerPage>25</openSearch:itemsPerPage>
</atom:feed>
*/
