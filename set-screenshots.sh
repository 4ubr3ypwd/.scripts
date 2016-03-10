#!/bin/sh

# Default Screenshot Folder
defaults write com.apple.screencapture location ~/Downloads

# Restart UI
killall SystemUIServer
