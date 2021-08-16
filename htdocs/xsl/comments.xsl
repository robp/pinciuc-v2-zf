<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="comments">
<xsl:param name="title"/>
<xsl:param name="post_id"/>

  <div id="comments">
  <!--
    <p class="float-left">0 comments on "<xsl:value-of select="$title"/>":</p>
    <p id="comments-show-hide" class="float-right"><a href="javascript:hide_comments();">hide</a></p>
    <hr class="skinny"/>

    <div id="comments-content">
      <script type="text/javascript">
      var idcomments_acct = '847b4bd40ecc75118dc3c85a5450c50a';
      var idcomments_post_id = '<xsl:value-of select="$post_id"/>';
      var idcomments_post_url;
      </script>
      <span id="IDCommentsPostTitle" style="display:none"></span>
      <script type='text/javascript' src='http://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>
    </div>
    -->
  </div>
</xsl:template>

</xsl:stylesheet>
