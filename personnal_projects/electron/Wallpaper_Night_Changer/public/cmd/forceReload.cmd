@echo on
color 05
echo Regedit opening...
REG ADD HKCU\Software\Microsoft\Windows\CurrentVersion\Applets\Regedit /v LastKey /t REG_SZ /d "HKEY_CURRENT_USER\Control Panel\Desktop" /f
START regedit
color 0A