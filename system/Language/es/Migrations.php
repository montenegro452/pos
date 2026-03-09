<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Migration language settings
return [
    // Migration Runner
    'missingTable' => 'La tabla de migraciones debe estar configurada.',
    'disabled' => 'Las migraciones se han cargado, pero están deshabilitadas o configuradas incorrectamente.',
    'notFound' => 'Archivo de migración no encontrado: ',
    'batchNotFound' => 'Lote de destino no encontrado: ',
    'empty' => 'No se encontraron archivos de migración.',
    'gap' => 'Hay un espacio en blanco en la secuencia de migración cerca del número de versión: ',
    'classNotFound' => 'No se pudo encontrar la clase de migración "%s".',
    'missingMethod' => 'A la clase de migración le falta un método "%s".',

    // Migration Command
    'migHelpLatest' => "Migra la base de datos a la última migración disponible.",
    'migHelpCurrent' => "Migra la base de datos a la versión 'actual' en la configuración.",
    'migHelpVersion' => "Migra la base de datos a la versión {v}.",
    'migHelpRollback' => "Ejecuta todas las migraciones a la versión 0.",
    'migHelpRefresh' => "Desinstala y vuelve a ejecutar todas las migraciones para actualizar la base de datos.",
    'migHelpSeed' => "Ejecuta el sembrador llamado [nombre].",
    'migCreate' => "Crea una nueva migración llamada [nombre].",
    'nameMigration' => "Nombra el archivo de migración.",
    'migNumberError' => "El número de migración debe tener tres dígitos y no debe haber espacios en blanco. secuencia.",
    'rollBackConfirm' => '¿Seguro que desea revertir?',
    'refreshConfirm' => '¿Seguro que desea actualizar?',

    'latest' => 'Ejecutando todas las nuevas migraciones...',
    'generalFault' => '¡Migración fallida!',
    'migrated' => 'Migraciones completadas.',
    'migInvalidVersion' => 'Número de versión no válido.',
    'toVersionPH' => 'Migrando a la versión %s...',
    'toVersion' => 'Migrando a la versión actual...',
    'rollingBack' => 'Revirtiendo migraciones al lote:',
    'noneFound' => 'No se encontraron migraciones.',
    'migSeeder' => 'Nombre del sembrador',
    'migMissingSeeder' => 'Debe proporcionar un nombre para el sembrador.',
    'nameSeeder' => 'Nombrar el sembrador archivo',
    'removed' => 'Revirtiendo: ',
    'added' => 'En ejecución: ',

    // Migrate Status
    'namespace' => 'Espacio de nombres',
    'filename' => 'Nombre de archivo',
    'version' => 'Versión',
    'group' => 'Grupo',
    'on' => 'Migrado el:',
    'batch' => 'Lote',
];
