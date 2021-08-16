<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:param name="query"/>
<xsl:param name="resultsCount"/>
<xsl:param name="searchTime"/>
<xsl:param name="startIndex"/>
<xsl:param name="endIndex"/>
<xsl:param name="page"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="''"/>
  <xsl:with-param name="title" select="'Search Results'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <div id="c-left">
      <h2>Search Results</h2>

      <xsl:choose>
      <xsl:when test="count(/searchResults/result) > 0">
        <xsl:for-each select="/searchResults/result">
          <p class="search_result">
            <a href="{url}"><xsl:value-of select="title" disable-output-escaping="yes"/></a><br/>
            <xsl:value-of select="snippet" disable-output-escaping="yes"/><br/>
            <span class="search_url">
              <xsl:value-of select="substring(url, 8)"/> - <xsl:value-of select="cachedSize"/>
            </span>
          </p>
        </xsl:for-each>
      </xsl:when>
      <xsl:otherwise>
          <p>Sorry, no results were found on this site for <b><xsl:value-of select="$query"/></b>.
          <!--
          do_spell($q, $key, $spell);
          if ($spell[0]) {
            echo "Did you mean <strong><a href=\"".$PHP_SELF."?q=".$spell."\">".$spell."</a></strong>? ";
          }
          -->
          </p>
          <p>Occasionally no results will be returned when there are problems with the link between this site and Google. If you believe the information is on the site but it tells you that it's not, please try again.</p>
      </xsl:otherwise>
      </xsl:choose>

    </div> <!-- c-left -->

    <div id="c-right">
      <p>Search results by:<br/>
      <img src="/images/pb-google-wht.gif" width="75" height="32" alt="Google"/></p>

      <p>
      <xsl:choose>
        <xsl:when test="$resultsCount > 0">
          Results <strong><xsl:value-of select="$startIndex"/></strong> - <strong><xsl:value-of select="$endIndex"/></strong> of about <strong><xsl:value-of select="$resultsCount"/></strong>
        </xsl:when>
        <xsl:otherwise>
          No results
        </xsl:otherwise>
      </xsl:choose>

      for <strong><xsl:value-of select="$query"/></strong>
      (<b><xsl:value-of select="$searchTime"/></b><xsl:if test="$searchTime != 'cached'"><xsl:text> </xsl:text>seconds</xsl:if>)</p>

      <div class="search_bottom">
        <xsl:if test="$startIndex > 1"><strong><a href="/search/search/query/{$query}/page/{$page - 1}">Previous Page</a></strong></xsl:if>
        <xsl:if test="$startIndex > 1 and $endIndex &lt; $resultsCount"><xsl:text> </xsl:text>|<xsl:text> </xsl:text></xsl:if>
        <xsl:if test="$endIndex &lt; $resultsCount"><strong><a href="/search/search/query/{$query}/page/{$page + 1}">Next Page</a></strong></xsl:if>
      </div>

      <form action="/search" method="get">
      <input type="text" name="query" size="30" value="{$query}"/>
      <button type="submit" value="search">Search</button>
      </form>

    </div> <!-- c-right -->
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



