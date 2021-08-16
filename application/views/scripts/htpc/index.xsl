<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'HTPC'"/>
  <xsl:with-param name="css" select="'photos'"/>

  <xsl:with-param name="content">
    <h3>Home Theatre PC (HTPC) v3.0</h3>

    <p>
    <a href="#background">Background</a> |
    <a href="#components">Components</a> | 
    <a href="#images">Images</a> | 
    <a href="#build">The Build</a> | 

    <a href="#config">Configuration and Testing</a> | 
    <a href="#overclock">Overclocking</a>
    </p>

    <p><br clear="all"/></p>

    <a name="background"></a>
    <h4>Background</h4>

    <p>I've finally moved over to <a href="http://www.apple.ca/">Apple</a> for my desktop computer use with the purchase of a Macbook last fall. Now that I don't have a desktop PC that is capable of much in the way of 3D gaming, I needed to upgrade the HTPC for gaming purposes. I also bought a new 1080p LCD TV, which demands more horsepower from the PC while running at 1920x1080 resolution.</p>

    <p>Additional capabilities of this machine over <a href="v2.php">the previous machine</a> include:</p>

    <ul>
    <li>- Significantly more powerful, quad core, Intel Core 2 Quad processor will allow DVD upscaling to 1080p (and 1080p Blu-ray if/when I can afford a drive) and provide a lot more horsepower for gaming.</li>
    <li>- More RAM and a much faster nVidia 8800-series video card for high-resolution gaming capability and DirectX 10 capability.</li>
    <li>- Larger 160GB hard disk with 7200RPM spindle speed for more storage and 25% faster I/O operation.</li>
    <li>- A new case, while not as sharp-looking as the previous one, allows for standard ATX power supplies and better cooling.</li>
    <li>- A new power supply with a thermally controlled 120mm fan for lower noise. It also has modular cabling for less clutter and better airflow inside the case.</li>

    </ul>

    <a name="components"></a>

    <table border="0" width="100%">
    <tr>
    <td valign="top" width="55%">
      <p><strong>Components</strong></p>

      <table border="0">
      <tr>
      <td valign="top">Case</td>

      <td rowspan="20" width="10"> &#160; </td>
      <td valign="top"><a href="http://www.silverstonetek.com.tw/products/p_contents.php?pno=lc17">SilverStone SST-LC17B (Black)</a></td>
      </tr>
      <tr>
      <td valign="top">Power Supply</td>
      <td valign="top"><a href="http://www.corsairmemory.com/products/hx.aspx">Corsair HX520W</a></td>

      </tr>
      <tr>
      <td valign="top">Motherboard</td>
      <td valign="top"><a href="http://www.gigabyte.com.tw/Products/Motherboard/Products_Overview.aspx?ProductID=2455&amp;ModelName=GA-965P-DS3P">Gigabyte GA-965P-DS3</a></td>
      </tr>
      <tr>
      <td valign="top">Processor</td>

      <td valign="top"><a href="http://www.intel.com/products/processor/core2duo/index.htm">Intel Core 2 Quad Q6600 (Kentsfield) 2.4GHz w/ 8MB L2 Cache</a></td>
      </tr>
      <tr>
      <td valign="top">Memory</td>
      <td valign="top"><a href="http://www.corsairmemory.com/products/xms2.aspx">4GB (4x1024GB) Corsair XMS2 PC2-5400 DDR2 @ 667MHz</a></td>
      </tr>
      <tr>

      <td valign="top">System Hard Disk</td>
      <td valign="top"><a href="http://www.fujitsu.ca/products/mobile_hdd/mht_bh/functional_specs.html">Fujitsu 80GB 5400RPM (MHT2080BH) SATA w/NCQ 8MB cache 2.5"</a></td>
      </tr>
      <tr>
      <td valign="top">Additional Storage</td>
      <td valign="top"><a href="http://www.seagate.com/ww/v/index.jsp?locale=en-US&amp;name=Momentus_7200.2_SATA_3.0Gb/s_160-GB_Laptop_Hard_Drive&amp;vgnextoid=546207c8108dd010VgnVCM100000dd04090aRCRD&amp;vgnextchannel=c021a47948a3d010VgnVCM100000dd04090aRCRD&amp;reqPage=Model">Seagate Momentus 7200.2 160GB 7200RPM (ST9160823AS) SATA2 w/NCQ 8MB cache 2.5"</a></td>
      </tr>

      <tr>
      <td valign="top">Networked Storage</td>
      <td valign="top"><a href="/network/#mammoth">1TB RAID5 array on "mammoth" file server</a></td>
      </tr>
      <tr>
      <td valign="top">DVD Drive</td>
      <td valign="top"><a href="http://www.pioneerelectronics.com/pna/v3/pg/product/details/0,,2076_310070061_427696257,00.html">Pioneer DVR-212D SATA DVD/CD Writer w/ Quiet Drive technology</a></td>

      </tr>
      <tr>
      <td valign="top">Sound Card</td>
      <td valign="top"><a href="http://www.auzentech.com/site/products/x-plosion.php">Auzentech HDA X-Plosion 7.1 DTS Connect</a></td>
      </tr>
      <tr>
      <td valign="top">Video Card</td>

      <td valign="top"><a href="http://evga.com/products/moreinfo.asp?pn=640-P2-N821-AR&amp;family=19">EVGA GeForce 8800GTS 640MB DDR3 500MHz Core 1.6GHz Memory</a></td>
      </tr>
      <tr>
      <td valign="top">TV Tuner/Capture Card</td>
      <td valign="top"><a href="http://www.hauppage.com/pages/products/data_pvr250.html">Hauppage! WinTV-PVR250</a></td>
      </tr>
      <tr>

      <td valign="top">HDTV Tuner/Capture Card</td>
      <td valign="top"><a href="http://www.fusionhdtv.co.kr/eng/Products/ATSC5Lite.aspx">DViCO FusionHDTV5 Lite</a></td>
      </tr>
      </table>

      <p><strong>Cooling</strong></p>

      <table border="0">

      <tr>
      <td valign="top">CPU Cooling</td>
      <td valign="top"><a href="http://www.thermalright.com/a_page/main_product_xp90.htm">Thermalright XP-90</a> w/<br/>
               <a href="http://www.nexustek.nl/92mm_real_silent_case_fan.htm">Nexus 92mm Real Silent case fan</a></td>
      </tr>
      <tr>

      <td valign="top">Video Cooling</td>
      <td valign="top"><a href="http://www.thermalright.com/a_page/main_product_hr03_plus.htm">Thermalright HR-03 Plus</a> w/<br/>
               <a href="http://www.nexustek.nl/92mm_real_silent_case_fan.htm">Nexus 92mm Real Silent case fan</a></td>
      </tr>
      <tr>
      <td valign="top">Case Cooling</td>

      <td valign="top">
    Front intake: 2 x <a href="http://www.nexustek.nl/92mm_real_silent_case_fan.htm">Nexus 92mm Real Silent case fan</a><br/>
    Rear exhaust: 2 x <a href="http://www.nexustek.nl/80mm_real_silent_case_fan.htm">Nexus 80mm Real Silent case fan</a><br/>
    Side exhaust: 1 x <a href="http://www.nexustek.nl/80mm_real_silent_case_fan.htm">Nexus 80mm Real Silent case fan</a>
    </td>
      </tr>
      </table>
    </td>

    <td width="10"> &#160; </td>
    <td valign="top" width="45%">
      <p><strong>Input Devices:</strong></p>

      <table border="0">
      <tr>
      <td valign="top">Remote Control</td>
      <td rowspan="10" width="10"> &#160; </td>

      <td valign="top"><a href="http://nadelectronics.com/products/remotes/HTR-2-Remote-Control/">NAD HTR-2 Remote Control</a></td>
      </tr>
      <tr>
      <td valign="top">Keyboard and Mouse</td>
      <td valign="top">Gyration Ultra GT Wireless Suite (<a href="http://www.gyration.com/en-US/ProductDetail.html?modelnum=GC1105CKM&amp;accshow=3">Similar to this model</a>)</td>
      </tr>

      <tr>
      <td valign="top">Game Controllers</td>
      <td valign="top">2 x <a href="http://www.logitech.com/index.cfm/gaming/pc_gaming/gamepads/devices/287&amp;cl=ca,en">Logitech Cordless <span style="white-space: nowrap">Rumblepad 2</span></a><br/>
    <a href="http://www.logitech.com/index.cfm/mice_pointers/mice/devices/163&amp;cl=us,en">Logitech G7 Laser Cordless Mouse</a><br/>
    <a href="http://accessories.us.dell.com/sna/productdetail.aspx?c=us&amp;l=en&amp;s=dhs&amp;cs=19&amp;sku=310-8038">Dell USB Keyboard</a></td>
      </tr>
      </table>

      <p><strong>Software:</strong></p>

      <table border="0">
      <tr>
      <td valign="top">Operating System</td>
      <td rowspan="10" width="10"> &#160; </td>
      <td valign="top"><a href="http://www.microsoft.com/windows/products/windowsvista/editions/homepremium/default.mspx">Microsoft Windows Vista Home Premium 32-bit</a></td>

      </tr>
      <tr>
      <td valign="top">Main Interface</td>
      <td valign="top"><a href="http://www.snapstream.com/Products/beyondmedia/">Snapstream Beyond Media</a></td>
      </tr>
      <tr>
      <td valign="top">TV/PVR</td>

      <td valign="top"><a href="http://www.snapstream.com/Products/beyondtv/default.asp">Snapstream <span style="white-space: nowrap">Beyond TV 4</span></a></td>
      </tr>
      <tr>
      <td valign="top">DVD Player</td>
      <td valign="top"><a href="http://www.theatertek.com/">TheaterTek <span style="white-space: nowrap">DVD 2.5</span></a></td>
      </tr>

      <tr>
      <td valign="top">Games</td>
      <td valign="top"><a href="http://www.gamespot.com/users/rpinciuc/games_table?mode=playing">My "Now Playing" list at Gamespot</a></td>
      </tr>

      </table>

      <p><strong>A/V Components:</strong></p>

      <table border="0">
      <tr>
      <td valign="top">Television</td>
      <td rowspan="10" width="10"> &#160; </td>
      <td valign="top"><a href="http://www.sharp.ca/products/index.asp?cat=30&amp;id=678">Sharp AQUOS 37" 1080p LCD TV (LC37D62U)</a></td>
      </tr>

      <tr>
      <td valign="top">Home Theatre Receiver</td>
      <td valign="top"><a href="http://nadelectronics.com/products/av-receivers/T763-A/V-Receiver">NAD T763 A/V Receiver</a></td>
      </tr>
      <tr>
      <td valign="top">DVD / CD Player</td>
      <td valign="top"><a href="http://207.228.230.231/manual/NAD-T533(GB).pdf">NAD T533 DVD / CD Player</a></td>

      </tr>
      <tr>
      <td valign="top">Speakers</td>
      <td valign="top">
    Front: 2 x <a href="http://www.psbspeakers.com/product.php?pId=69&amp;sId=4">PSB Alpha B</a><br/>
    Rear: 2 x <a href="http://www.psbspeakers.com/product.php?pId=69&amp;sId=4">PSB Alpha B</a><br/>
    Centre: <a href="http://www.psbspeakers.com/product.php?pId=70&amp;sId=4?PHPSESSID=90c89bb2660053cb4fc3332dc864620c">PSB Alpha C</a><br/>

    Sub: PSB Image Subsonic6 (<a href="http://www.psbspeakers.com/product.php?pId=25&amp;sId=5">Similar to this model</a>)</td>
      </tr>
      </table>
    </td>
    </tr>
    </table>

    <p><br clear="all"/></p>

    <a name="images"></a>
    <h4>Images</h4>

    <p>Coming soon.</p>


    <div class="gallery-container">
      <div class="gallery">
      </div>
    </div>


    <p><br clear="all"/></p>

    <a name="build"></a>
    <h4>The Build</h4>

    <p>Once again, there were no significant issues building this system, and again, there were just a few minor issues that I was able to work out with little trouble.</p>

    <p>The Thermalright XP-120 is not designed for LGA775 socket processors, so I had to buy an adapter kit which worked out perfectly. Once again, the heatpipes of the XP-120 <em>barely</em> fit without interfering with other motherboard components, especially the RAM modules, but they do fit.</p>

    <p>The SilverStone LC-17 case is nice, but not as well built as the Ahanix from the <a href="v2.php">previous build</a> (it would be hard to top that one). The Silverstone has a nice, solid aluminum front bezel, but the rest of the case is the usual grey steel found in cheaper chassis. The slot where the DVD drive tray slides through the front panel is slightly low and because of this, the drive tray just <em>barely</em> fits through. There might be 1mm of clearance! Again, I wish the case was available in the gunmetal grey of my NAD gear. I'm happy that the case accepts standard 80mm fans in the back and has provisions for two 92mm fans in the front of the hard disk cages. It also came with reuseable slot covers, an improvement over the snap-off covers on the Ahanix. I replaced the covers on the vacant slots with vented covers left over from a recent server build for better airflow out the back of the case. Lastly, I replaced the stock 80mm ball-bearing fans with Nexus 80mm fans, so I can't report on the noise level of the SilverStone fans.</p>

    <p>Much to my disappointment, my (expensive) Plextor SATA DVD writer from the previous build died right around the time of this build, so I replaced it with a cheaper Pioneer SATA writer. So far this drive has been excellent, very quiet when watching DVDs and fast when reading data discs.</p>

    <p>My hard disk suspension system on the last build was replaced with a 2.5" to 3.5" hard disk adapter and screwed into the drive cage. So far this doesn't seem to have added to noise levels, but I'll look into this further and may go back to a suspension system if I can find a reason to.</p>

    <p><br/></p>

    <a name="config"></a>
    <h4>Configuration and Testing</h4>

    <p>Configuration is the same as the <a href="v2.php">previous build</a>, with the exception that I'm now running at 1920x1080 (1080p) resolution. The TV has this same resolution, so I'm finally getting a 1:1 direct pixel mapping, not scaled like on the Prima plasma TV I was using. The plasma was great though, and even though all signals were scaled to its 1024x768 non-square pixel configuration, it was smooth and very film like, whereas the Sharp LCD is "sharp" and not forgiving if scaling is used. It looks terrific at 1920x1080 though, and I will need to get a video card that can push that resolution for gaming, such as a GeForce 8800GTS or 8800GTX.</p>

    <p>So far I haven't been able to tune into any HD stations using the FusionHDTV ATSC tuner (or the TV's built-in tuner) because my new location doesn't have good line of sight to the CN Tower. I believe I'll need to install a rooftop antenna to receive over-the-air signals. More on that in the future.</p>


    <br/>
    <hr/>
    <br/>

    <h4>Updates</h4>

    <p><strong>11 Oct '08</strong>: I've added the GeForce 8800GTS to the system, which replaces the old GeForce 7600GS, and this new card coupled with the Thermalright HR-03 for cooling is <em>huge</em> inside of this relatively compact HTPC chassis. I've oriented the HR-03+fan combo to "wrap around" the video card, thereby facing towards the Thermalright XP-120 CPU cooler. It <em>just</em> fits, with literally &lt;1mm of space between the HR-03's fan and the XP-120's fan.</p>

    <p>With this space issue noted, combined with the fact the the XP-120 heatpipe ends actually touch the rear 80mm exhaust fan grilles, and that the XP-120 leaves no room for an 80mm side exhaust fan, I've decided to swap out the XP-120 for a Thermalright XP-90. This is the slightly more compact 92mm-fan version of the XP-120. It should resolve the space issues around the CPU socket area, and allow me to drop in another 80mm fan in the side exhaust space of the LC-17 chassis. Another update in a couple days when this is all installed.</p>

    <a name="overclock"></a>
    <p><strong>Overclocking</strong></p>

    <p>I've also begun playing with overclocking of the CPU. I discovered that, fortunately, I have the newer G0/SLACR revision of the Q6600, which has better thermal properties than earlier revisions such as the B3. For reference, The Q6600 normally runs at 2.4GHz (9x multiplier, 266Mhz bus) with a 1066MHz FSB (266MHz bus, quad pumped), and my Corsair PC2-5400 RAM normally runs at 667Mhz (4:5 FSB:DRAM ratio, so 266Mhz bus x 1.25 = 333Mhz, x2 for Dual Data Rate).</p>

    <p>I was able to run my Q6600 for several hours at 2.66GHz (8x multiplier, 333MHz bus) with a 1333MHz FSB (333MHz bus, quad pumped), using stock voltages, while playing Enemy Territory: Quake Wars, and it was completely stable. This gives me hope that, if I can cool it adequately, I'll be able to run the CPU at 3GHz by simply resetting the multipler to 9x, which is the stock anyway.</p>

    <p>The motherboard and RAM were stable at the significantly higher 333MHz bus speed, with the RAM now running at 833MHz (333MHz bus x 1.25 = 417MHz, x2 for DDR). The RAM is in dual-channel mode, though, which means effectively it's running at 1666MHz, thus the bottleneck is the CPU FSB. That fact, and that the RAM timings were a bit slow at the 833MHz speed (it's only rated for 667MHz!) means I will probably change the FSB:DRAM ratio to 1:1, which will bring the RAM back down to 667MHz (333MHz, x2 for DDR), and an effective speed of 1333MHz (thanks to dual-channel) to match the CPU FSB. That should get those timings down to ideal levels again!</p>

    <p>The CPU did run hotter than I'd prefer, and I hope the extra 80mm exhaust fan that I'll be adding to the side of the case, adjacent to the CPU, will help with that. I'll also try blowing the VGA cooler's fan across the CPU heatsink to keep more air running through its fins.</p>

    <p>It has yet to be tested how the PCI devices (like TV tuners) will hold up with the increased bus speed, as they're now effectively running at 42MHz instead of the stock 33MHz (333MHz bus &#247; 8).</p>

    <p><strong>12 Oct '08</strong>: After reading a great <a href="http://www.tomshardware.com/2007/01/18/overclocking-guide-part-1/">overclocking guide</a> on <a href="http://www.tomshardware.com">Tom's Hardware</a>, I got my Q6600 running at a stable 3GHz (9x multipler, 333MHz bus) with a 1333MHz FSB (333MHz bus, quad pumped). Now my Q6600 is effectively a stock Core 2 Extreme QX6850, which is a 4x more expensive processor at <a href="http://www.ncix.com/products/index.php?sku=25345&amp;vpn=BX80562QX6850&amp;manufacture=Intel">almost $1200CAD</a>! I haven't even increased the voltages, so I bet it could go quite a bit higher, but I do want to keep this CPU for many years (it'll become <a href="/network/#massive">"massive", my Internet server</a> eventually) so I might just leave it as is and work on quieting the system down some more.</p>

    <p>I setup the RAM at a 1:1 FSB:DRAM ratio and increased the stock voltage by 0.2v, so it is running at its <a href="http://www.corsairmemory.com/_datasheets/CM2X1024-5400C4.pdf">factory spec'd</a> 667MHz and 4-4-4-12 timings at 2.0v. Of course, it's in dual-channel mode, so it effectively matches the bandwidth of the CPU FSB at 1333MHz, which is ideal.</p>

    <p>The only PCI device I'm currently using is the Auzentech HDA X-Plosion sound card, and it had no problems working at the new 42MHz PCI bus speed (333MHz &#247; 8). I'll post more about my TV tuners once they're installed.</p>

    <p>Another improvement made last night was airflow in the rear of the case. I flipped the VGA cooling fan around so that it blows air across the CPU HSF, giving it a double dose of cooling. I also turned off the smart fan control in the BIOS, so that the Nexus 120mm fan on the CPU delivers much better cooling performance, running at around 1000RPM instead of the 600RPM it was usually running at. Even overclocked, the CPU was running at a fairly cool 46&#176; C after playing ET:QW for a few hours.</p>

    <p>Lastly, I began tinkering with <a href="http://www.guru3d.com/rivatuner/">RivaTuner</a> to overclock the EVGA GeForce 8800GTS video card slightly. I bumped it from the factory 500MHz core and 1.6GHz memory clocks to 550MHz core and 1.7GHz memory. A modest, but appreciated, improvement. No cooling or stability issues yet, but more testing will be required.</p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



