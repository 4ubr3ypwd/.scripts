#/bin/sh

# Clean out system of .DS_Store files

# Backup the ~/ one, we want that one so our finder window stays the same
mv ~/.DS_Store ~/.DS_Store.bak

# Remove all the things
sudo find / -name ".DS_Store" -depth -exec rm {} \;

# Move back the ~/ one
mv ~/.DS_Store.bak ~/.DS_Store