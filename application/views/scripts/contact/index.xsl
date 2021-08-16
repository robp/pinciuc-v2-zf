<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:date="http://exslt.org/dates-and-times" xmlns:str="http://exslt.org/strings">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'contact'"/>
  <xsl:with-param name="title" select="'Contact'"/>
  <xsl:with-param name="css" select="'contact'"/>

  <xsl:with-param name="content">
    <div id="c-left">
      <h2>Contact</h2>

      <p>I'd love to field your questions or hear your comments about the site, its contents, or whatever else is on your mind. So if you don't know my email address, please send me your thoughts using the form below.</p>

      <a name="comments"></a>
      <div id="comments" style="width:auto;">

        <div id="comments-content">

        <a name="comment_form"></a>


        <p>Submit your message here: (<strong>Bold</strong> = required field)</p>

        <xsl:value-of select="/contactForm" disable-output-escaping="yes"/>

<!--
        <form name="comment_submit" action="/contact_submit.php" method="post" onsubmit="javascript:return validateComments(this)">
        <input class="hidden" type="hidden" name="id" value=""/>
        <textarea name="comment" rows="4" cols="30"></textarea><br class="clear-both"/>
        <label for="name">*name:</label><input id="name" name="name" size="30" maxlength="254"/><br class="clear-both"/>

        <label for="email_address">*email:</label><input id="email_address" name="email_address" size="30" maxlength="254"/><br class="clear-both"/>
        <label for="url">url:</label><input id="url" name="url" size="30" maxlength="254" onfocus="javascript:if (!this.value.length) this.value='http://';"/><br class="clear-both"/>
        <p><label for="captcha_image"> </label><img id="captcha_image" src="/captcha/captcha.jpg" width="140" height="60" alt="This is a captcha-picture. It is used to prevent mass-access by robots. (see: www.captcha.net)"/></p>

        <label for="captcha_phrase"> </label>Please enter the phrase in the image above:<br class="clear-both"/>

        <p><label for="captcha_phrase">*</label><input id="captcha_phrase" name="captcha_phrase" size="10" maxlength="20"/></p>

        <br class="clear-both"/>

        <p class="float-left"><button type="submit" id="submit" name="submit">Send Message</button></p>

        <script type="text/javascript">
        document.write('<p class="float-right"><label class="wide" for="remember_me">remember me</label><input type="checkbox" class="checkbox" checkbox id="remember_me" name="remember_me" value="1" onclick="javascript:forgetCommentCookies(this)"/></p>');
        </script>
        <br/>
        </form>
-->

        </div> <!-- comments-content -->
      </div> <!-- comments -->

      <script type="text/javascript">
      <!-- //
      if (document.forms.comment_submit) {
        document.forms.comment_submit.name.value = comment_name;
        document.forms.comment_submit.email_address.value = comment_email_address;
        document.forms.comment_submit.url.value = comment_url;

        if (comment_name) {
          document.forms.comment_submit.remember_me.checked = true;
        }
      }
      // -->
      </script>
    </div> <!-- c-left -->

    <div id="c-right">

      <h3>recent entries</h3>

      <ul class="arrowed">
      <li><a href="/entry/222">google maps "street view"</a> [<a href="/entry/222#comments" title="0 comments">0</a>]</li>
<li><a href="/entry/219">on copy protection</a> [<a href="/entry/219#comments" title="1 comment">1</a>]</li>

<li><a href="/entry/211">last batch of photos from newfoundland</a> [<a href="/entry/211#comments" title="1 comment">1</a>]</li>
<li><a href="/entry/210">lightroom beta 4</a> [<a href="/entry/210#comments" title="2 comments">2</a>]</li>
<li><a href="/entry/209">gros morne photos, gear</a> [<a href="/entry/209#comments" title="0 comments">0</a>]</li>

<li><a href="/entry/208">round three of nfld</a> [<a href="/entry/208#comments" title="1 comment">1</a>]</li>
<li><a href="/entry/207">round two of nfld</a> [<a href="/entry/207#comments" title="0 comments">0</a>]</li>
<li><a href="/entry/206">first round of photos from nfld</a> [<a href="/entry/206#comments" title="0 comments">0</a>]</li>

<li><a href="/entry/205">newfoundland</a> [<a href="/entry/205#comments" title="0 comments">0</a>]</li>
<li><a href="/entry/204">vacation</a> [<a href="/entry/204#comments" title="2 comments">2</a>]</li>
      </ul>

      <br/>
      <h3>categories</h3>


      <ul class="arrowed">
      <li><a href="/archive/1">all</a> (10)</li>
<li><a href="/archive/category/1">technology</a> (14)</li>
<li><a href="/archive/category/2">culture</a> (4)</li>
<li><a href="/archive/category/3">personal</a> (38)</li>

<li><a href="/archive/category/4">misc</a> (13)</li>
<li><a href="/archive/category/17">photography</a> (32)</li>
<li><a href="/archive/category/18">entertainment</a> (14)</li>
<li><a href="/archive/category/20">business</a> (2)</li>
      </ul>

    </div> <!-- c-right -->
  </xsl:with-param>
</xsl:call-template>

</xsl:template>

</xsl:stylesheet>
