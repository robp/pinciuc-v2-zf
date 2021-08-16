<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="google-analytics">
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"><xsl:comment/></script>
<script type="text/javascript">
<xsl:text disable-output-escaping="yes">
<![CDATA[<!--
_uacct = "UA-77110-1";
urchinTracker();
-->]]>
</xsl:text>
</script>
</xsl:template>

<xsl:template name="google-maps">
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAzknsFRAwbTOgKCLJgbTj5hRk3l1Td_LoGU4SvoDYk07rreqVDhRrdjAEx15C4j78h6K4lrDgMPfijA" type="text/javascript"><xsl:comment/></script>
</xsl:template>

</xsl:stylesheet>


