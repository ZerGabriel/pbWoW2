pbWoW2-bbDKP130
-----------------
This MOD includes all the functionality needed to set the PBWoW 2 style running with bbDKP 1.3.0.8, raidplanner 1.0.1, apply 1.5.5, bbtips 1.0.4, Gameworld 1.1.4. It is AutoMOD compatible and requires UMIL.


@authors Sajaki, Paybas

## Version 

v2.1.0

## Requires

*	phpBB 3.0.12
*	pbWoW2
*	bbDKP 1.3.0.8
*	Raidplanner 1.0.1
*	bbTips 1.0.4
*	Apply 1.5.5
*	Gameworld 1.1.4
*	Prosilver style must be active but not default

## Installation

* uninstall pbWoW2_0_9 if installed
* unzip and upload PBWoW_bbdkp_2_1_0 into /store mods
* go to the Autmod tab and install
* browse to /install/index.php to update/install pbWoW2 to 2.1.0
* For pbWoW daughter styles you need to open theme/stylesheet.css and add this below :
	```
	@import url("../../pbwow2/theme/bbdkp.css");
	@import url("../../pbwow2/theme/raidplanner.css");
	@import url("../../pbwow2/theme/apply.css");
	@import url("../../pbwow2/theme/bbtips.css");
	@import url("../../pbwow2/theme/bossprogress.css");
	```	
* clear the templates and caches
 
## Changelog

2.1.0 
[CHG] merged base pbWoW2 mod with bbDKP to achieve a better integration.

## License

[GNU General Public License v2](http://opensource.org/licenses/gpl-2.0.php)

This application is opensource software released under the GPL. Please see source code and the docs directory for more details. If you use this software and find it to be useful, we ask that you retain the copyright notice below.

## Paypal donation

[![Foo](https://www.paypal.com/en_US/BE/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=sajaki9%40gmail%2ecom&lc=BE&item_name=bbDKP%20Guild%20management&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted)

