<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'photos'"/>
    <xsl:with-param name="title"><xsl:value-of select="/photoset/photo/title"/> / <xsl:value-of select="/photoset/title"/> / Photos</xsl:with-param>
    <xsl:with-param name="css" select="'photos-image'"/>

    <xsl:with-param name="content">
      <h2 id="gallery-title"><a href="/photos/gallery/galleryId/{/photoset/@id}"><xsl:value-of select="/photoset/title"/></a></h2>

      <div id="gallery-media-pagelist">
      <!--<select name="page" onchange="javascript:window.location='/photos/gallery/7/'+this.value;"><option value="1" selected="selected">1</option><option value="2">2</option></select> of 2&nbsp;&nbsp;<a href="/photos/gallery/7/2">Next</a>-->
      </div>

      <div id="gallery-image-container">
        <p id="photo-title"><strong><xsl:value-of select="/photoset/photo/title"/></strong>
            [<a href="#comment_form" onclick="javascript:show_comments()" title="0 comments">0</a>]
          </p>

        <p id="photo-zoom"><a href="javascript:;" onclick="javascript:window.open('/photos/gallery_zoom/7/1', 'gallery_zoom', 'resizable,toolbar=no,location=no,directories=no,status,menubar=no,width=1100,height=800,scrollbars'); return false;">view larger</a></p>

        <div id="photo">
          <a class="a-img" href="/photos/gallery/galleryId/{/photoset/@id}">
            <img>
              <xsl:attribute name="width"><xsl:value-of select="/photoset/photo/sizes/size[@label='Medium']/@width"/></xsl:attribute>
              <xsl:attribute name="height"><xsl:value-of select="/photoset/photo/sizes/size[@label='Medium']/@height"/></xsl:attribute>
              <xsl:attribute name="src"><xsl:value-of select="/photoset/photo/sizes/size[@label='Medium']/@source"/></xsl:attribute>
              <xsl:attribute name="alt"><xsl:value-of select="/photoset/photo/title"/></xsl:attribute>
            </img>          
          </a>
        </div>

        <div id="gallery-description">
          <p><xsl:value-of select="/photoset/photo/description"/></p>

          <!--<p>&raquo; This image also found in: <a href="/photos/gallery/10">Just Playing</a></p>-->
        </div>

        <div id="exif">
          <p class="float-left">Exposure Information:</p>

          <p id="exif-show-hide" class="float-right"><a href="javascript:hide_exif();">hide</a></p>
          <hr class="skinny"/>

          <table summary="The camera settings for this photo, as saved using the EXIF data format." id="exif-table">
          <!--
          <tr><th scope="row">Date/Time: </th><td>December 26th, 2003 at 5:51pm</td></tr><tr><th scope="row">Camera: </th><td><a href="/photos/gear.php#cam1">Canon EOS DIGITAL REBEL</a></td></tr><tr><th scope="row">Lens: </th><td><a href="/photos/gear.php#lens4">Canon EF 70-200mm f/4L USM</a></td></tr><tr><th scope="row">Focal Length: </th><td>200mm (320mm equiv.)</td></tr><tr><th scope="row">Aperture: </th><td>f/8</td></tr><tr><th scope="row">Exposure Time: </th><td>1/25 sec</td></tr><tr><th scope="row">ISO: </th><td>100</td></tr>
          -->
          </table>
        </div>

        <div id="comments" class="comments-media">

          <p class="float-left">0 comments on "<xsl:value-of select="/photoset/photo/title"/>":</p>
          <p id="comments-show-hide" class="float-right"><a href="javascript:hide_comments();">hide</a></p>
          <hr class="skinny"/>

          <div id="comments-content">
            <a name="comment_form"></a>

            <p>Leave your own comment here:</p>
            <form name="comment_submit" action="/photos/comment_submit.php" method="post" onsubmit="javascript:return validateComments(this)">
            <input class="hidden" type="hidden" name="gallery_id" value="7"/>
            <input class="hidden" type="hidden" name="media_id" value="1"/>
            <textarea name="comment" rows="4" cols="30"></textarea><br class="clear-both"/>
            <label for="name">*name:</label><input id="name" name="name" size="30" maxlength="254"/><br class="clear-both"/>
            <label for="email_address">*email:</label><input id="email_address" name="email_address" size="30" maxlength="254"/><br class="clear-both"/>

            <label for="url">url:</label><input id="url" name="url" size="30" maxlength="254" onfocus="javascript:if (!this.value.length) this.value='http://';"/><br class="clear-both"/>
            <div class="float-left"><button type="submit" id="submit" name="submit">Save comments</button></div>
            <script type="text/javascript">
            <![CDATA[
            <!--
            document.write('<div class="float-right"><label class="wide" for="remember_me">remember me</label><input type="checkbox" class="checkbox" checkbox id="remember_me" name="remember_me" value="1" onclick="javascript:forgetCommentCookies(this)"/></div>');
            //-->
            ]]>
            </script>
            <br/>
            </form>

            <p class="clear-both">* required (email will not be published)</p>
          </div> <!-- comments-content -->
        </div> <!-- comments -->
      </div>

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
