<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'Network Setup'"/>
  <xsl:with-param name="css" select="'photos'"/>

  <xsl:with-param name="content">
    <h2>
      Network Setup
    </h2>

    <p>
     <a href="#background">Background</a> | 
     <a href="#components">Components</a> | 
     <a href="#servers">Servers</a> | 
     <a href="#images">Images</a>
    </p>

    <p>
      <br clear="all" />
    </p>

     <a name="background" id="background"></a> 

    <h4>
      Background
    </h4>

    <p>
      I'm a computer geek. I like to play with computers, build them, configure them, and generally go overkill on my home computing needs. I also like computer networking, and have always wanted my own network and server rack. Well it took about 8 years, from when I built my first home Linux server, for it all to come together, but at last I've nearly built the home network rack of my dreams! There are still a few more components to add and/or upgrade, but for the most part, it's done.
    </p>

    <p>
      <br clear="all" />
    </p>

     <a name="components" id="components"></a> 

    <h4>
      Components
    </h4>

    <p>
      My current server rack, a <a href="http://www.starcase.com">Starcase</a> 18U 25" deep steel square hole kit with casters, looks like this:
    </p>

    <table border="1" class="rack">
      <tr>
        <th></th>
        <th>Component(s)</th>
        <th> Notes </th>
      </tr>
      <tr>
        <th align="center"> U0<br /> (back) </th>
        <td align="center">
          <a href="http://www.apc.com/resource/include/techspec_index.cfm?base_sku=AP9211">APC Masterswitch AP9211</a> w/ <a href="http://www.apc.com/resource/include/techspec_index.cfm?base_sku=AP9606">AP9606 Management Card</a><br />
          <img width="296" src="/images/network/AP9211.png" alt="APC MasterSwitch AP9211" />
        </td>
        <td>
          The AP9211 provides remote reboot capability, which is useful in the event that a machine becomes inaccessible from the console or network. I can log into the AP9211 and power-cycle the device, which often is all that is needed to regain control over it.
        </td>
      </tr>
      <tr>
        <th align="center"> U18 </th>
        <td align="center" rowspan="2">
          <a href="http://www.cisco.com/en/US/products/hw/routers/ps380/products_data_sheet09186a008010e5c5.html">Cisco 837</a> + <a href="http://www.linksys.com/servlet/Satellite?c=L_Product_C2&amp;childpagename=US%2FLayout&amp;cid=1152745215776&amp;pagename=Linksys%2FCommon%2FVisitorWrapper&amp;lid=1577645678B01">Linksys WAP4400N</a><br />
          <img width="148" src="/images/network/837.png" alt="Cisco 837" /><img width="148" src="/images/network/WAP4400N.png" alt="Linksys WAP4400N" />
        </td>
        <td rowspan="2">
          The Cisco 837 router provides my DSL connection and handles routing and NAT for my network services. It also acts as firewall with stateful packet inspection, provides Intrusion Detection Service, is my VPN concentrator, and my local NTP and DHCP server. I even use the integrated 4-port 100Mbps switch for a couple devices that don't need gigabit speed. The WAP4400N provides reliable and secure wireless-N access to my LAN.
        </td>
      </tr>
      <tr>
        <th align="center"> U17 </th>
      </tr>
      <tr>
        <th align="center"> U16 </th>
        <td align="center">
          <a href="%3Ca%20href=">Dell 2161DS</a><br />
          <img width="296" src="/images/network/2161DS.png" alt="Dell 2161DS" />
        </td>
        <td>
          The 2161DS is a 16-port KVM switch with KVM-over-IP service, which is how I use it because I don't have a keyboard, mouse and monitor connected to it. I love that it uses ethernet cable and SIPs, which are easily routed and bundled in the rack, to replace the bulky traditional KVM cable mess. Provides complete out-of-band access to the consoles of the servers in the rack.
        </td>
      </tr>
      <tr>
        <th align="center"> U15 </th>
        <td align="center">
          <a href="http://www.dell.com/content/products/productdetails.aspx/pwcnt_2724?c=us&amp;cs=04&amp;l=en&amp;s=bsd">Dell PowerConnect 2724</a><br />
          <img width="296" src="/images/network/PC2724.jpg" alt="Dell PowerConnect 2724" />
        </td>
        <td>
          The 2724 is a solid, non-blocking web-managed 24-port gigabit ethernet switch, providing high-speed LAN connectivity for the whole house.
        </td>
      </tr>
      <tr>
        <th align="center"> U14 </th>
        <td align="center" rowspan="3">
          "<a href="#mighty">mighty</a>"<br />
          <img width="296" src="/images/network/LC-04.png" alt="Silverstone LC-04" />
        </td>
        <td rowspan="3">
          SNMP management and soon-to-be backup server. More information below.
        </td>
      </tr>
      <tr>
        <th align="center"> U13 </th>
      </tr>
      <tr>
        <th align="center"> U12 </th>
      </tr>
      <tr>
        <th align="center"> U11 </th>
        <td align="center" rowspan="4">
          "<a href="#mammoth">mammoth</a>"<br />
          <img width="296" src="/images/network/RM42200.png" alt="Chenbro RM42200" />
        </td>
        <td rowspan="4">
          File server. Stores all of my audio and video media for streaming to the various machines on the network, and provides network storage space for desktop machines throughout the house. It's also my secondary DNS server. More information below.
        </td>
      </tr>
      <tr>
        <th align="center"> U10 </th>
      </tr>
      <tr>
        <th align="center"> U9 </th>
      </tr>
      <tr>
        <th align="center"> U8 </th>
      </tr>
      <tr>
        <th align="center"> U7 </th>
        <td align="center" rowspan="4">
          "<a href="#massive">massive</a>"<br />
          <img width="296" src="/images/network/RM42200.png" alt="Chenbro RM42200" />
        </td>
        <td rowspan="4">
          Internet server. Serves my website, handles my email, is my primary DNS server, and my database server. More information below.
        </td>
      </tr>
      <tr>
        <th align="center"> U6 </th>
      </tr>
      <tr>
        <th align="center"> U5 </th>
      </tr>
      <tr>
        <th align="center"> U4 </th>
      </tr>
      <tr>
        <th align="center"> U3 </th>
        <td align="center">
          (blank)
        </td>
        <td>
          This rack space left empty because the UPS below gets quite warm.
        </td>
      </tr>
      <tr>
        <th align="center"> U2 </th>
        <td align="center" rowspan="2">
          <a href="http://www.apc.com/resource/include/techspec_index.cfm?base_sku=SUA1500RM2U">APC SUA1500RM2U</a><br />
          <img width="296" src="/images/network/SUA1500RM2U.png" alt="APC SUA1500RM2U" />
        </td>
        <td rowspan="2">
          Provides uninterrupted power to all of the gear in the rack. Useful with the brownouts, blackouts, power sags and surges that plague the older houses and neighborhoods of Toronto. Even with all of this gear plugged into the UPS, it is still only at 35% load.
        </td>
      </tr>
      <tr>
        <th align="center"> U1 </th>
      </tr>
    </table>

    <p>
      <br clear="all" />
    </p>

     <a name="servers" id="servers"></a> 

    <h4>
      Servers
    </h4>

     <a name="massive" id="massive"></a> 

    <p>
      <strong>"massive"</strong> - Internet server
    </p>
    <hr class="skinny" />

    <table border="0" width="100%" class="serverDescription">
      <tr>
        <td width="50%" valign="top">

          <p>
            <strong>Hardware</strong>
          </p>

          <table border="0">
            <tr>
              <th>
                Chassis
              </th>
              <td>
                Chenbro RM42200 4U Rackmount<br />
                (on Chenbro 84H342910-005 sliding rails)
              </td>
            </tr>
            <tr>
              <th>
                Power Supply
              </th>
              <td>
                Seasonic S12-380HB 380W ATX12V
              </td>
            </tr>
            <tr>
              <th>
                Motherboard
              </th>
              <td>
                Asus A7V8X-X
              </td>
            </tr>
            <tr>
              <th>
                Processor
              </th>
              <td>
                AMD Athlon XP 2400+ 256K L2 cache
              </td>
            </tr>
            <tr>
              <th>
                CPU Cooler
              </th>
              <td>
                Zalman CNPS7000A-AlCu
              </td>
            </tr>
            <tr>
              <th>
                Case Cooling
              </th>
              <td>
                1 x 120mm front intake fan<br />
                2 x 80mm rear exhaust fans
              </td>
            </tr>
            <tr>
              <th>
                Memory
              </th>
              <td>
                3 x 1GB Crucial Rendition PC3200 DDR400 (3GB total)
              </td>
            </tr>
            <tr>
              <th>
                System Hard Disk
              </th>
              <td>
                120GB Western Digital Caviar SE (WD1200JB) EIDE 8MB cache
              </td>
            </tr>
            <tr>
              <th>
                Additional Storage
              </th>
              <td></td>
            </tr>
            <tr>
              <th>
                Optical Drive
              </th>
              <td>
                Lite-On SOHW-1633S 16x DVD-RW Dual Layer
              </td>
            </tr>
            <tr>
              <th>
                Networking
              </th>
              <td>
                D-Link DGE-530T PCI Gigabit Ethernet
              </td>
            </tr>
            <tr>
              <th>
                Video Output
              </th>
              <td>
                S3 Virge DX 4MB SDRAM PCI
              </td>
            </tr>
          </table>

        </td>
        <td width="50%" valign="top">

          <p>
            <strong>Software</strong>
          </p>

          <table border="0">
            <tr>
              <th>
                Operating System
              </th>
              <td>
                Slackware Linux (kernel 2.6)
              </td>
            </tr>
            <tr>
              <th>
                Services
              </th>
              <td>
                HTTP, Darwin Streaming Server, SMTP, IMAP, DNS, MySQL, Samba
              </td>
            </tr>
          </table>

          <p>
            <strong>Notes</strong>
          </p>

          <p>
            "massive" is my oldest Linux server. It has been around for years in many forms, starting with a Pentium 166MHz MMX in a beige box, then an AMD K6 233MHz and an Athlon 800MHz, up to its current incarnation. It generally inherited parts when my desktop PC got upgraded. Most of the current guts come from my previous desktop PC (before my current Macbook, when I also had my <a href="/htpc/v2.php">second generation HTPC</a>), but the S3 Virge video card has been around since the start!
          </p>

          <p>
            Future upgrades may include mirroring the system drive, and moving to a more modern multi-core architecture with SATA disks and onboard gigabit networking and video. However, it handles its web- and mail-serving jobs quite easily for the time being.
          </p>

        </td>
      </tr>
    </table>

    <p>
      <br clear="all" />
    </p>

     <a name="mammoth" id="mammoth"></a> 

    <p>
      <strong>"mammoth"</strong> - File server
    </p>
    <hr class="skinny" />

    <table border="0" width="100%" class="serverDescription">
      <tr>
        <td width="50%" valign="top">

          <p>
            <strong>Hardware</strong>
          </p>

          <table border="0">
            <tr>
              <th>
                Chassis
              </th>
              <td>
                Chenbro RM42200 4U Rackmount<br />
                (on Chenbro 84H342910-005 sliding rails)
              </td>
            </tr>
            <tr>
              <th>
                Power Supply
              </th>
              <td>
                Seasonic S12-380HB 380W ATX12V
              </td>
            </tr>
            <tr>
              <th>
                Motherboard
              </th>
              <td>
                Intel Server Board SE7500CW2
              </td>
            </tr>
            <tr>
              <th>
                Processor
              </th>
              <td>
                2 x Intel Xeon 2.8GHz HyperThreading 512K L2 cache
              </td>
            </tr>
            <tr>
              <th>
                CPU Cooler
              </th>
              <td>
                2 x stock Intel Xeon heatsink w/ 80mm fan
              </td>
            </tr>
            <tr>
              <th>
                Case Cooling
              </th>
              <td>
                2 x 120mm front intake fan<br />
                2 x 80mm rear exhaust fans
              </td>
            </tr>
            <tr>
              <th>
                Memory
              </th>
              <td>
                4 x 1GB PC2100 ECC DDR266 (4GB total)
              </td>
            </tr>
            <tr>
              <th>
                System Hard Disk
              </th>
              <td>
                80GB Seagate Barracuda 7200.10 (ST380215A) EIDE 2MB cache
              </td>
            </tr>
            <tr>
              <th>
                Additional Storage
              </th>
              <td>
                3 x 500GB Seagate Barracuda 7200.10 (ST3500630AS) SATA2 16MB cache<br />
                in RAID5 (1TB total storage) on 3ware Escalade 9500S-4LP PCI-X controller
              </td>
            </tr>
            <tr>
              <th>
                Optical Drive
              </th>
              <td></td>
            </tr>
            <tr>
              <th>
                Networking
              </th>
              <td>
                Intel Pro/1000 MT Dual Port PCI-X Gigabit Ethernet
              </td>
            </tr>
            <tr>
              <th>
                Video Output
              </th>
              <td>
                ATI Rage XL 8MB SDRAM PCI (onboard)
              </td>
            </tr>
          </table>

        </td>
        <td width="50%" valign="top">

          <p>
            <strong>Software</strong>
          </p>

          <table border="0">
            <tr>
              <th>
                Operating System
              </th>
              <td>
                Slackware Linux (kernel 2.6)
              </td>
            </tr>
            <tr>
              <th>
                Services
              </th>
              <td>
                DNS, Samba, NFS, iTunes, Backup
              </td>
            </tr>
          </table>

          <p>
            <strong>Notes</strong>
          </p>

          <p>
            "mammoth" was, up until Sep. '07, the guts of <a href="/htpc/v1.php">my first HTPC</a> and serves as file server for "massive" and for my internal network. It has just been upgraded with the guts of an Intel dual Xeon server that I picked up cheaply in a local private sale.
          </p>

          <p>
            The ASUS A7V8X-X motherboard didn't have a PCI-X slot for the 3ware RAID adapter, so my disk transfer speeds were severely limited by the standard PCI 32-bit 33MHz slot, which, to make matters worse, shared its bandwidth with the D-Link PCI gigabit ethernet adapter. Now with the Intel server board, the RAID controller gets its own dedicated 64-bit 133MHz PCI-X bus, and a new Intel Pro/1000 MT dual gigabit ethernet card gets its own dedicated 64-bit 66MHz PCI-X bus.
          </p>

          <p>
            A lot more internal and network bandwidth is now available on this machine, not to mention horsepower from the dual 2.8GHz Xeons. It should easily be able to handle multiple audio and video streams to my network for quite some time.
          </p>

          <p>
            I would like to fill the three front 5.25" drive bays with a 4-in-3 or 5-in-3 SATA hotswap drive tray to place the drives from the RAID array in. I'm thinking of either the Icy Dock <a href="http://www.icydock.com/product/mb455spf.html">MB455SPF 5-in-3</a>, or the Chenbro <a href="http://usa.chenbro.com/corporatesite/products_detail.php?serno=78">SK33502 5-in-3</a>.
          </p>

        </td>
      </tr>
    </table>

    <p>
      <br clear="all" />
    </p>

     <a name="mighty" id="mighty"></a> 

    <p>
      <strong>"mighty"</strong> - Management server
    </p>
    <hr class="skinny" />

    <table border="0" width="100%" class="serverDescription">
      <tr>
        <td width="50%" valign="top">

          <p>
            <strong>Hardware</strong>
          </p>

          <table border="0">
            <tr>
              <th>
                Chassis
              </th>
              <td>
                SilverStone LC-04 (HTPC case, appx. 3U)<br />
                (on Starcase 2U fixed shelf)
              </td>
            </tr>
            <tr>
              <th>
                Power Supply
              </th>
              <td>
                TFX 300W PFC
              </td>
            </tr>
            <tr>
              <th>
                Motherboard
              </th>
              <td>
                Asus A7V8X-X
              </td>
            </tr>
            <tr>
              <th>
                Processor
              </th>
              <td>
                AMD Athlon XP-M 2500+ 512K L2 cache
              </td>
            </tr>
            <tr>
              <th>
                CPU Cooler
              </th>
              <td>
                Zalman CNPS7000B-AlCu
              </td>
            </tr>
            <tr>
              <th>
                Case Cooling
              </th>
              <td>
                1 x 80mm Vantec Stealth side exhaust fan
              </td>
            </tr>
            <tr>
              <th>
                Memory
              </th>
              <td>
                1 x 1GB, 2 x 512MB PC3200 DDR400 (2GB total)
              </td>
            </tr>
            <tr>
              <th>
                System Hard Disk
              </th>
              <td>
                160GB Seagate Barracuda 7200.7 (ST3160023A) EIDE 8MB cache
              </td>
            </tr>
            <tr>
              <th>
                Additional Storage
              </th>
              <td></td>
            </tr>
            <tr>
              <th>
                Optical Drive
              </th>
              <td>
                Sony CDU5211 ATAPI 52X CD-ROM
              </td>
            </tr>
            <tr>
              <th>
                Networking
              </th>
              <td>
                D-Link DGE-530T PCI Gigabit Ethernet
              </td>
            </tr>
            <tr>
              <th>
                Video Output
              </th>
              <td>
                Diamond Viper V770 (NVidia Riva TNT2 Ultra) 32MB SDRAM AGP
              </td>
            </tr>
          </table>

        </td>
        <td width="50%" valign="top">

          <p>
            <strong>Software</strong>
          </p>

          <table border="0">
            <tr>
              <th>
                Operating System
              </th>
              <td>
                Slackware Linux (kernel 2.6)
              </td>
            </tr>
            <tr>
              <th>
                Services
              </th>
              <td>
                HTTP, SNMP Monitoring
              </td>
            </tr>
          </table>

          <p>
            <strong>Notes</strong>
          </p>

     "mighty" is the newest addition to the rack, and is composed of most of the core parts from <a href="/htpc/v1.php">my first generation HTPC</a>, including the slick (but small) SilverStone case.

          <p>
            After "mammoth" was upgraded to the Intel server components, the Athlon 2500+ parts were left over, and I had the idea that I wanted to start doing SNMP monitoring of my network devices, and to create a "hardened" administration server that could not be accessed from the other machines on my network if they were ever compromised. It also fit in with the fact that I started using <a href="http://www.amanda.org/">AMANDA</a> for a centralized disk-to-disk network backup solution, and I didn't want all that backup data on either "massive" or "mammoth", since they are more accessible on the network.
          </p>

          <p>
            The final piece to my backup solution, which is yet to be added, is a device to actually store the backup data on. I have my eye on a pair of <a href="http://www.vantecusa.com/p_mrk250st.html">Vantec EZ Swap EX</a> removeable hard drive enclosures. They're like hot-swappable 2.5" hard disk "cartridges" that will make for backup disks when paired with a couple of Seagate 2.5" hard disks.
          </p>

          <p>
            Although it fits pretty well (and looks good) in my rack, I would like to swap out the SilverStone LC-04 chassis for a 2U rackmount <a href="http://usa.chenbro.com/corporatesite/products_detail.php?serno=30">Chenbro RM22300</a> with sliding rails. I'm running out of space in the rack and the extra 1U would be useful, and the sliding rails make maintenance a snap. Airflow and cooling in the SilverStone is sub-par as well, and I could use the extra expansion slot that the Chenbro offers.
          </p>

          <p>
            I would like to replace the D-Link gigabit ethernet card with an Intel Pro/1000 card, as the RJ45 socket fits pretty sloppily no matter what cable is used.
          </p>

        </td>
      </tr>
    </table>

    <p>
      <br clear="all" />
    </p>

     <a name="images" id="images"></a> 

    <h4>
      Images
    </h4>

    <p>
      Coming soon.
    </p>

    <div class="gallery-container">
      <div class="gallery">
        <div style="margin-left: 2em">
        </div>
      </div>
    </div>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



