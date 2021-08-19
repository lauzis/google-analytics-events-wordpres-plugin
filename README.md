# Events Google Analytics - Wordpres Plugin
Plugin that extends basic google analytics script with events, that can be later used to set up goals in google analytics.

== Description ==
Plugin that extends basic google analytics script with events, that can be later used to set up goals in google analytics.
While working in small web agency we noticed that most of users that uses google analytics knows almost nothing about google analytics events.

But those are essential if you want to understand more about what happens inside the webpage not only count visits.

As we were asked what works and what does not work in particular website, we had to add our own events, and soon we found out that there is part of events that overlap from project to project. So we created a script that could be added to almost any web project.

So this script adds such events:

*   Time triggered events.
*   Clicks on social profile links.
*   Clicks on contact links (email address, phone numbers)
*   Search form tracking
*   File downloads
*   Cta buttons
*   Form field tracking
*   Form submissions
*   Outgoing links
*   Newsletter subscription tracking

All these events helps to set up goals in google analytics and helps customers understand what works, and what has to be changed or improved.

== Donate ==

[Paypal](https://www.paypal.me/Lauzis)

[Paypal Wp Plugin Support](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=aivars.lauzis@gmail.com&lc=US&item_name=Donation+for+Google+Analytics+Event+Wordpres+Plugin+Support+And+Development&no_note=0&cn=&currency_code=USD&bn=PP-DonationsBF:btn_donateCC_LG.gif:NonHosted)  

BTC: 3FtCcedzVcuQEBWTbbjLQBgWiBbNgT8cQG

BCH: qr3ed287kxc9ncukadceanfkqtshaqvg0g68j57pjz

ETH: 0xc9681216a25Ac99500482Bd419b4644882a31471

== Todo log ==

0.9.11 Help text on front.

0.9.12 Donate links

1.0.0 Publishing, drinking beer

1.0.1 Rewrite the js code as the object

1.0.2 Rewrite code that it would not rely on jQuery

1.0.3 New features 

1.0.4 Issue with outgoing links thats are without http(s):// for examle href="www.google.lv" 

1.0.5 Comma seperated field redo

1.0.6 Custom link tracking, allow to add titles for links to use in event.

1.0.7 Histry retracking, sometimes usefull for contact forms to see from what section user arrived, to see if some section
generates more leads.

1.0.8 Write help/about how to check what code is in page, maybe write test script, that tries to figure out

1.0.9 Posibility switch off/on tracking from frontend?

1.0.10 Possibility to change log path, that it would be the uploads dir.

1.0.11 Move file extension settings outside.    

1.0.12 Debug only for admin, or admin loged in

1.0.13 Some addmin text will be hard to reach for translations, should get them out of ifs branches assing to variables - get translations beforehand, and use those in places, or do something similar. Or do it standart way, Without using custom function, cause custom function needed only to retrieve texts from json config file.

1.0.14 Collapse all.

== Known issues (that are worth mention)==

1. Form submission tracking, there is possible to pass without triggering Form used event. Field change is trigered only after lost focus, to that field. Have to think about better implementation.

== Changelog ==
0.9.11.1  erro when debugger not enabled fixed

0.9.11 Translations po/mo files

0.9.10 Check install uninstall scripts

0.9.9 Proof reading, fixing the pigeon English

0.9.9 Bug fixing

0.9.8 Give someone to test, get feedback
    - setup
    - changing settings
    - debugging mode
    - debugging mode by ip

0.9.7 Check todos in the code
 - some todos resolved some moved to todo/feature list of readme
 - color debug panel added to switch on of the colors
 - some js fixes, in event tracker

0.9.6 Fill the missing code parts
 - implemented tracking of froms subimtions, for field use, gravity forms success, mailchim success
 - removed some noise from debug
 - added console log outputs also
 - some styling done
 - most traackers tested

0.9.5 Debug settings implementation frontend
 - css that shows the elements that will trigger ga event
 - css that will show that user is in debug mode


0.9.4 Debug settings implementation backed

 - Include js according to debug settings 
 - Include inline google analytics according to debug settings
 - Debug code settings by ip


0.9.3 - Usable, but some parts not implemented yet, but a lot of work have been done

 - Plugin settings done.
 - Error messages, warning messages of plugin implemented
 - Some settings page styling done
 - Can add google analytics code or google tag manager code via plugin
 - Combines all js parts into one file, that is included in footer
 - So will track some events already
 - Generates also stand-alone script that can be used without the plugin. For use in different sites than wordpress.
 - File naming fixes

0.9.2 - Spitting up the google analytics code. <br/>
The plugin was based on google analytics javascript code that i was working on in collaboration with SEO Specialist Mārtiņš Groza (https://lv.linkedin.com/in/martins-groza-a104a690) when we both were employees of Digitalscore (http://www.digitalscore.lv/) <br/>
So at starting point the common parts of that script, that can be used in any project, was split into several sections, that could be switched on or off.

0.9.1 - Setup, Initial version <br/>
Based upon one plugin template, that is a bit outdated, and almost nothing have left of, but still want to give credit to the author of that plugin template
1manfactory.com (1manfactory.com/donate) <br>

