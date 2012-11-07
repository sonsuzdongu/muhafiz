muhafiz
=======

Guard your codebase from bad code!

                             ...',,,,,',:                                   
                            ,,.',okxc,,,Oc                                  
                           .,.',;0OOx,,,;K'                                 
                           :.',,;XoxK,,,,cK.                                
                          ';.',,,l00d,,,,,oO                                
                          c''',,,oWWo,,,,,,O:                               
                         ,:.',,,,;NX,,,,,,,:0                               
                         ,;.',,,,,K0,,,,,,,,k;                              
                         ;,',,,,:OMWx;,,,,,,l.                              
                        .odxxox0NNWNNXkooxOXW.                              
                         okKWNNX0NNXKkNNWWWWN.                              
                         'dOWNWNKNWNX0MXNWWWo                               
                          ,oONWX0KWN0OKNWWNo.                               
                        ....;c;...cl',',lo;'...                             
                      .......';odOKXNKc'..'',,,'.                           
                     ...;ldxlxWWWWWWWWXW0doc;,,,,.                          
                    .'oKNWWWWN0kOKXXX00NWNWWN0xc,,.                         
                   'xNWWWWWN0o'..,:c,'',kNWWWWWWKo,                         
                  ,XWWNX0Odc,',oxxxxc.,,':xXNNNWWWK;                        
                 .0WXOdl:,..''ldolodx;',,,,;lkKXXNWN.                       
                .:xxc;'.  ..,'ldddooxc',,,,,,,.',:;:                        
                   ....  ...,,,oxxxOd,,,,,,,,,....                          
                     ... ..',,,'lokd,,,,,,,,,,...                           
                       .....,,,'oxKd,,,,,,,,,..                             
                         ...,,,'o0Wd,,,,;;:c:                               
                         :oxdxxcoNWkxkkkO0KKx                               
                         .';;;;,OXW0...,,,,,'                               
                       ...',,,'lKKW0...,,,,,,.                              
                       ..',,,,.dWO0k,..,,,,,,,                              
                      ..',,,,,.cNdOk:..,,,,,,,'                             
                     ..',,,,,,..Ookkc..',,,,,,,                             
                     '.,,,,,,'. lkdx:...,,,,,,,.                            
                     ..,,,,,'.. 'xox....',,,,,,.                            
                     ..,,,,,..   :o:'  ...,,,,,'                            
                     ..,,,,.      c..     .,,,,.                            
                     .......      ..      ....... 


## Installation

You need to copy the required git-hook to your project's .git/hooks directory 
And put the src directory in somewhere (eg. /usr/share/muhafiz/src)

    $ cp git-hooks/ANY-HOOOK /your/project/git-hooks
    $ sudo mkdir /usr/share/muhafiz
    $ sudo cp -r src /usr/share/muhafiz


## Configuration

You have to set your **'muhafiz.bootstrap-file'** git config seting to show your **muhafiz** bootstrap file

    $ git config muhafiz.bootstrap-file /usr/share/muhafiz/src/bootstrap.php

Or better you set it sytem wide or global

    $ sudo git config --global muhafiz.bootstrap-file /usr/share/muhafiz/src/bootstrap.php
    $ sudo git config --system muhafiz.bootstrap-file /usr/share/muhafiz/src/bootstrap.php

Then you have to set the comma separated list of code checkers(aka runners) using 'muhafiz.active-runners' git config paramter
 
    $ git config muhafiz.active-runners 'phpcs, jshint'

After this, **'all your comits are belongs to us'**. All your commits will be checked by given runners and commit will be prevented if are there any errors

## Runners

* **phpcs** ([PhpCodeSniffer](http://pear.php.net/package/PHP_CodeSniffer/redirected))
    * config parameters : 
        * 'muhafiz.adapters.phpcs.standard' : set coding standard (see [reference doc](http://pear.php.net/manual/en/package.php.php-codesniffer.config-options.php)) | defaults to "PEAR"
        * 'muhafiz.adapters.phpcs.report' : set reporting type (see [reference doc](http://pear.php.net/manual/en/package.php.php-codesniffer.config-options.php)) | defaults to "emacs"
