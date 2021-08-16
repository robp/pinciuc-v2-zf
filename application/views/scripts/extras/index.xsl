<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'Extras'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <h2>Extras</h2>

    <h3>Flash Games / Apps</h3>

    <p>I do a fair bit of <a href="http://www.adobe.com/products/flash/flashpro/">Flash</a> development in my day job at <a href="http://www.sonybmg.ca/">Sony BMG</a>, and a little bit on the side just for fun. Here are some samples of that work.</p>

    <ul class="arrowed">
    <li><a href="flashteroids/">Flashteroids</a> - Flash version of the classic arcade game</li>

    <li><a href="puzzle/">Puzzle Game</a> - unscramble the image to solve the puzzle</li>
    <li><a href="actlikeanasshole/">Tom Green Voice Message e-card</a> - create a custom Tom Green voice message and send it to your friends</li>
    <li><a href="letsgo/">Shawn Desman "Let's Go" Game</a> - a "Simon"-type game featuring Shawn's new single "Let's Go"</li>
    <li><a href="iambilly/">Etch-a-Sketch Game</a> - Flash version of a the Etch-a-Sketch toy used on a Sony BMG promo site</li>

    <li><a href="essentials/">The Essentials Collection Game</a> - crossword puzzle game to promote the new "Essentials Collection" series of albums</li>

    <li><a href="forceablethumbs/">WWF Forceable Thumbs Game</a> - thumb-wrestling game to promote the latest WWF theme song album "Forceable Entry"</li>
    </ul>

    <br/>

    <h3>Home Theatre PC (HTPC)</h3>

    <p>I love a good movie, and what's better than watching it in the comfort of your own living room with cheap snacks and a cushy sofa? With that in mind, I've been building up my home theatre for a few years, and one of the more complex projects is the HTPC. I've documented the first-, and now the second-generation HTPCs that I've built.</p>

    <ul class="arrowed">
    <li><a href="/htpc">Third Generation HTPC</a> - updated for 1080p and DirectX 10 gaming</li>
    <li><a href="/htpc/v2">Second Generation HTPC</a> - updated for HDTV, DVD upscaling and improved gameplay capability</li>
    <li><a href="/htpc/v1">First Generation HTPC</a> - primarily used for as a personal video recorder (PVR) and some game playing</li>
    </ul>

    <br/>

    <h3>Home Network and Server Rack</h3>

    <p>I'm a computer guy, and love playing with Linux servers and networking devices. I've built up a pretty crazy (if I do say so myself) home server and network setup, including three servers, a RAID storage array, network monitoring, and lots more, all rackmounted.</p>

    <ul class="arrowed">
    <li><a href="/network/">Read about my home network and server rack</a></li>
    </ul>

    <br/>

    <h3>For Sale</h3>

    <p>Just some things that I would like to get rid of. Please <a href="/contact.php">contact me</a> if you are interested in anything.</p>

    <ul class="arrowed">
    <li>Sorry, nothing for sale at the moment.</li>

    </ul>

    <br/>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



