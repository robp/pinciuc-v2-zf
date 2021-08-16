<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:date="http://exslt.org/dates-and-times" xmlns:str="http://exslt.org/strings">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/stringFunctions.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/exslt/date/functions/format-date/date.format-date.template.xsl" />
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/exslt/str/functions/tokenize/str.tokenize.template.xsl" />

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'home'"/>
  <xsl:with-param name="title" select="'Home'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
  <div id="c-left">
    <h2>Ramblings and Diversions</h2>

    <xsl:variable name="blogEntries">
      <xsl:for-each select="/blogs/*/atom:feed/atom:entry">
      <xsl:sort select="atom:published" data-type="string" order="descending"/>
        <xsl:copy-of select="."/>
      </xsl:for-each>
    </xsl:variable>

    <xsl:for-each select="exslt:node-set($blogEntries)/atom:entry">
      <!--<atom:id>tag:blogger.com,1999:blog-1020538993066458697.post-8770790793233938622</atom:id>-->
      <!--<atom:link href="http://www.blogger.com/comment.g?blogID=1020538993066458697&postID=8770790793233938622" rel="replies" type="text/html" title="1 Comments"/>-->
      <xsl:variable name="atomIdTmp">
        <xsl:call-template name="str:tokenize">
          <xsl:with-param name="string" select="atom:id" />
          <xsl:with-param name="delimiters" select="'-:.,'" />
        </xsl:call-template>
      </xsl:variable>
      <xsl:variable name="atomId" select="exslt:node-set($atomIdTmp)" />

      <xsl:variable name="numCommentsTmp">
        <xsl:call-template name="str:tokenize">
          <xsl:with-param name="string" select="atom:link[@rel='replies' and @type='text/html']/@title" />
          <xsl:with-param name="delimiters" select="' '" />
        </xsl:call-template>
      </xsl:variable>
      <xsl:variable name="numComments" select="exslt:node-set($numCommentsTmp)/token[position() = 1]" />

      <xsl:choose>
        <xsl:when test="$atomId/token[position() = 6] = '1020538993066458697'">
          <!-- "conduit" entry -->
          <h3><xsl:value-of select="atom:title"/></h3>
          <p class="blog-entry-body">
            <xsl:value-of select="atom:content[@type = 'html']" disable-output-escaping="yes"/>
          </p>
          <p class="blog-entry-date">&#187; 
            <a href="/blog/entry/blogId/{$atomId/token[position() = 6]}/entryId/{$atomId/token[position() = 8]}" title="Permalink to this entry">
              <xsl:call-template name="date:format-date">
                <xsl:with-param name="date-time" select="atom:published"/>
                <xsl:with-param name="pattern" select="'d MMM yyyy, h:ma'"/>
              </xsl:call-template>
            </a> - <a href="/blog/entry/blogId/{$atomId/token[position() = 6]}/entryId/{$atomId/token[position() = 8]}#comments"><xsl:value-of select="$numComments"/> comment<xsl:if test="$numComments != 1">s</xsl:if></a>
          </p>
        </xsl:when>
        <xsl:when test="$atomId/token[position() = 6] = '5141130942374239510'">
          <!-- "divert" entry -->
          <ul class="divert">
            <li><a href="{atom:link[@rel = 'related']/@href}" target="_blank"><xsl:value-of select="atom:title"/></a> 
              <xsl:if test="string-length(normalize-space(atom:content[@type = 'html'])) > 0">
                - <xsl:value-of select="atom:content[@type = 'html']" disable-output-escaping="yes"/>
              </xsl:if>
              [<a href="/blog/entry/blogId/{$atomId/token[position() = 6]}/entryId/{$atomId/token[position() = 8]}#comments">
                <xsl:attribute name="title">
                  <xsl:value-of select="$numComments"/> comment<xsl:if test="$numComments != 1">s</xsl:if>
                </xsl:attribute>
                <xsl:value-of select="$numComments"/></a>]
            </li>
          </ul>
        </xsl:when>
      </xsl:choose>
    </xsl:for-each>
  </div>
  <div id="c-right">
    <div id="feature-photo">
      <div id="feature-photo-shadow">
        <div id="feature-photo-frame">
          <p>
            <xsl:choose>
              <xsl:when test="string-length(normalize-space(/featuredMedia/title)) > 0">
                <xsl:value-of select="/featuredMedia/title"/>
              </xsl:when>
              <xsl:otherwise>
                Untitled
              </xsl:otherwise>
            </xsl:choose>
          </p>
          <a class="a-img" href="photos/gallery/{/featuredMedia/gallery_id}/{/featuredMedia/sequence}">
            <img src="photos/thumbnail/id/{/featuredMedia/media_id}/width/170/height/255">
              <xsl:attribute name="alt">
                <xsl:choose>
                  <xsl:when test="string-length(normalize-space(/featuredMedia/title)) > 0">
                    <xsl:value-of select="/featuredMedia/title"/>
                  </xsl:when>
                  <xsl:otherwise>
                    Untitled
                  </xsl:otherwise>
                </xsl:choose>
              </xsl:attribute>
            </img>
          </a>
        </div>
      </div>
    </div> <!-- feature-photo -->

    <div class="subsection">
      <h2 class="center">Recent Entries</h2>
      <ul class="arrowed">
        <xsl:for-each select="/blogs/conduit/atom:feed/atom:entry">
        <xsl:sort select="atom:published" data-type="string" order="descending"/>
          <xsl:if test="position() &lt;= 10">
            <xsl:variable name="atomIdTmp">
              <xsl:call-template name="str:tokenize">
                <xsl:with-param name="string" select="atom:id" />
                <xsl:with-param name="delimiters" select="'-:.,'" />
              </xsl:call-template>
            </xsl:variable>
            <xsl:variable name="atomId" select="exslt:node-set($atomIdTmp)" />

            <xsl:variable name="numCommentsTmp">
              <xsl:call-template name="str:tokenize">
                <xsl:with-param name="string" select="atom:link[@rel='replies' and @type='text/html']/@title" />
                <xsl:with-param name="delimiters" select="' '" />
              </xsl:call-template>
            </xsl:variable>
            <xsl:variable name="numComments" select="exslt:node-set($numCommentsTmp)/token[position() = 1]" />

            <li>
              <a href="/blog/entry/blogId/{$atomId/token[position() = 6]}/entryId/{$atomId/token[position() = 8]}"><xsl:value-of select="atom:title"/></a>
                [<a href="/blog/entry/blogId/{$atomId/token[position() = 6]}/entryId/{$atomId/token[position() = 8]}#comments">
                  <xsl:attribute name="title">
                    <xsl:value-of select="$numComments"/> comment<xsl:if test="$numComments != 1">s</xsl:if>
                  </xsl:attribute>
                  <xsl:value-of select="$numComments"/></a>]
            </li>
          </xsl:if>
        </xsl:for-each>
      </ul>
    </div>

    <div class="subsection">
      <h2 class="center">Feedback</h2>
      <p class="info">The most recent comments on posts, galleries and images. Leave some feedback, get 'yer name up on the board!</p>
      <!--<script src="http://www.intensedebate.com/widgets/acctComment/14061/5" type="text/javascript"></script>-->
    </div>

    <div class="subsection">
      <h2 class="center">Archives</h2>
      <p class="info">There's more where this came from... unfortunately.</p>
      <ul class="arrowed">
        <!--<atom:id>tag:blogger.com,1999:blog-1020538993066458697</atom:id>-->
        <xsl:variable name="conduitIdTmp">
          <xsl:call-template name="str:tokenize">
            <xsl:with-param name="string" select="/blogs/conduit/atom:feed/atom:id" />
            <xsl:with-param name="delimiters" select="'-'" />
          </xsl:call-template>
        </xsl:variable>
        <xsl:variable name="conduitId" select="exslt:node-set($conduitIdTmp)/token[position() = 2]" />
        <li><a href="/blog/archive/blogId/{$conduitId}">the conduit</a> (stories)</li>

        <!--<atom:id>tag:blogger.com,1999:blog-1020538993066458697</atom:id>-->
        <xsl:variable name="divertIdTmp">
          <xsl:call-template name="str:tokenize">
            <xsl:with-param name="string" select="/blogs/divert/atom:feed/atom:id" />
            <xsl:with-param name="delimiters" select="'-'" />
          </xsl:call-template>
        </xsl:variable>
        <xsl:variable name="divertId" select="exslt:node-set($divertIdTmp)/token[position() = 2]" />
        <li><a href="/blog/archive/blogId/{$divertId}">divert</a> (links)</li>
      </ul>
    </div>

    <div class="subsection">
      <h2 class="center">Broadcast</h2>
      <p class="info">Shoutin' out to the world, 24/7, all the time, everywhere, and all that. Oh, and add me to your feed reader while you're at it.</p>
      <img src="/images/badge_rss.gif" width="29" height="15" alt="RSS"/>
      <ul class="arrowed">
        <li><a href="{/blogs/conduit/atom:feed/atom:link[@rel = 'self' and @type = 'application/atom+xml']/@href}">the conduit</a> (stories)</li>
        <li><a href="{/blogs/divert/atom:feed/atom:link[@rel = 'self' and @type = 'application/atom+xml']/@href}">divert</a> (links)</li>
      </ul>
    </div>

    <div class="subsection">
      <h2 class="center">Network</h2>
      <p class="info">Why not give a moment of your time to these lovely associates?</p>
      <ul class="offsite">
        <li><a href="http://flashlightfight.blogspot.com/">aaron episode 4</a></li>
        <li><a href="http://b.c4.ca/">b</a></li>
        <li><a href="http://www.fortbravo.com/">fort bravo</a></li>
        <li><a href="http://www.hiepvu.com">hiep</a></li>
        <li><a href="http://www.burpee.ca/matthew/">matthew</a></li>
        <li><a href="http://www.routerninja.org/">router ninja</a></li>
        <li><a href="http://www.snowpics.ca/">snow pics</a></li>
        <li><a href="http://torontowings.wordpress.com/">torontowings</a></li>
      </ul>
    </div>
  </div>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>
