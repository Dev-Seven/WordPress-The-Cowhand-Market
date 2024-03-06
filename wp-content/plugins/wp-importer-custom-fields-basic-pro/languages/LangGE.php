<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\CFCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class LangGE {
        private static $german_instance = null , $media_instance;

        public static function getInstance() {
                if (LangGE::$german_instance == null) {
                        LangGE::$german_instance = new LangGE;
                        return LangGE::$german_instance;
                }
                return LangGE::$german_instance;
        }

        public static function contents(){
                $response = array('Importieren / Aktualisieren',
                'Dashboard' => 'Instrumententafel',
                'Manager' => 'Manager',
                'Export' => 'Export',
                'Settings' => 'die Einstellungen',
                'Support' => 'Unterstützung',
                'UploadfromDesktop' => 'Hochladen vom Desktop',
                'UploadfromFTPSFTP' => 'Upload von FTP / SFTP',
                'UploadfromURL' => 'Hochladen von URL',
                'ChoosFileintheServer' => 'Wählen Sie Datei auf dem Server',
                'Drag&Dropyourfilesor' => 'Drag & Drop Ihre Dateien oder',
                'Browse' => 'Durchsuche',
                'NewItem' => 'Neuer Gegenstand',
                'ExistingItems' => 'Bestehende Artikel',
                'ImportEachRecordAs'=> 'Importiert jeden Datensatz als',
                'Continue' => 'Fortsetzen',
                'Search' => 'Suche',
                'FromDate' => 'Ab Datum',
                'ToDate' => 'Miteinander ausgehen',
                'SEARCH' => 'SUCHE',
                'SavedTemplate' => 'Gespeicherte Vorlage',
                'TEMPLATES' => 'VORLAGEN',
                'MATCHEDCOLUMNSCOUNT' => 'ZUSAMMENGEPASSTE SPALTENZÄHLER',
                'MODULE' => 'MODUL',
                'CREATEDTIME' => 'ZEIT ERSTELLT',
                'ACTION' => 'AKTION',
                'USETEMPLATE' => 'BENUTZE TEMPLATE',
                'CREATENEWMAPPING' => 'NEUE KARTE ERSTELLEN',
                'BACK' => 'ZURÜCK',
                'ADVANCEDMODE' => 'FORTGESCHRITTENER MODUS',
                'DRAGDROPMODE' => 'DRAG & DROP MODUS',
                'WordpressFields' => 'Wordpress-Felder',
                'WPFIELDS' => 'WP-Felder',
                'CSVHEADER' => 'CSV-Header',
                'Action' => 'Aktion',
                'Name' => 'Name',
                'HINT' => 'HINWEIS',
                'Example' => 'Beispiel',
                'WordPressCoreFields' => 'WordPress-Kernfelder',
                'ACFFreeFields' => 'ACF-freie Felder',
                'ACFFields' => 'ACF-Felder',
                'ACFImageMetaFields' => 'ACF-Bild-Metafelder',
                'ACFGroupFields' => 'ACF-Gruppenfelder',
                'ACFProFields' => 'ACF Pro-Felder',
                'ACFRepeaterFields' => 'ACF-Repeater-Felder',
                'ACFFlexibleFields' => 'ACF Flexible Felder',
                'TypesCustomFields' => 'Typen Benutzerdefinierte Felder',
                'TypesImageMetaFields' => 'Typen Bildmetafelder',
                'PodsFields' => 'Pod-Felder',
                'PodsImageMetaFields' => 'Pods Bild-Metafelder',
               
                'JetEngineFields' => 'Jet Engine Felder',
                'JetEngineRFFields' => 'Jet Engine Repeater Felder',
                'JetEngineCPTFields' => 'Jet Engine CPT Felder',
                'JetEngineCPTRFFields' => 'Jet Engine CPT  Repeater Felde',
                'JetEngineTaxonomyFields' => 'Jet Engine Taxonomiefelder',
                'JetEngineTaxonomyRFFields' => 'Jet Engine Taxonomie Repeater felder',
                'JetEngineRelationsFields' => 'Jet Engine Relations-Felder',
                'CustomFieldSuite' => 'Custom Field Suite',
                'AllInOneSeoFields' => 'Alle in einem Seo-Feldern',
                'YoastSeoFields' => 'Yoast Seo Felder',
                'RankMathFields' => 'Rank Math Felder',
                'RankMathProFields'=>'Rank Math Pro Felder',
                'BillingAndShippingInformation' => 'Rechnungs- und Versandinformationen',
                'CustomFieldsWPMemberFields' => 'Benutzerdefinierte Felder WP-Mitgliederfelder',
                'CustomFieldsMemberFields' => 'Benutzerfelder für benutzerdefinierte Felder',
                'ProductMetaFields' => 'Produkt-Metafelds',
                'ProductImageMetaFields' => 'Meta-Felder für Produktbilder',
                'WPECommerceCustomFields' => 'Benutzerdefinierte Felder für WP-E-Commerce',
                'EventsManagerFields' => 'Felder des Ereignis-Managers',
                'NextGENGalleryFields' => 'NextGEN Gallery-Felder',
                'CMB2CustomFields' => 'Benutzerdefinierte CMB2-Felder',
                'WordPressCustomFields' => 'Benutzerdefinierte WordPress-Felder',
                'TermsandTaxonomies' => 'Begriffe und Taxonomien',
                'IsSerialized' => 'Wird serialisiert',
                'NoCustomFieldsFound' => 'Keine benutzerdefinierten Felder gefunden', 
                'MediaUploadFields' => 'Felder zum Hochladen von Medien',
                'UploadMedia' => 'Medien hochladen',
                'UploadedListofFiles' => 'Hochgeladene Liste der Dateien',
                'UploadedMediaFileLists' => 'Hochgeladene Mediendateilisten',
                'SavethismappingasTemplate' => 'Speichern Sie diese Zuordnung als Vorlage',
                'Save' => 'sparen',
                'Doyouneedtoupdatethecurrentmapping' => 'Müssen Sie das aktuelle Mapping aktualisieren?',
                'Savethecurrentmappingasnewtemplate' => 'Speichern Sie die aktuelle Zuordnung als neue Vorlage',
                'Back' => 'Zurück',
                'Size' => 'Größe',
                'MediaHandling' => 'Medienhandhabung',
                'Downloadexternalimagestoyourmedia' => 'Laden Sie externe Bilder auf Ihre Medien herunter',
                'ImageHandling' => 'Bildverarbeitung',
                'Usemediaimagesifalreadyavailable' => 'Verwenden Sie Medienbilder, falls bereits vorhanden',
                'Doyouwanttooverwritetheexistingimages' => 'Möchten Sie die vorhandenen Bilder überschreiben?',
                'ImageSizes' => 'Bildgrößen',
                'Thumbnail' => 'Miniaturansicht',
                'Medium' => 'Mittel',
                'MediumLarge' => 'Mittelgroß',
                'Large' => 'Groß',
                'Custom' => 'Brauch',
                'Slug' => 'Schnecke',
                'Width' => 'Breite',
                'Height' => 'Höhe',
                'Addcustomsizes' => 'Fügen Sie benutzerdefinierte Größen hinzu',
                'PostContentImageOption' => 'Bildoptionen für Inhalte veröffentlichen',
                'DownloadPostContentExternalImagestoMedia' => 'Laden Sie PostContentExternalImagestoMedia herunter',
                'MediaSEOAdvancedOptions' => 'Media SEO & erweiterte Optionen',
                'SetimageTitle' => 'Bildtitel einstellen',
                'SetimageCaption' => 'Legen Sie die Bildunterschrift fest',
                'SetimageAltText' => 'Legen Sie das Bild Alt Text fest',
                'SetimageDescription' => 'Bildbeschreibung einstellen',
                'Changeimagefilenameto' => 'Ändern Sie den Namen der Bilddatei in',
                'ImportconfigurationSection' => 'Konfigurationsabschnitt importieren',
                'EnablesafeprestateRollback' => 'Ermöglichen Sie ein sicheres Prestate-Rollback',
                'Backupbeforeimport' => 'Sicherung vor dem Import',
                'DoyouwanttoSWITCHONMaintenancemodewhileimport' => 'Möchten Sie den Wartungsmodus während des Imports EINSCHALTEN?',
                'Doyouwanttohandletheduplicateonexistingrecords' => 'Möchten Sie das Duplikat in vorhandenen Datensätzen behandeln?',
                'Mentionthefieldswhichyouwanttohandleduplicates' => 'Erwähnen Sie die Felder, die Sie mit Duplikaten behandeln möchten',
                'DoyouwanttoUpdateanexistingrecords' => 'Möchten Sie vorhandene Datensätze aktualisieren?',
                'Updaterecordsbasedon' => 'Datensätze basierend auf aktualisieren',
                'DoyouwanttoSchedulethisImport' => 'Möchten Sie diesen Import planen?',
                'ScheduleDate' => 'Terminplan',
                'ScheduleFrequency' => 'Häufigkeit des Zeitplans',
                'TimeZone' => 'Zeitzone',
                'ScheduleTime' => 'Planmäßige Zeit',
                'Schedule' => 'Zeitplan',
                'Import' => 'Einführen',
                'Format' => 'Format',
                'OneTime' => 'Einmal',
                'Daily' => 'Täglich',
                'Weekly' => 'Wöchentlich',
                'Monthly' => 'Monatlich',
                'Hourly' => 'Stündlich',
                'Every30mins'=> 'Alle 30 min',
                'Every15mins' => 'Alle 15 min',
                'Every10mins' => 'Alle 10 Minuten',
                'Every5mins' => 'Alle 5 min',
                'FileName' => 'Dateiname',
                'FileSize' => 'Dateigröße',
                'Process' => 'Verarbeiten',
                'Totalnoofrecords' => 'Gesamtzahl der Datensätze',
                'CurrentProcessingRecord' => 'Aktueller Bearbeitungssatz',
                'RemainingRecord' => 'Verbleibender Datensatz',
                'Completed' => 'Abgeschlossen',
                'TimeElapsed' => 'Verstrichene Zeit',
                'approximate' => 'ungefähr',
                'DownloadLog' => 'Log herunterladen',
                'NoRecord' => 'Keine Aufzeichnungen',
                'UploadedCSVFileLists' => 'Hochgeladene CSV-Dateilisten',
                'Hostname' => 'Hostname',
                'HostPort' => 'Host-Port',
                'HostUsername' => 'Host Benutzername',
                'HostPassword' => 'Host-Passwort',
                'HostPath' => 'Hostpfad',
                'DefaultPort' => 'Standardport',
                'FTPUsername' => 'FTP-Benutzername',
                'FTPPassword' => 'FTP-Passwort',
                'ConnectionType' => 'Verbindungstyp',
                'ImportersActivity' => 'Tätigkeit der Importeure',
                'ImportStatistics' => 'Statistiken importieren',
                'FileManager' => 'Dateimanager',
                'SmartSchedule' => 'Intelligenter Zeitplan',
                'ScheduledExport' => 'Geplanter Export',
                'Templates' => 'Vorlagen',
                'LogManager' => 'Log Manager',
                'NotSelectedAnyTab' => 'Kein Tab ausgewählt',
                'EventInfo' => 'Event Info',
                'EventDate' => 'Veranstaltungsdatum',
                'EventStatus' => 'Ereignisstatus',
                'Actions' => 'Aktionen',
                'Date' => 'Datum',
                'Purpose' => 'Zweck',
                'Revision' => 'Revision',
                'Select' => 'Wählen',
                'Inserted' => 'Eingefügt',
                'Updated' => 'Aktualisierte',
                'Skipped' => 'Übersprungen',
                'Noeventsfound' => 'Keine Events gefunden',
                'ScheduleInfo' => 'Zeitplan-Info',
                'ScheduledDate' => 'Geplantes Datum',
                'ScheduledTime' => 'Geplante Zeit',
                'Youhavenotscheduledanyevent' => 'Sie haben keine Veranstaltung geplant',
                'Frequency' => 'Frequenz',
                'Time' => 'Zeit',
                'EditSchedule' => 'Zeitplan bearbeiten',
                'SaveChanges' => 'Änderungen speichern',
                'TemplateInfo' => 'Vorlageninfo',
                'TemplateName' => 'Name der Vorlage',
                'Module' => 'Modul',
                'CreatedTime' => 'Zeit erstellt',
                'NoTemplateFound' => 'Keine Vorlage gefunden',
                'Download' => 'Herunterladen',
                'NoLogRecordFound' => 'Kein Protokollsatz gefunden',
                'GeneralSettings' => 'Allgemeine Einstellungen',
                'DatabaseOptimization' => 'Datenbankoptimierung',
                'SecurityandPerformance' => 'Sicherheit und Leistung',
                'Documentation' => 'Dokumentation',
                'MediaReport' => 'Medienbericht',
                'DropTable' => 'Tabelle ablegen',
                'Ifenabledplugindeactivationwillremoveplugindatathiscannotberestored' => 'Wenn die deaktivierte Plugin-Deaktivierung Plugin-Daten entfernt, können diese nicht wiederhergestellt werden.',
                'Scheduledlogmails' => 'Geplante Protokollmails',
                'Enabletogetscheduledlogmails' => 'Aktivieren, um geplante Protokollmails zu erhalten.',
                'Sendpasswordtouser' => 'Passwort an Benutzer senden',
                'Enabletosendpasswordinformationthroughemail' => 'Aktivieren Sie das Senden von Kennwortinformationen per E-Mail.',
                'WoocommerceCustomattribute' => 'Woocommerce Benutzerdefiniertes Attribut',
                'Enablestoregisterwoocommercecustomattribute' => 'Ermöglicht die Registrierung des benutzerdefinierten Attributs für Woocommerce.',
                'PleasemakesurethatyoutakenecessarybackupbeforeproceedingwithdatabaseoptimizationThedatalostcantbereverted' => 'Stellen Sie sicher, dass Sie die erforderliche Sicherung erstellen, bevor Sie mit der Datenbankoptimierung fortfahren. Der Datenverlust kann nicht zurückgesetzt werden.',
                'DeleteallorphanedPostPageMeta' => 'Alle verwaisten Post / Page-Meta löschen',
                'Deleteallunassignedtags' => 'Löschen Sie alle nicht zugewiesenen Tags',
                'DeleteallPostPagerevisions' => 'Löschen Sie alle Post / Page-Revisionen',
                'DeleteallautodraftedPostPage' => 'Alle automatisch erstellten Beiträge / Seiten löschen',
                'DeleteallPostPageintrash' => 'Alle Post / Seite im Papierkorb löschen',
                'DeleteallCommentsintrash' => 'Löschen Sie alle Kommentare im Papierkorb',
                'DeleteallUnapprovedComments' => 'Löschen Sie alle nicht genehmigten Kommentare',
                'DeleteallPingbackComments' => 'Löschen Sie alle Pingback-Kommentare',
                'DeleteallTrackbackComments' => 'Löschen Sie alle Trackback-Kommentare',
                'DeleteallSpamComments' => 'Löschen Sie alle Spam-Kommentare',
                'RunDBOptimizer' => 'Führen Sie den DB-Optimierer aus',
                'DatabaseOptimizationLog' => 'Datenbankoptimierungsprotokoll',
                'noofOrphanedPostPagemetahasbeenremoved' => 'Die Anzahl der verwaisten Post- / Seitenmeta wurde entfernt.',
                'noofUnassignedtagshasbeenremoved' => 'Die Anzahl der nicht zugewiesenen Tags wurde entfernt.',
                'noofPostPagerevisionhasbeenremoved' => 'Anzahl der Post / Page-Versionen wurde entfernt.',
                'noofAutodraftedPostPagehasbeenremoved' => 'Anzahl der automatisch verfassten Post / Seite wurde entfernt.',
                'noofPostPageintrashhasbeenremoved' => 'Anzahl der automatisch verfassten Post / Seite wurde entfernt.',
                'noofSpamcommentshasbeenremoved' => 'Anzahl der Spam-Kommentare wurde entfernt.',
                'noofCommentsintrashhasbeenremoved' => 'Anzahl der Kommentare im Papierkorb wurde entfernt.',
                'noofUnapprovedcommentshasbeenremoved' => 'Anzahl der nicht genehmigten Kommentare wurde entfernt.',
                'noofPingbackcommentshasbeenremoved' => 'Anzahl der Pingback-Kommentare wurde entfernt.',
                'noofTrackbackcommentshasbeenremoved' => 'Anzahl der Trackback-Kommentare wurde entfernt.',
                'Allowauthorseditorstoimport' => 'Erlauben Sie Autoren / Editoren den Import',
                'Thisenablesauthorseditorstoimport' => 'Dies ermöglicht Autoren / Editoren den Import.',
                'MinimumrequiredphpinivaluesIniconfiguredvalues' => 'Erforderliche Mindestwerte für php.ini (ini konfigurierte Werte)',
                'Variables' => 'Variablen',
                'SystemValues' => 'Systemwerte',
                'MinimumRequirements' => 'Mindestanforderungen',
                'RequiredtoenabledisableLoadersExtentionsandmodules' => 'Erforderlich zum Aktivieren / Deaktivieren von Loadern, Erweiterungen und Modulen:',
                'DebugInformation' => 'Debug-Informationen:',
                'SmackcodersGuidelines' => 'Smackcoders Richtlinien',
                'DevelopmentNews' => 'Neuigkeiten aus der Entwicklung',
                'WhatsNew' => "Was gibt's Neues?",
                'YoutubeChannel' => 'Youtube Kanal',
                'OtherWordPressPlugins' => 'Andere WordPress-Plugins',
                'Count' => 'Anzahl',
                'ImageType' => 'Bildtyp',
                'Status' => 'Status',
                'Loading' => 'Wird geladen',
                'LoveWPUltimateCSVImporterGivea5starreviewon' => 'Liebe WP Ultimate CSV Importeur, Gib eine 5-Sterne-Bewertung zu',
                'ContactSupport' => 'Kontaktieren Sie Support',
                'Email' => 'Email',
                'OrderId' => 'Auftragsnummer',
                'Supporttype' => 'Unterstützung typ',
                'BugReporting' => 'Fehlerberichterstattung',
                'FeatureEnhancement' => 'Funktionsverbesserung',
                'Message' => 'Botschaft',
                'Send' => 'Senden',
                'NewsletterSubscription' => 'Newsletter abonnieren',
                'Subscribe' => 'Abonnieren',
                'Note' => 'Hinweis',
                'SubscribetoSmackcodersMailinglistafewmessagesayear' => 'Abonnieren Sie die Smackcoders-Mailingliste (einige Nachrichten pro Jahr)',
                'Pleasedraftamailto' => 'Bitte eine Mail an schreiben',
                'Ifyoudoesnotgetanyacknowledgementwithinanhour' => 'Wenn Sie innerhalb einer Stunde keine Bestätigung erhalten!',
                'Selectyourmoduletoexportthedata' => 'Wählen Sie Ihr Modul aus, um die Daten zu exportieren',
                'Toexportdatabasedonthefilters' => 'Daten basierend auf den Filtern exportieren',
                'ExportFileName' => 'Dateiname exportieren',
                'AdvancedSettings' => 'Erweiterte Einstellungen',
                'ExportType' => 'Exporttyp',
                'SplittheRecord' => 'Teilen Sie den Datensatz',
                'AdvancedFilters'=> 'Erweiterte Filter',
                'Exportdatawithautodelimiters' => 'Daten mit automatischen Trennzeichen exportieren',
                'Delimiters' => 'Trennzeichen',
                'OtherDelimiters' => 'Andere Trennzeichen',
                'Exportdataforthespecificperiod' => 'Daten für den bestimmten Zeitraum exportieren',
                'StartFrom' => 'Beginne am',
                'EndTo' => 'Ende bis',
                'Exportdatawiththespecificstatus' => 'Exportieren Sie Daten mit dem spezifischen Status',
                'All' => 'Alles',
                'Publish' => 'Veröffentlichen',
                'Sticky' => 'Klebrig',
                'Private' => 'Privatgelände',
                'Protected' => 'Geschützt',
                'Draft' => 'Entwurf',
                'Pending' => 'steht aus',
                'Exportdatabyspecificauthors' => 'Daten von bestimmten Autoren exportieren',
                'Authors' => 'Autoren',
                'ExportdatabasedonspecificInclusions' => 'Exportieren Sie Daten basierend auf bestimmten Inklusionen',
                'DoyouwanttoSchedulethisExport' => 'Möchten Sie diesen Export planen?',
                'SelectTimeZone' => 'Wähle Zeitzone aus',
                'ScheduleExport' => 'Export planen',
                'DataExported' => 'Daten exportiert',
                'License'=>'Lizenz',
                'ThankYouForYourPurchase'=>'Danke für Ihren Einkauf',
                'ToGetStartedYouNeedToActivateByEnteringTheLicensekey'=>'Um zu beginnen, müssen Sie durch Eingabe des Lizenzschlüssels aktivieren',
                'EnterTheLicenseKey'=>'Geben Sie den Lizenzschlüssel ein',
                'LicenseDetails'=>'Lizenzdetails',
                'ProductName'=>'Produktname',
                'LicenseKey'=>'Lizenzschlüssel',
                'NoDataFound'=>'Keine Daten gefunden',
                'Activate'=>'aktivieren Sie'
        );
                return $response;
        }
}


