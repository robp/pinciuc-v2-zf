<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'Flashteroids / Extras'"/>
  <xsl:with-param name="css" select="'home'"/>
  
  <xsl:with-param name="content">
    <h2>Flashteroids</h2>

    <p>A Flash version of the original Atari classic that I created while reading a Flash game-making book.</p>

    <p class="center">
      <!-- URL's used in the movie-->
      <!-- text used in the movie-->
      <!--LoadingFLASHTEROIDSby Rob Pinciucv 0.1AAA6.7.8.9.10.1.2.3.4.5.94789340 CreditsHelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000HelpControlsLeft/Right Arrow:  RotateUp Arrow:  ThrustersDown Arrow:  HyperspaceSpace Bar:  FireScoringAsteroids:  20, 50, 100Large UFO:  200Small UFO:  1000Bonus Life:  each 10,000BONUS AT 10000GAME OVERCONGRATULATIONS.  YOU HAVE ACHIEVED ONE OF THE TOP SCORES.
      ENTER YOUR INITIALS TO EARN YOUR PLACE IN THE FLASHTEROIDS HALL OF FAME.-->
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="640" height="480" id="flashteroids" align="">
       <param name="movie" value="flashteroids.swf"/>
       <param name="quality" value="high"/>
       <param name="bgcolor" value="#000000"/>
       <embed src="flashteroids.swf" quality="high" bgcolor="#000000" width="640" height="480" name="flashteroids" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
      </object>
    </p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



