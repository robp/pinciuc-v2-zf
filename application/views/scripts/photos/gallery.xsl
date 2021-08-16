<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/formattingFunctions.xsl"/>

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'photos'"/>
    <xsl:with-param name="title"><xsl:value-of select="/photoset/title"/> / Photos</xsl:with-param>
    <xsl:with-param name="css" select="'photos'"/>

    <xsl:with-param name="content">
      <h2 id="gallery-title"><a href="/photos"><xsl:value-of select="/photoset/title"/></a> [<a href="#comment_form" onclick="javascript:show_comments()" title="0 comments">0</a>]</h2>

      <p id="gallery-date"></p>
      <p id="gallery-description"><xsl:value-of select="/photoset/description"/></p>

      <div id="gallery-pagelist" class="pagelist">
        <xsl:if test="/photoset/@pages > 1">
          Page:&#160;&#160;
            <xsl:if test="/photoset/@page > 1">
              <a><xsl:attribute name="href">/photos/gallery/galleryId/<xsl:value-of select="/photoset/@id"/>
                  <xsl:if test="/photoset/@page - 1 > 1">/page/<xsl:value-of select="/photoset/@page - 1"/></xsl:if>
                </xsl:attribute>Previous</a>&#160;
            </xsl:if>
            <select name="page" id="selectPageNumber">
              <xsl:call-template name="page-number">
                <xsl:with-param name="selected" select="/photoset/@page"/>
                <xsl:with-param name="numpages" select="/photoset/@pages"/>
              </xsl:call-template>
            </select>
            of <xsl:value-of select="/photoset/@pages"/>
            <xsl:if test="/photoset/@page &lt; /photoset/@pages">
              &#160;<a href="/photos/gallery/galleryId/{/photoset/@id}/page/{/photoset/@page + 1}">Next</a>
            </xsl:if>

            <script type="text/javascript">
            <xsl:comment>
            document.getElementById('selectPageNumber').onchange = function() {
              window.location='/photos/gallery/galleryId/<xsl:value-of select="/photoset/@id"/>' + (this.value > 1 ? '/page/'+this.value : '');
            }
            //</xsl:comment>
            </script>
        </xsl:if>
      </div>

      <div class="gallery-container">

        <div class="gallery">
          <ul>
            <xsl:for-each select="/photoset/photo">
              <li><a class="thumbnail" href="/photos/photo/galleryId/{/photoset/@id}/photoId/{@id}">
                  <img class="a-img">
                  <xsl:attribute name="width"><xsl:value-of select="sizes/size[@label='Thumbnail']/@width"/></xsl:attribute>
                  <xsl:attribute name="height"><xsl:value-of select="sizes/size[@label='Thumbnail']/@height"/></xsl:attribute>
                  <xsl:attribute name="src"><xsl:value-of select="sizes/size[@label='Thumbnail']/@source"/></xsl:attribute>
                  <xsl:attribute name="alt"><xsl:value-of select="title"/></xsl:attribute>
                  <xsl:attribute name="style">margin-top:<xsl:value-of select="(100 - sizes/size[@label='Thumbnail']/@height) div 2"/>px</xsl:attribute>
                  </img></a>
                  <a href="/photos/photo/galleryId/{/photoset/@id}/photoId/{@id}"><xsl:value-of select="@title"/></a></li> 
            </xsl:for-each>
          </ul>
        </div>

        <div id="comments" class="comments-gallery">

          <p class="float-left">0 comments on "<xsl:value-of select="/photoset/title"/>":</p>
          <p id="comments-show-hide" class="float-right"><a href="javascript:hide_comments();">hide</a></p>

          <hr class="skinny"/>

          <div id="comments-content">

            <!--
            <ul class="comment">
            <li><strong>Pavel</strong>: I am eager to see pictures out of this exellent lens. Please post some.</li>
            </ul>
            -->

            <a name="comment_form"></a>

            <p>Leave your own comment here:</p>
            <form name="comment_submit" action="/photos/comment_submit.php" method="post" onsubmit="javascript:return validateComments(this)">
              <input class="hidden" type="hidden" name="gallery_id" value="121"/>
              <textarea name="comment" rows="4" cols="30"></textarea><br class="clear-both"/>
              <label for="name">*name:</label><input id="name" name="name" size="30" maxlength="254"/><br class="clear-both"/>
              <label for="email_address">*email:</label><input id="email_address" name="email_address" size="30" maxlength="254"/><br class="clear-both"/>
              <label for="url">url:</label><input id="url" name="url" size="30" maxlength="254" onfocus="javascript:if (!this.value.length) this.value='http://';"/><br class="clear-both"/>

              <div class="float-left"><button type="submit" id="submit" name="submit">Save comments</button></div>
              <script type="text/javascript">
              <![CDATA[
              <!--
              document.write('<div class="float-right"><label class="wide" for="remember_me">remember me</label><input type="checkbox" class="checkbox" id="remember_me" name="remember_me" value="1" onclick="javascript:forgetCommentCookies(this)"/></div>');
              //-->
              ]]>
              </script>
            </form>

            <p class="clear-both">* required (email will not be published)</p>
          </div> <!-- comments-content -->
        </div> <!-- comments -->
      </div> <!-- gallery-container -->

      <script type="text/javascript">
      <![CDATA[
      <!--
      if (document.forms.comment_submit) {
        document.forms.comment_submit.name.value = comment_name;
        document.forms.comment_submit.email_address.value = comment_email_address;
        document.forms.comment_submit.url.value = comment_url;

        if (comment_name) {
          document.forms.comment_submit.remember_me.checked = true;
        }
      }
      if (document.getElementById('comments-content') && view_comments == 'false') {
        hide_comments();
      }
      if (document.getElementById('exif-table') && view_exif == 'false') {
        hide_exif();
      }
      //-->
      ]]>
      </script>
      
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
