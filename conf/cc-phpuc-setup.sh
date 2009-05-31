#!/bin/sh

# create structure
mkdir -p build/api
mkdir -p build/coverage
mkdir -p build/logs

# check out code
svn co http://svn.dev.pjkix.com/short-urls/trunk source
