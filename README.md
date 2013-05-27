scutil
======

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

Course toplist
--------------

[sctoplist courseid="my-course-id" columns="columns-to-include"]

Shows a toplist of the learners for a particular course. The optional columns attribute selectes what information
to include in the toplist, and should be a comma separated list. The available columns are:

* name - Full name of the learner.
* score - The score achieved by the learner.
* complete - The completion status.
* success - The success status.

The default value for the columns attribute is name,complete,score. The toplist will be sorted by score, so that the
learner who achieved the top score will be listed first.
