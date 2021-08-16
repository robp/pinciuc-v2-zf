<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:param name="imageUrl" />
<xsl:param name="imageTitle" />

<xsl:template match="/">
<html>

<head>
<title><xsl:value-of select="$imageTitle"/></title>
</head>

<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">

<script type="text/javascript">
<![CDATA[
<!--
// Set the focus to the image window
focus();

var borderWidth = 15;
var borderHeight = 15;

// Resize the Window
if (navigator.appName == 'Netscape' && navigator.appVersion.indexOf('5.') == -1)
        window.resizeTo(borderWidth, borderHeight);
else
        window.resizeTo(borderWidth + 12, borderHeight + 31);
//-->
]]>
</script>

<xsl:call-template name="messages" />

<img src="{$imageUrl}" alt="{$imageTitle}"/>

</body>

</html>
</xsl:template>

</xsl:stylesheet>
