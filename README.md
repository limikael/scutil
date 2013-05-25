scutils
=======

Adds extra functionality on top of the "SCORM Cloud For WordPress" plugin. From the page of that plugin:

SCORM Cloud For WordPress enables you to manage and deliver training from within WordPress. Harnessing 
the SCORM Engine powered SCORM Cloud training delivery service, this plugin provides all version SCORM
compliance to any WordPress blog or WordPress Multi-Site installation, including BuddyPress support.

There is some functionality I was missing from that plugin, so I developed this plugin to add that in the 
form of WordPress short tags. The available short tags are:

Course preview button
---------------------

[scpreview courseid="my-course-id"]

This creates a button to let your users test a course without being registered. Obviously, in this case there will 
tracking of progress or completion for the user, but it can be useful for showcasing your courses on your
webpage.
