#!/bin/bash
case $DESKTOP_SESSION in
	"xfce" | "/usr/share/xsessions/xfce" )
		xfconf-query -c xfce4-desktop -p /backdrop/screen0/monitor0/workspace0/last-image -s $HOME/.DawnowlApps/Wallpaper_Night_Changer/$1
		echo -e "\e[36m$1 script → XFCE4 compatible command executed\e[0m"
	;;
	"ubuntu" | "/usr/share/xsessions/gnome")
		gsettings set org.gnome.desktop.background picture-uri file:///$HOME/.DawnowlApps/Wallpaper_Night_Changer/$1
		echo -e "\e[36m$1 script → Gnome/Ubuntu compatible command executed\e[0m"
	;;
	"plasma" | "/usr/share/xsessions/plasma")
		qdbus org.kde.plasmashell /PlasmaShell org.kde.PlasmaShell.evaluateScript "
		    var allDesktops = desktops();
		    print (allDesktops);
		    for (i=0;i<allDesktops.length;i++) {{
		        d = allDesktops[i];
		        d.wallpaperPlugin = \"org.kde.image\";
		        d.currentConfigGroup = Array(\"Wallpaper\",
		                                     \"org.kde.image\",
		                                     \"General\");
		        d.writeConfig(\"Image\", \"file:///$HOME/.DawnowlApps/Wallpaper_Night_Changer/$1\")
		    }}
		"
		echo -e "\e[36m$1 script → KDE/Plasma compatible command executed\e[0m"
	;;
	*)
		DISPLAY=:0 DBUS_SESSION_BUS_ADDRESS=unix:path=/run/user/$EUID/bus notify-send "Environnement de bureau $DESKTOP_SESSION non supporté !" "Wallpaper_Night_Changer"
		echo -e "\e[31m$1 script → Environnement de bureau $DESKTOP_SESSION non supporté\e[0m"
	;;
esac