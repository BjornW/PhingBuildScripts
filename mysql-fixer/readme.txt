== Introduction ==

MySQL Fixer is a generic Phing (http://phing.info) buildscript for dealing with
MySQL databases. It can be used stand-alone or as part of a larger buildscript. 
Use the supplied mysql-fixer.properties-sample as a base for your own property 
file. 

= Usage = 

1) Standalone interactive usage (standard when not using a propertyfile or properties as Phing parameters): 

$> phing -f mysql-fixer.xml

2) Standalone non-interactive usage (needs a propertyfile or properties defined as phing parameters): 

$> phing -f mysql-fixer.xml -propertyfile mysql-fixer.properties

For use in your own buildscripts: 
http://www.phing.info/docs/guide/stable/chapters/appendixes/AppendixB-CoreTasks.html#ImportTask

= License = 

No copyright implied. Use this buildscript as you see fit, but remember what Uncle Ben said: 

'With great power comes great responsibility'.

Bjorn Wijers
http://burobjorn.nl 
