<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="/home/robp/dev.pinciuc.com/htdocs/xsl/googleServices.xsl"/>

<xsl:template name="standard-head">
<xsl:param name="title" select="'Untitled'"/>
<xsl:param name="css" select="'home'"/>
<xsl:param name="with-analytics" select="false()"/>
<xsl:param name="with-maps" select="false()"/>

	<head>
		<title><xsl:value-of select="$title"/> / pinciuc.com</title>
		<link rel="stylesheet" media="screen, projection" href="/style/{$css}.css" type="text/css"/>

		<script type="text/javascript" src="/js/conduit-v2.js"><xsl:comment/></script>
		<link rel="alternate" type="application/rss+xml" title="RSS" href="/rss" />
		<xsl:if test="$with-analytics = true()">
			<xsl:call-template name="google-analytics"/>
		</xsl:if>
		<xsl:if test="$with-maps = true()">
			<xsl:call-template name="google-maps"/>
		</xsl:if>
	</head>
</xsl:template>

</xsl:stylesheet>
