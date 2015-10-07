#!/bin/sh
####################################
#
# Backup to NFS mount script.
#
####################################

git add -A
git commit -m $1
git push