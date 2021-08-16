<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:php="http://php.net/xsl">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/common.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'music'"/>
    <xsl:with-param name="title" select="concat(/album/title, ' / ', /album/albumArtist, ' / ', 'Music')"/>
    <xsl:with-param name="css" select="'music'"/>

    <xsl:with-param name="content">
      <div id="artist-browse">
        <h2>Online Music Collection</h2>

        <div id="album-display">
          <img id="coverArt" width="120" height="120" src="/music/cover/albumArtist/{php:function('urlencode',string(/album/albumArtist))}/title/{php:function('urlencode',string(/album/title))}" alt="{/album/title}"/>
          <h3 class="no-margin"><xsl:value-of select="/album/title" /></h3>
          <h4 class="no-margin"><a href="/music/albums/albumArtist/{php:function('urlencode',string(/album/albumArtist))}"><xsl:value-of select="/album/albumArtist" /></a></h4>

          <p>
            <xsl:if test="/album/year > 0">
              <xsl:value-of select="/album/year" /><br/>
            </xsl:if>
            <xsl:if test="/album/totalTime > 0">
              Length: <xsl:value-of select="floor(/album/totalTime div 1000 div 60)" />:<xsl:if test="round(/album/totalTime div 1000 mod 60) &lt; 10">0</xsl:if><xsl:value-of select="round(/album/totalTime div 1000 mod 60)" /><br/>
            </xsl:if>
            <xsl:if test="/album/totalSize > 0">
              Size: <xsl:value-of select="floor(/album/totalSize div (1024 * 1024))" />.<xsl:value-of select="round((/album/totalSize mod (1024 * 1024)) div 1000000)" />MB<br/>
            </xsl:if>
          </p>

          <p>&#187; <a href="/music/playlist.php?ids[]=60144&amp;ids[]=60145&amp;ids[]=60146&amp;ids[]=60147&amp;ids[]=60148&amp;ids[]=60149&amp;ids[]=60150&amp;ids[]=60151&amp;ids[]=60152&amp;ids[]=60153&amp;ids[]=60154&amp;artist=The+Arcade+Fire&amp;album=Neon+Bible">Playlist</a></p>

          <br class="clear-both"/>

          <h4>Tracklist</h4>

          <xsl:for-each select="/album/tracklist">
            <div class="tracklist">
              <xsl:if test="count(/album/tracklist) > 1">
                <h5>Disc <xsl:value-of select="@discNumber" /></h5>
              </xsl:if>

              <xsl:for-each select="track">
                <div class="track">
                  <span class="trackNumber"><xsl:value-of select="@trackNumber"/>.</span>
                  <span class="trackTitle">
                    <a href="/music/track/persistentId/{@persistentId}"><xsl:value-of select="name" /></a>
                  </span>
                  <xsl:if test="(string-length(normalize-space(artist)) > 0) and (artist != /album/albumArtist)">
                    <span class="trackArtist"><a href="/music/albums/albumArtist/{php:function('urlencode',string(artist))}"><xsl:value-of select="artist" /></a></span>
                  </xsl:if>
                  <span class="trackLength">
                    <xsl:value-of select="floor(totalTime div 1000 div 60)" />:<xsl:if test="round(totalTime div 1000 mod 60) &lt; 10">0</xsl:if><xsl:value-of select="round(totalTime div 1000 mod 60)" />
                  </span>
                </div>
              </xsl:for-each>
            </div>
          </xsl:for-each>
          
          <xsl:call-template name="comments">
            <xsl:with-param name="title" select="/album/title"/>
            <xsl:with-param name="post_id">album|<xsl:value-of select="php:function('urlencode',string(/album/albumArtist))"/>|<xsl:value-of select="php:function('urlencode',string(/album/title))"/></xsl:with-param>
          </xsl:call-template>

        </div> <!-- album-display -->
      </div> <!-- artist-browse -->

      <div id="feature-albums">

        <h3>All Music Guide Artist Page</h3>

        <div id="allmusic-link">
          <form action="http://www.allmusic.com/cg/amg.dll" method="post">
            <input class="hidden" type="hidden" name="P" value="amg"/>
            <input class="hidden" type="hidden" name="sql" value="{/album/albumArtist}"/>
            <input class="hidden" type="hidden" name="opt1" value="1"/>
            <input type="image" src="/images/amg_sm.gif"/><br/>
          </form>
        </div>

        <xsl:if test="count(/otherAlbums/album) > 0">
          <h3 class="clear-both">Other Albums By This Artist</h3>

          <div class="small-album-list">

            <xsl:for-each select="/otherAlbums/album">
              <p>
                <a href="/music/album/albumArtist/{php:function('urlencode',string(/album/albumArtist))}/title/{php:function('urlencode',string(title))}"><img width="30" height="30" class="cover" src="/music/cover/albumArtist/{php:function('urlencode',string(/album/albumArtist))}/title/{php:function('urlencode',string(title))}" alt="{title}"/></a>
                <strong><a href="/music/album/albumArtist/{php:function('urlencode',string(/album/albumArtist))}/title/{php:function('urlencode',string(title))}"><xsl:value-of select="title" /></a></strong><br/>
                <a href="/music/albums/albumArtist/{php:function('urlencode',string(/album/albumArtist))}"><xsl:value-of select="/album/albumArtist" /></a>
              </p>
            </xsl:for-each>
          </div> <!-- small-album-list -->
        </xsl:if>

        <xsl:if test="count(/creditedAlbums/album) > 0">
          <h3 class="clear-both">Contributed To...</h3>

          <div class="small-album-list">

            <xsl:for-each select="/creditedAlbums/album">
              <p>
                <a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><img width="30" height="30" class="cover" src="/music/cover/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}" alt="{title}"/></a>
                <strong><a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><xsl:value-of select="title" /></a></strong><br/>
                <a href="/music/albums/albumArtist/{php:function('urlencode',string(albumArtist))}"><xsl:value-of select="albumArtist" /></a>
              </p>
            </xsl:for-each>
          </div> <!-- small-album-list -->
        </xsl:if>

      </div> <!-- feature-albums -->
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
