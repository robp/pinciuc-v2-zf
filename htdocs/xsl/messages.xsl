<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="messages">
<xsl:param name="width" select="'100%'" />

  <xsl:if test="count(/messages/*) > 0">
    <div id="messages" style="width: {$width}">
      <xsl:if test="count(/messages/error) > 0">
        <fieldset id="errorMessages">
        <legend>Errors</legend>
        <xsl:for-each select="/messages/error">
          <ul class="error">
            <xsl:for-each select="*">
              <li>
                <xsl:value-of select="name(.)"/> : <xsl:value-of select="." />
              </li>
            </xsl:for-each>
          </ul>
        </xsl:for-each>
        </fieldset>
      </xsl:if>

      <xsl:if test="count(/messages/info) > 0">
        <fieldset id="infoMessages">
        <legend>Messages</legend>
        <xsl:for-each select="/messages/info">
          <ul class="info">
            <xsl:for-each select="value">
              <li>
                <xsl:value-of select="." />
              </li>
            </xsl:for-each>
          </ul>
        </xsl:for-each>
        </fieldset>
      </xsl:if>
    </div>
  </xsl:if>
</xsl:template>

</xsl:stylesheet>
