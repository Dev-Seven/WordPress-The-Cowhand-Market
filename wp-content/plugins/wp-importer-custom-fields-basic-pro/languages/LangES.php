<?php

/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\CFCSV;

if (!defined('ABSPATH'))
        exit; // Exit if accessed directly

class LangES
{
        private static $spanish_instance = null, $media_instance;

        public static function getInstance()
        {
                if (LangES::$spanish_instance == null) {
                        LangES::$spanish_instance = new LangES;
                        return LangES::$spanish_instance;
                }
                return LangES::$spanish_instance;
        }

        public static function contents()
        {
                $response = array(
                        'ImportUpdate' => 'Importar actualización',
                        'Dashboard' => 'Tablero',
                        'Manager' => 'Gerente',
                        'Export' => 'Exportar',
                        'Settings' => 'Configuraciones',
                        'Support' => 'Apoyo',
                        'UploadfromDesktop' => 'Subir desde el escritorio',
                        'UploadfromFTPSFTP' => 'Subir desde FTP / SFTP',
                        'UploadfromURL' => 'Subir desde URL',
                        'ChoosFileintheServer' => 'Elegir archivo en el servidor',
                        'Drag&Dropyourfilesor' => 'Arrastra y suelta tus archivos o',
                        'Browse' => 'Vistazo',
                        'NewItem' => 'Nuevo artículo',
                        'ExistingItems' => 'Artículos existentes',
                        'ImportEachRecordAs' => 'Import each record as',
                        'Continue' => 'Hacer continuación',
                        'Search' => 'Buscar',
                        'FromDate' => 'Partir de la fecha',
                        'ToDate' => 'Hasta la fecha',
                        'SEARCH' => 'BUSCAR',
                        'SavedTemplate' => 'Plantilla guardada',
                        'TEMPLATES' => 'PLANTILLAS',
                        'MATCHEDCOLUMNSCOUNT' => 'MATCHED COLUMNS COUNT',
                        'MODULE' => 'MÓDULO',
                        'CREATEDTIME' => 'TIEMPO CREADO',
                        'ACTION' => 'ACCIÓN',
                        'USETEMPLATE' => 'PLACA DE USUARIO',
                        'CREATENEWMAPPING' => 'CREATE NEW MAPPING',
                        'BACK' => 'ESPALDA',
                        'ADVANCEDMODE' => 'MODO AVANZADO',
                        'DRAGDROPMODE' => 'DRAG & DROP MODE',
                        'WordpressFields' => 'Campos de Wordpress',
                        'WPFIELDS' => 'Campos de WP',
                        'CSVHEADER' => 'Encabezado CSV',
                        'Action' => 'Acción',
                        'Name' => 'Nombre',
                        'HINT' => 'INSINUACIÓN',
                        'Example' => 'Ejemplo',
                        'WordPressCoreFields' => 'Campos centrales de WordPress',
                        'ACFFreeFields' => 'Campos libres de ACF',
                        'ACFFields' => 'Campos de ACF',
                        'ACFImageMetaFields' => 'Meta campos de imagen ACF',
                        'ACFGroupFields' => 'Campos del grupo ACF',
                        'ACFProFields' => 'ACF Pro Fields',
                        'ACFRepeaterFields' => 'Campos repetidores ACF',
                        'ACFFlexibleFields' =>'Campos flexibles de ACF',
                        'TypesCustomFields' => 'Tipos de campos personalizados',
                        'TypesImageMetaFields'=> 'Tipos Imagen Meta Campos',
                        'PodsFields' => 'Campos de vainas',
                        'PodsImageMetaFields'  => 'Pods Imagen meta Campos', 
                        'JetEngineFields' => 'Campos de motores a reacción',
                        'JetEngineRFFields' => 'Campos de repetidores de motores a reacción',
                        'JetEngineCPTFields' => 'Campos CPT de motores a reacción',
                        'JetEngineCPTRFFields' => 'Campos de repetidor CPT de motor a reacción',
                        'JetEngineTaxonomyFields' => 'Campos de taxonomía de motores a reacción',
                        'JetEngineTaxonomyRFFields' => 'Campos de repetidor de taxonomía de motores a reacción',
                        'JetEngineRelationsFields' => 'Campos de relaciones con motores a reacción', 
                        'CustomFieldSuite' => 'Suite de campo personalizada',
                        'AllInOneSeoFields' => 'Todo en uno Seo Fields',
                        'YoastSeoFields' => 'Yoast Seo Fields',
                        
                        'RankMathFields' => 'Rank Math Fields',
                        'RankMathProFields'=>'Rank Math Pro Fields',
                        'BillingAndShippingInformation' => 'Información de facturación y envío',
                        'CustomFieldsWPMemberFields' => 'Campos personalizados Campos de miembros de WP',
                        'CustomFieldsMemberFields' => 'Campos personalizados Campos de miembros',
                        'ProductMetaFields' => 'Meta campos del producto',
                        'ProductImageMetaFields' => 'Imagen del producto meta Fields',
                        'OrderMetaFields' => 'Ordenar metacampos',
                        'CouponMetaFields' => 'Cupón Meta Fields',
                        'RefundMetaFields' => 'Reembolsar Meta Fields',
                        'WPECommerceCustomFields' => 'Campos personalizados de comercio electrónico de WP',
                        'EventsManagerFields' => 'Campos del administrador de eventos',
                        'NextGENGalleryFields' => 'Campos de la galería NextGEN',
                        'WPMLFields' => 'Campos WPML',
                        'CMB2CustomFields' => 'Campos personalizados CMB2',
                        'WordPressCustomFields' => 'Campos personalizados de WordPress',
                        'TermsandTaxonomies' => 'Términos y taxonomías',
                        'IsSerialized' => 'Iserializado',
                        'NoCustomFieldsFound' => 'No se encontraron campos personalizados',
                        'MediaUploadFields' => 'Campos de carga de medios',
                        'UploadMedia' => 'Subir medios',
                        'UploadedListofFiles' => 'Lista de archivos cargados',
                        'UploadedMediaFileLists' => 'Listas de archivos multimedia subidos',
                        'SavethismappingasTemplate' => 'Guardar este mapa como plantilla',
                        'Save' => 'Salvar',
                        'Doyouneedtoupdatethecurrentmapping' => '¿Necesita actualizar la asignación actual?',
                        'Savethecurrentmappingasnewtemplate' => 'Guardar la asignación actual como nueva plantilla ',
                        'Back' => 'atrás',
                        'Size' => 'Talla',
                        'MediaHandling' => 'Imagen destacada Manejo de medios',
                        'Downloadexternalimagestoyourmedia' => 'Descarga imágenes externas a tus medios',
                        'ImageHandling' => 'Manejo de imagen',
                        'Usemediaimagesifalreadyavailable' => 'Use imágenes multimedia si ya están disponibles',
                        'Doyouwanttooverwritetheexistingimages' => '¿Desea sobrescribir las imágenes existentes?',
                        'ImageSizes' => 'Tamaños de imagen',
                        'Thumbnail' => 'Miniatura',
                        'Medium' => 'Medio',
                        'MediumLarge' => 'Mediano grande',
                        'Large' => 'Grande',
                        'Custom' => 'Personalizada',
                        'Slug' => 'Babosa',
                        'Width' => 'Anchura',
                        'Height' => 'Altura',
                        'Addcustomsizes' => 'Agregar tamaños personalizados',
                        'PostContentImageOption' => 'Opciones de imagen de contenido de publicación',
                        'DownloadPostContentExternalImagestoMedia' => 'Descargar PostContentExternalImagestoMedia',
                        'MediaSEOAdvancedOptions' => 'SEO de medios y opciones avanzadas',
                        'SetimageTitle' => 'Establecer título de imagen',
                        'SetimageCaption' => 'Establecer título de imagen',
                        'SetimageAltText' => 'Establecer imagen texto alternativo',
                        'SetimageDescription' => 'Establecer imagen Descripción',
                        'Changeimagefilenameto' => 'Cambiar el nombre del archivo de imagen a',
                        'ImportconfigurationSection' => 'Sección de configuración de importación',
                        'EnablesafeprestateRollback' => 'Habilitar reversión segura',
                        'Backupbeforeimport' => 'Copia de seguridad antes de importar',
                        'DoyouwanttoSWITCHONMaintenancemodewhileimport' => '¿Desea ENCENDER el modo de mantenimiento mientras importa',
                        'Doyouwanttohandletheduplicateonexistingrecords' => '¿Desea manejar el duplicado en los registros existentes?',
                        'Mentionthefieldswhichyouwanttohandleduplicates' => 'Mencione los campos que desea manejar duplicados',
                        'DoyouwanttoUpdateanexistingrecords' => '¿Desea actualizar un registro existente?',
                        'Updaterecordsbasedon' => 'Actualizar registros basados en',
                        'DoyouwanttoSchedulethisImport' => '¿Desea programar esta importación?',
                        'ScheduleDate' => 'Fecha de programacion',
                        'ScheduleFrequency' => 'Horario Frecuencia',
                        'TimeZone' => 'Zona horaria',
                        'ScheduleTime' => 'Tiempo programado',
                        'Schedule' => 'Calendario',
                        'Import' => 'Importar',
                        'Format' => 'Formato',
                        'OneTime' => 'Una vez',
                        'Daily' => 'Diario',
                        'Weekly' => 'Semanal',
                        'Monthly' => 'Mensual',
                        'Hourly' => 'Cada hora',
                        'Every30mins' => 'Cada 30 minutos',
                        'Every15mins' => 'Cada 15 minutos',
                        'Every10mins' => 'Cada 10 minutos',
                        'Every5mins' => 'Cada 5 minutos',
                        'FileName' => 'Nombre del archivo',
                        'FileSize' => 'Tamaño del archivo',
                        'Process' => 'Proceso',
                        'Totalnoofrecords' => 'No total de registros',
                        'CurrentProcessingRecord' => 'Registro de procesamiento actual',
                        'RemainingRecord' => 'Registro restante',
                        'Completed' => 'Terminada',
                        'TimeElapsed' => 'Tiempo transcurrido',
                        'approximate' => 'aproximada',
                        'DownloadLog' => 'Ver registro',
                        'NoRecord' => 'Sin registro',
                        'UploadedCSVFileLists' => 'Listas de archivos CSV cargados',
                        'Hostname' => 'Nombre de host',
                        'HostPort' => 'Puerto host',
                        'HostUsername' => 'Nombre de usuario del host',
                        'HostPassword' => 'HostPassword',
                        'HostPath' => 'HostPath',
                        'DefaultPort' => 'Puerto predeterminado',
                        'FTPUsername' => 'Nombre de usuario FTP',
                        'FTPPassword' => 'Contraseña FTP',
                        'ConnectionType' => 'Tipo de conección',
                        'ImportersActivity' => 'Actividad de importadores',
                        'ImportStatistics' => 'Estadísticas de importación',
                        'FileManager' => 'Administrador de archivos',
                        'SmartSchedule' => 'Horario inteligente',
                        'ScheduledExport' => 'Exportación programada',
                        'Templates' => 'Plantillas',
                        'LogManager' => 'Gerente de registro',
                        'NotSelectedAnyTab' => 'No seleccionado ninguna pestaña',
                        'EventInfo' => 'Información del evento',
                        'EventDate' => 'Fecha del evento',
                        'EventStatus' => 'Estado del evento',
                        'Actions' => 'Comportamiento',
                        'Date' => 'Fecha',
                        'Purpose' => 'Propósito',
                        'Revision' => 'Revisión',
                        'Select' => 'Seleccionar',
                        'Inserted' => 'Insertada',
                        'Updated' => 'Actualizada',
                        'Skipped' => 'Omitida',
                        'Noeventsfound' => 'No se encontraron eventos.',
                        'ScheduleInfo' => 'Información del horario',
                        'ScheduledDate' => 'Cita agendada',
                        'ScheduledTime' => 'Hora programada',
                        'Youhavenotscheduledanyevent' => 'No has programado ningún evento',
                        'Frequency' => 'Frecuencia',
                        'Time' => 'Hora',
                        'EditSchedule' => 'Editar horario',
                        'SaveChanges' => 'Guardar cambios',
                        'TemplateInfo' => 'Información de plantilla',
                        'TemplateName' => 'Nombre de la plantilla',
                        'Module' => 'Módulo',
                        'CreatedTime' => 'Tiempo creado',
                        'NoTemplateFound' => 'No se encontró plantilla',
                        'Download' => 'Descargar',
                        'NoLogRecordFound' => 'No se encontró registro de registro',
                        'GeneralSettings' => 'Configuración general',
                        'DatabaseOptimization' => 'Optimización de bases de datos',
                        'SecurityandPerformance' => 'Seguridad y rendimiento',
                        'Documentation' => 'Documentación',
                        'MediaReport' => 'Informe de medios',
                        'DropTable' => 'Mesa plegable',
                        'Ifenabledplugindeactivationwillremoveplugindatathiscannotberestored' => 'Si la desactivación activada del complemento eliminará los datos del complemento, esto no se puede restaurar.',
                        'Scheduledlogmails' => 'Correos de registro programados',
                        'Enabletogetscheduledlogmails' => 'Habilite para obtener correos de registro programados.',
                        'Sendpasswordtouser' => 'Enviar contraseña al usuario',
                        'Enabletosendpasswordinformationthroughemail' => 'Habilitar para enviar información de contraseña por correo electrónico.',
                        'WoocommerceCustomattribute' => 'Atributo personalizado de Woocommerce',
                        'Enablestoregisterwoocommercecustomattribute' => 'Permite registrar el atributo personalizado de woocommerce.',
                        'PleasemakesurethatyoutakenecessarybackupbeforeproceedingwithdatabaseoptimizationThedatalostcantbereverted' => 'Asegúrese de realizar la copia de seguridad necesaria antes de continuar con la optimización de la base de datos. Los datos perdidos no se pueden revertir.',
                        'DeleteallorphanedPostPageMeta' => 'Eliminar todas las publicaciones huérfanas / meta de página',
                        'Deleteallunassignedtags' => 'Eliminar todas las etiquetas no asignadas',
                        'DeleteallPostPagerevisions' => 'Eliminar todas las revisiones de publicaciones / páginas',
                        'DeleteallautodraftedPostPage' => 'Eliminar todas las publicaciones / páginas con borrador automático',
                        'DeleteallPostPageintrash' => 'Eliminar todas las publicaciones / páginas en la papelera',
                        'DeleteallCommentsintrash' => 'Eliminar todos los comentarios en la papelera',
                        'DeleteallUnapprovedComments' => 'Eliminar todos los comentarios no aprobados',
                        'DeleteallPingbackComments' => 'Eliminar todos los comentarios de Pingback',
                        'DeleteallTrackbackComments' => 'Eliminar todos los comentarios de Trackback',
                        'DeleteallSpamComments' => 'Eliminar todos los comentarios de spam',
                        'RunDBOptimizer' => 'Ejecute DB Optimizer',
                        'DatabaseOptimizationLog' => 'Registro de optimización de base de datos',
                        'noofOrphanedPostPagemetahasbeenremoved' => 'No se ha eliminado ninguna meta de publicación / página huérfana.',
                        'noofUnassignedtagshasbeenremoved' => 'ninguna de las etiquetas sin asignar ha sido eliminada.',
                        'noofPostPagerevisionhasbeenremoved' => 'No se ha eliminado ninguna de las revisiones de publicaciones / páginas.',
                        'noofAutodraftedPostPagehasbeenremoved' => 'no Se ha eliminado la publicación / página de borrador automático.',
                        'noofPostPageintrashhasbeenremoved' => 'No se ha eliminado ninguna publicación / página en la papelera.',
                        'noofSpamcommentshasbeenremoved' => 'ninguno de los comentarios de spam ha sido eliminado.',
                        'noofCommentsintrashhasbeenremoved' => 'No se ha eliminado ningún comentario en la papelera.',
                        'noofUnapprovedcommentshasbeenremoved' => 'ninguno de los comentarios no aprobados ha sido eliminado.',
                        'noofPingbackcommentshasbeenremoved' => 'ninguno de los comentarios de Pingback ha sido eliminado.',
                        'noofTrackbackcommentshasbeenremoved' => 'ninguno de los comentarios de Trackback ha sido eliminado.',
                        'Allowauthorseditorstoimport' => 'Permitir a los autores / editores importar',
                        'Allowauthorseditorstoimport' => 'Apermitir a los autores / editores importar',
                        'Thisenablesauthorseditorstoimport' => 'Esto permite a los autores / editores importar.',
                        'MinimumrequiredphpinivaluesIniconfiguredvalues' => 'Valores mínimos requeridos de php.ini (valores configurados INI)',
                        'Variables' => 'Variables',
                        'SystemValues' => 'Valores del sistema',
                        'MinimumRequirements' => 'Requerimientos mínimos',
                        'RequiredtoenabledisableLoadersExtentionsandmodules' => 'Necesario para habilitar / deshabilitar cargadores, extensiones y módulos:',
                        'DebugInformation' => 'Información de depuración:',
                        'SmackcodersGuidelines' => 'Pautas de Smackcoders',
                        'DevelopmentNews' => 'Pautas de Smackcoders',
                        'WhatsNew' => '¿Qué hay de nuevo?',
                        'YoutubeChannel' => 'Canal de Youtube',
                        'OtherWordPressPlugins' => 'Otros complementos de WordPress',
                        'Count' => 'Contar',
                        'ImageType' => 'Tipo de imagen',
                        'Status' => 'Estado',
                        'Loading' => 'Cargando',
                        'LoveWPUltimateCSVImporterGivea5starreviewon' => 'Importador de Love WP Ultimate CSV, opina sobre 5 estrellas en',
                        'ContactSupport' => 'Soporte de contacto',
                        'Email' => 'Email',
                        'OrderId' => 'Solicitar ID',
                        'Supporttype' => 'Tipo de soporte',
                        'BugReporting' => 'Informe de errores',
                        'FeatureEnhancement' => 'Mejora de funciones',
                        'Message' => 'Mensaje',
                        'Send' => 'Enviar',
                        'NewsletterSubscription' => 'Boletín de suscripción',
                        'Subscribe' => 'Suscribir',
                        'Note' => 'Nota',
                        'SubscribetoSmackcodersMailinglistafewmessagesayear' => 'Suscríbase a la lista de correo de Smackcoders (algunos mensajes al año)',
                        'Pleasedraftamailto' => 'Por favor, redacte un correo a',
                        'Ifyoudoesnotgetanyacknowledgementwithinanhour' => '¡Si no recibe ningún reconocimiento dentro de una hora!',
                        'Selectyourmoduletoexportthedata' => 'Seleccione su módulo para exportar datos',
                        'Toexportdatabasedonthefilters' => 'Para exportar datos basados ​​en los filtros',
                        'ExportFileName' => 'Exportar nombre de archivo',
                        'AdvancedSettings' => 'Ajustes avanzados',
                        'ExportType' => 'Tipo de exportación',
                        'SplittheRecord' => 'Dividir el registro',
                        'AdvancedFilters' => 'Filtros avanzados',
                        'Exportdatawithautodelimiters' => 'Exportar datos con delimitadores automáticos',
                        'Delimiters' => 'Delimitadores',
                        'OtherDelimiters' => 'Otros delimitadores',
                        'Exportdataforthespecificperiod' => 'Exportar datos para el período específico',
                        'StartFrom' => 'Empezar desde',
                        'EndTo' => 'Fin a',
                        'Exportdatawiththespecificstatus' => 'Exportar datos con el estado específico',
                        'All' => 'Todas',
                        'Publish' => 'Publicar',
                        'Sticky' => 'Pegajosa',
                        'Private' => 'Privada',
                        'Protected' => 'Protegida',
                        'Draft' => 'Sequía',
                        'Pending' => 'Pendiente',
                        'Exportdatabyspecificauthors' => 'Exportar datos por autores específicos',
                        'Authors' => 'Autoras',
                        'ExportdatabasedonspecificInclusions' => 'Exportar datos basados ​​en inclusiones específicas',
                        'DoyouwanttoSchedulethisExport' => '¿Desea programar esta exportación?',
                        'SelectTimeZone' => 'Selecciona la zona horaria',
                        'ScheduleExport' => 'Exportación programada',
                        'DataExported' => 'Datos exportados',
                        'License'=>'Licencia',
                        'ThankYouForYourPurchase'=>'Gracias por su compra',
                        'ToGetStartedYouNeedToActivateByEnteringTheLicensekey'=>'Para comenzar, debe activar ingresando la clave de licencia',
                        'EnterTheLicenseKey'=>'Ingrese la clave de licencia',
                        'LicenseDetails'=>'Detalles de la licencia',
                        'ProductName'=>'nombre del producto',
                        'LicenseKey'=>'Clave de licencia',
                        'NoDataFound'=>'Datos no encontrados',
                        'Activate'=>'Activar'
                );
                return $response;
        }
}

