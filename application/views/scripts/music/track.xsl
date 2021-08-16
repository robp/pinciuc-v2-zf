<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:php="http://php.net/xsl">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/common.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
  <xsl:variable name="track" select="/track"/>

  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'music'"/>
    <xsl:with-param name="title" select="concat($track/name, ' / ', $track/album, ' / ', $track/albumArtist, ' / ', 'Music')"/>
    <xsl:with-param name="css" select="'music'"/>

    <xsl:with-param name="content">
      <div id="artist-browse">
        <h2>Online Music Collection</h2>

        <p><a href="/music/album/albumArtist/{php:function('urlencode',string($track/albumArtist))}/title/{php:function('urlencode',string($track/album))}">Back to "<xsl:value-of select="$track/album"/>"</a></p>

        <h3>Meta Tag Summary</h3>

        <table summary="The file information for this track." id="id3-table">
          <tr><th scope="row">Track ID:</th><td><xsl:value-of select="$track/@id" /></td></tr>
          <tr><th scope="row">Persistent ID:</th><td><xsl:value-of select="$track/@persistentId" /></td></tr>
          <tr><th scope="row">Location:</th><td><xsl:value-of select="$track/location" /></td></tr>
          <tr><th scope="row">Album Artist:</th><td><a href="/music/albums/albumArtist/{php:function('urlencode',string($track/albumArtist))}"><xsl:value-of select="$track/albumArtist" /></a></td></tr>
          <tr><th scope="row">Album:</th><td><a href="/music/album/albumArtist/{php:function('urlencode',string($track/albumArtist))}/title/{php:function('urlencode',string($track/album))}"><xsl:value-of select="$track/album" /></a></td></tr>
          <tr><th scope="row">Artist:</th><td><a href="/music/albums/artist/{php:function('urlencode',string($track/artist))}"><xsl:value-of select="$track/artist" /></a></td></tr>
          <tr><th scope="row">Title:</th><td><xsl:value-of select="$track/name" /></td></tr>
      <tr><th scope="row">Disc Number:</th><td><xsl:value-of select="$track/@discNumber" />
              <xsl:if test="string-length(normalize-space(@discCount)) > 0"> of <xsl:value-of select="@discCount" /></xsl:if>
      </td></tr>
          <tr><th scope="row">Track No.:</th><td><xsl:value-of select="$track/trackNumber" /></td></tr>
          <tr><th scope="row">Composer:</th><td><xsl:value-of select="$track/composer" /></td></tr>
          <tr><th scope="row">Year:</th><td><xsl:value-of select="$track/year" /></td></tr>
          <tr><th scope="row">Genre:</th><td><xsl:value-of select="$track/genre" /></td></tr>
          <tr><th scope="row">Kind:</th><td><xsl:value-of select="$track/kind" /></td></tr>
          <tr><th scope="row">Size (bytes):</th>
            <td>
              <xsl:if test="$track/size >= 1000000">
                <xsl:value-of select="floor($track/size div 1000000)" />,</xsl:if>
              <xsl:if test="$track/size >= 1000">
                <xsl:value-of select="floor(($track/size mod 1000000) div 1000)" />,</xsl:if>
              <xsl:if test="$track/size >= 1">
                <xsl:value-of select="($track/size mod 1000000) mod 1000" />
              </xsl:if>
            </td>
          </tr>
          <tr><th scope="row">Length:</th><td><xsl:value-of select="floor($track/totalTime div 1000 div 60)" />:<xsl:if test="round($track/totalTime div 1000 mod 60) &lt; 10">0</xsl:if><xsl:value-of select="round($track/totalTime div 1000 mod 60)" /></td></tr>
          <tr><th scope="row">Bit Rate (Kbps):</th><td><xsl:value-of select="$track/bitRate" /></td></tr>
          <tr><th scope="row">Sample Rate (Hz):</th><td><xsl:value-of select="$track/sampleRate" /></td></tr>
        </table>
      </div>

      <div id="feature-albums">
      </div>
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
