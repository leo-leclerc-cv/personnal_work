@echo off
color 05
echo Changing wallpaper to night wallpaper...
reg add "HKEY_CURRENT_USER\Control Panel\Desktop" /v Wallpaper /t REG_SZ /d %USERPROFILE%\.DawnowlApps\Wallpaper_Night_Changer\toNight /f
RUNDLL32.EXE user32.dll,UpdatePerUserSystemParameters
color 0A