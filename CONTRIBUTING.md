# USING THE GIT REPOSITORY

 1. Setup a GitHub account (http://github.com/), if you haven't yet
 2. Fork the muhafiz repository (http://github.com/sonsuzdongu/muhafiz)
 3. Clone your fork locally and enter it (use your own GitHub username
    in the statement below)

    ```sh
    % git clone git@github.com:<username>/muhafiz.git
    % cd muhafiz
    ```

 4. Add a remote to the canonical muhafiz repository, so you can keep your fork
    up-to-date:

    ```sh
    % git remote add muhafiz https://github.com/sonsuzdongu/muhafiz.git
    % git fetch muhafiz
    ```


## Keeping Up-to-Date

Periodically, you should update your fork or personal repository to
match the canonical muhafiz repository. In each of the above setups, we have
added a remote to the muhafiz repository, which allows you to do
the following:


```sh
% git checkout master
% git pull muhafiz master
- OPTIONALLY, to keep your remote up-to-date -
% git push origin master
```

If you're tracking other branches -- for example, the "develop" branch, where
new feature development occurs -- you'll want to do the same operations for that
branch; simply substibute "develop" for "master".


forking https://github.com/zendframework/zf2/blob/master/CONTRIBUTING.md

