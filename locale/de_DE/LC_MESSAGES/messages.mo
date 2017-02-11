��    :      �  O   �      �  �   �     �  3   �     �  1   �  =   
      H     i     }     �  A   �     �     �     �       
   &     1     >     P     _     x     �     �  i   �       f        �  L   �  [   �  �   ?	  
   �	     �	  F   �	  �   $
     �
     �
     �
  U   �
     !  
   &  
   1     <     A  
   O  B   Z     �  �   �  9   K  	   �  A   �     �     �     �  =   �  #   *  p   N  
   �  �  �  �   �     2  +   E     q  #   �  =   �     �     �             B   (     k     t     �  +   �     �     �  
   �     �     �               "  s   A  
   �     �     @  H   P  q   �  j        v     �  T   �  �   �     �     �     �  `   �     C     H     U     c     h     |  K   �     �  �   �  I   �     �  M   �     J     N  	   c  =   m     �  �   �     W        %   .   	                    :       2                  &                         8   6          /   +   9                     7             3   !   #   $   *          -          )       '   ,       1            0      4            (   "   
           5                             A device should only need to be initialized once on instalation. Initiating a device twice will duplicate its default inputs and feeds. Add a device Add the HTTP header: "Authorization: Bearer APIKEY" Apikey authentication Append on the URL of your request: &apikey=APIKEY Append on the input URL of your request: &devicekey=DEVICEKEY Are you sure you want to delete? Available HTML URLs Available JSON commands Cancel Default inputs and associated feeds will be automaticaly created. Delete Delete device Delete permanently Deleting a device is permanent. Device API Device Setup Device access key Device actions Devicekey authentication Devices Devices Help Devices templates documentation Each file defines a device type and provides the default inputs and feeds configurations for that device. Edit Ensure that the sent input Node matches the Node that is configured for the device on the device menu. Get device details If the node name already exists, new default inputs and feeds will be added. If this device is active and is using a device key, it will no longer be able to post data. If you want to call any of the following actions when your not logged in you have this options to authenticate with the API key: Initialize Initialize device Initializing a device usualy should only be done once on installation. Inputs and Feeds that this device uses are not deleted and all historic data is kept. To remove them, deleted manualy afterwards. List devices List templates Location Make sure the selected device node and type are correcly configured before proceding. Name New device No devices Node Read & Write: Read only: Template files are located at <b>'\Modules\device\data\*.json'</b> The device list view The input module can use a devicekey instead of an apikey. If you want to authenticate as a device, just replace apikey=APIKEY with devicekey=DEVICEKEY: There are no devices configured. Please add a new device. This page To use the json api the request url needs to include <b>.json</b> Type Update device Updated Use POST parameter while calling input: "devicekey=DEVICEKEY" Use POST parameter: "apikey=APIKEY" Using a device key will only allow sending data for the Node of that device, giving a greater level of security. loading... Project-Id-Version: emoncms3
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2017-02-05 18:06+0100
PO-Revision-Date: 2017-02-07 16:15+0100
Last-Translator: Frank Dille
Language-Team: @sumpfing <anne@sumpfing.de>
Language: de_DE
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Poedit-KeywordsList: _;gettext;gettext_noop
X-Poedit-Basepath: .
X-Generator: Poedit 1.8.11
X-Poedit-SourceCharset: UTF-8
X-Poedit-SearchPath-0: ../../..
 Ein Gerätetyp bei der Installation muss nur einmal initialisiert werden. Jede weitere Initalisierung erstellt weitere Inputs und Feeds als Kopie. Gerät Hinzufügen HTTP Header: "Authorization: Bearer APIKEY" Apikey Authentisierung Der URL hinzufügen: &apikey=APIKEY Beim Request der Input URL hinzufügen: &devicekey=DEVICEKEY  Wirklich löschen? Verfügbare HTML URLs JSON Befehle Abbruch Es werden jetzt die Default Inputs und Feeds automatisch erstellt. Löschen Gerät Löschen Dauerhaft löschen Das Löschen eines Gerätes ist endgültig! Geräte API Geräte Device-Key Gerät Aktionen Device-Key Authorisierung Geräte Geräte Hilfe Dokumentation Geräte-Vorlagen Jede Vorlage definiert einen Gerätetyp und stellt die Default-Konfiguration für Inputs und Feeds für ein Gerät. Bearbeiten Stellen Sie beim Versenden von Input-Daten sicher, dass ein Node angegeben ist. Der Node wird in der Geräteliste konfiguriert. Gerät Details  Wenn der Node bereits existiert werden die Inputs und Feed hinzugefügt. Warnung: Sollte das Gerät aktiv sein und per <b>Device-Key</b> Daten senden, wird dies nicht mehr funktionieren. Wenn Sie die folgenden Aktionen ohne vorherige Anmeldung ausführen, muss der API Key hinzugefügt werden: Initialisieren Geräte Initialisierung Die Initalisierung eines Gerätes sollte nur einmalig bei der Installation erfolgen. Inputs und Feeds die dieses Gerät bereitstellt werden nicht gelöscht. Die aufgezeichneten Daten bleiben erhalten.<br>Zum Löschen der Daten müssen die Feeds anschließend manuell gelöscht werden. Geräte Anzeigen Vorlagenliste Standort Stellen Sie sicher das Gerätetyp und -Node richtig konfiguriert sind, bevor Sie die fortfahren. Name Neues Gerät Keine Geräte Node Lesen und Schreiben Lesen: Vorlagen Dateien werden abgelegt unter <b>'\Modules\device\data\*.json'</b> Geräteansicht Das Input Modul kann spezielle Device-Key statt eines allgemeinen Api-Key verwenden. Um einzelne Geräte zu authentizieren muss apikey=APIKEY mit devicekey=DEVICEKEY ersetzt werden.  Es sind keine Geräte konfiguriert, Bitte erstellen Sie ein neues Gerät. Geräte API (aktuelle Seite) Bei der Benutzung der json API muss der URL <b>.json</b> hinzugefügt werden. Typ Gerät Aktualisieren Geändert POST Parameter beim Aufruf eines Input: "devicekey=DEVICEKEY" POST Parameter: "apikey=APIKEY" Das Benutzen eines Device-Key erlaubt das Senden von Daten nur für dieses eine Gerät und verschafft eine höhere Sicherheit beim Zugriff. wird geladen ... 