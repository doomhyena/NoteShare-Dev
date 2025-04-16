@echo off
cd /d "C:\xampp\htdocs\NoteShare"

git add .

set commit_msg=Automatic commit: %date% %time%
git commit -m "%commit_msg%"

git push
