<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'photos'"/>
    <xsl:with-param name="title" select="'Photos'"/>
    <xsl:with-param name="css" select="'photos'"/>

    <xsl:with-param name="content">
      <h2>Photographic Equipment</h2>

      <p>* Previously Used</p>

      <table border="0" width="100%">
      <tr>
      <td valign="top">
      <p><b>Cameras</b></p>
      <ul>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=843&amp;sgid=23&amp;gid=2&amp;ovr=1">Canon EOS 5D</a></li>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=433&amp;sgid=23&amp;gid=2&amp;ovr=1&amp;arch=1">Canon EOS 10D</a></li>

      <li>* <a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=525&amp;sgid=23&amp;gid=2&amp;ovr=1&amp;arch=1">Canon EOS Digital Rebel</a></li>
      </ul>

      <p><b>Lenses</b></p>
      <ul>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=1204&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF 16-35mm f/2.8L II USM</a></li>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=963&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF 50mm f/1.8 II</a></li>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=983&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF 70-200mm f/4L IS USM</a></li>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=978&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon Extender EF 1.4x II</a></li>
      <li><a href="http://www.mir.com.my/rb/photography/hardwares/classics/olympusom1n2/shared/zuiko/htmls/21mm.htm#f/3.5">Olympus Zuiko OM 21mm f/3.5</a></li>

      <li><a href="http://www.contaxcameras.co.uk/slr/slrmanlenses/distagon28.asp">Carl Zeiss Distagon T* 28mm f/2.8</a></li>
      <li><a href="http://www.contaxcameras.co.uk/slr/slrmanlenses/distagon3528.asp">Carl Zeiss Distagon T* 35mm f/2.8</a></li>
      <li><a href="http://www.contaxcameras.co.uk/slr/slrmanlenses/planar5017.asp">Carl Zeiss Planar T* 50mm f/1.7</a></li>
      <li><a href="http://www.contaxcameras.co.uk/slr/slrmanlenses/sonnar85.asp">Carl Zeiss Sonnar T* 85mm f/2.8</a></li>
      <li><a href="http://www.contaxcameras.co.uk/digital/nlenses/variosonnar2485.asp">Carl Zeiss Vario-Sonnar T* 24-85mm f/3.5-4.5</a></li>
      <li>* <a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=960&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF-S 18-55mm f/3.5-5.6</a></li>
      <li>* <a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=1006&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF 17-40mm f/4L USM</a></li>
      <li>* <a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=961&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF-S 17-85mm f/4-5.6 IS USM</a></li>

      <li>* <a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=983&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF 70-200mm f/4L USM</a></li>
      <li>* <a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=971&amp;sgid=7&amp;gid=2&amp;ovr=1">Canon EF 400mm f/5.6L USM</a></li>
      </ul>

      <p><b>Filters</b></p>
      <ul>
      <li><a href="http://www.thkphoto.com/products/hoya/gf-04.html">Hoya 77mm Super-HMC Circular Polarizer</a></li>
      <li><a href="http://www.bhphotovideo.com/bnh/controller/home?O=productlist&amp;A=details&amp;Q=&amp;sku=9772&amp;is=REG&amp;addedTroughType=search">B+W 55mm MRC Circular Polarizer</a></li>
      <li>* <a href="http://www.cokin.fr/cokin-data/composants2/pages-filtres/filtre-120st.html">Cokin P Series Graduated Neutral Density</a></li>

      </ul>
      </td>

      <td valign="top">
      <p><b>Supports</b></p>
      <ul>
      <li><a href="http://www.gitzo.com/Jahia/site/gitzo/pid/4765?kindOfProductCollectionRequest=productDetail&amp;productCode=GT1530&amp;productDescription=Mountaineer%206X%20tripod&amp;curBrandId=BGI&amp;market=MKT1&amp;actualPathCategoryKey=1CAT:AAA1:2CAT:BB59">Gitzo GT1530 Mountaineer Tripod</a></li>
      <li><a href="http://reallyrightstuff.com/ballheads/02.html">Really Right Stuff BH-55 Ballhead w/ B2 AS II clamp</a></li>
      <li><a href="http://reallyrightstuff.com/ballheads/02.html">Really Right Stuff BH-40 Ballhead w/ B2 AS II clamp</a></li>
      <li><a href="http://www.bogenimaging.us/code/bius/676B">Manfrotto 676B DIGI Monopod (Black)</a></li>
      <li><a href="http://www.bogenimaging.us/code/bius/234RC">Manfrotto 234RC Monopod Tilt Head with Quick Release</a></li>

      <li>* <a href="http://www.bogenimaging.us/code/bius/055CLB">Manfrotto 055CLB (Black) Tripod</a></li>
      <li>* <a href="http://www.bogenimaging.us/code/bius/486RC2">Manfrotto 486RC2 Ball Head with Rapid Connect System</a></li>
      </ul>

      <p><b>Accessories</b></p>
      <ul>
      <li><a href="http://www.canon.ca/english/index-products.asp?lng=en&amp;prodid=954&amp;sgid=7&amp;gid=2&amp;ovr=1&amp;arch=1">Canon Speedlite 420EX Flash</a></li>
      <li><a href="http://www.cameraquest.com/frames/4saleReos.htm">CameraQuest Lens Adapters</a></li>
      <li><a href="http://www.pelican.com/cases_detail.php?Case=1450">Pelican 1450 Case</a></li>
      <li><a href="http://www.pelican.com/cases_detail.php?Case=1300">Pelican 1300 Case</a></li>
      <li><a href="http://products.lowepro.com/product/Rover-Plus-AW,2025,14.htm">Lowepro Rover Plus AW</a></li>
      <li><a href="http://products.lowepro.com/product/Topload-Zoom-1,2051,8.htm">Lowepro Topload Zoom 1</a></li>
      <li><a href="http://www.sandisk.com/Products/ProductInfo.aspx?ID=1147">SanDisk ImageMate CompactFlash Reader/Writer</a></li>
      <li>* <a href="http://www.bhphotovideo.com/c/product/297502-REG/Canon_8865A001_BG_E1_Vertical_Grip_Battery_Holder.html">Canon Battery Grip BG-E1</a></li>
      </ul>

      <p><b>Software</b></p>
      <ul>
      <li><a href="http://www.adobe.com/products/photoshoplightroom/">Adobe Photoshop Lightroom</a></li>
      <li><a href="http://www.adobe.com/products/photoshop/">Adobe Photoshop CS2</a></li>

      <li><a href="http://www.epaperpress.com/ptlens/">ePaperPress PTLens 16-bit</a></li>
      <li>* <a href="http://www.tawbaware.com/ptasmblr.htm">TawbaWare PTAssemler</a></li>
      <li>* <a href="http://www.phaseone.com/content/software/lesoftware.aspx">Phase One Capture One LE</a></li>
      </ul>
      </td></tr>
      </table>
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
