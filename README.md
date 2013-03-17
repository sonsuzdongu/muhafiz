muhafiz
=======

Master: [![Build Status](https://secure.travis-ci.org/sonsuzdongu/muhafiz.png?branch=master)](http://travis-ci.org/sonsuzdongu/muhafiz)

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

    $ sudo mkdir -p /usr/share/muhafiz
    $ git clone git://github.com/sonsuzdongu/muhafiz.git /usr/share/muhafiz
    $ cp /usr/share/muhafiz/git-hooks/* /your/project/.git/hooks        


## Configuration

You have to set your **'muhafiz.bootstrap-file'** git config seting to show your **muhafiz** bootstrap file

    $ git config muhafiz.bootstrap-file /usr/share/muhafiz/src/bootstrap.php

Or better you set it sytem wide or global

    $ sudo git config --global muhafiz.bootstrap-file /usr/share/muhafiz/src/bootstrap.php
    $ sudo git config --system muhafiz.bootstrap-file /usr/share/muhafiz/src/bootstrap.php

Then you have to set the comma separated list of code checkers(aka runners) using 'muhafiz.active-runners' git config paramter
 
    $ git config muhafiz.active-runners 'phpcs, jshint'

After this, **'all your commits are belongs to us'**. All your commits will be checked by given runners and commit will be prevented if are there any errors

## Runners
* **bom**  Check files for byte order mark
* **php**  Check php files for syntax errors using 'php -l' command line tool
* **phpcs** ([PhpCodeSniffer](http://pear.php.net/package/PHP_CodeSniffer/redirected))
    * config parameters : 
        * 'muhafiz.runners.phpcs.standard' : set coding standard (see [reference doc](http://pear.php.net/manual/en/package.php.php-codesniffer.config-options.php)) | defaults to "PEAR"
        * 'muhafiz.runners.phpcs.report' : set reporting type (see [reference doc](http://pear.php.net/manual/en/package.php.php-codesniffer.config-options.php)) | defaults to "emacs"
* **php-cs-fixer** ([Php CS Fixer](http://cs.sensiolabs.org/))
    * config parameters : 
        * 'muhafiz.runners.php-cs-fixer.standard' : set coding standard (see [reference doc](http://cs.sensiolabs.org/)) | defaults to "psr2"
* **jshint** ([JSHint Node.js Command Line Tool](http://www.jshint.com/platforms/))
    * config parameters : 
        * 'muhafiz.runners.jshint.config' : jshint config file (see [reference doc](http://www.jshint.com/docs/)) | defaults to ".jshintrc"
* **lineend** Check files' line endings
    * config parameters : 
        * 'muhafiz.runners.lineend.allowed' : should be 'unix' or 'windows' 


## Setting exclude patterns for runners
Exclude patterns can be set for each runner with setting a RegExp rule in 'muhafiz.runners.RUNNER_NAME.exclude-path' like

    $ muhafiz.runners.lineend.exclude-path '/static\/images/'
    
In this example, lineend rune will  not be applied to files which matches that rule (like /foo/static/images/bar.xyz)

## Disabling pushes to specific branches (Only on pre-receive hook)
You can disable pushes to specific branches by

    $ git config muhafiz.disabled-branches "foo bar"

## Contributors
[volkan](https://github.com/volkan) <br />
[chesterx](https://github.com/chesterx)


## TODO
* verbose options
