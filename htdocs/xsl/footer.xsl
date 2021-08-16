<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="standard-footer">
    <div id="footer">
      <div id="poweredByZF"><a href="http://framework.zend.com/" target="zfwindow"><img width="127" height="25" src="/images/PoweredBy_ZF_4DarkBG.png" alt="Powered By Zend Framework"/></a></div>
      <div id="poweredByText"><a href="/network">Powered by</a>: <a href="http://www.cisco.com/">cisco</a>, <a href="http://www.amd.com/">amd</a>, <a href="http://www.intel.com/">intel</a>, <a href="http://www.slackware.com/">slackware</a>, <a href="http://httpd.apache.org/">apache</a>, <a href="http://www.mysql.com/">mysql</a>, <a href="http://www.php.net/">php</a>, <a href="http://www.w3.org/Style/XSL/">xsl</a>. Valid <a href="http://validator.w3.org/check/referer">xhtml</a>, <a href="http://jigsaw.w3.org/css-validator/check/referer">css</a>.</div>
      <div id="copyrightText">Copyright &#169; 2003-<xsl:value-of select="$currentYear"/> Rob Pinciuc. All rights reserved.</div>
    </div> <!-- footer -->
</xsl:template>

</xsl:stylesheet>
