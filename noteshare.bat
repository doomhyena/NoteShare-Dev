@echo off
cd /d "C:\xampp\htdocs\NoteShare"

git add .

set commit_msg=Automatikus commit: %date% %time%
git commit -m "%commit_msg%"

git push origin main
