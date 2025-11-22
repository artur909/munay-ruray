<?php

/**
 * Utilidades para manejo de contraseñas sin usar funciones reservadas de PHP
 * Compatible con versiones anteriores de PHP
 */

/**
 * Genera un hash de contraseña usando SHA-256 con salt
 * @param string $password La contraseña en texto plano
 * @return string El hash de la contraseña
 */
function createPasswordHash($password) {
    // Generar un salt aleatorio
    $salt = generateSalt();
    
    // Crear el hash usando SHA-256
    $hash = hash('sha256', $salt . $password);
    
    // Retornar salt + hash concatenados
    return $salt . ':' . $hash;
}

/**
 * Verifica si una contraseña coincide con su hash
 * @param string $password La contraseña en texto plano
 * @param string $hash El hash almacenado
 * @return bool True si coincide, false si no
 */
function verifyPasswordHash($password, $hash) {
    // Si el hash contiene ':', es nuestro formato personalizado
    if (strpos($hash, ':') !== false) {
        list($salt, $storedHash) = explode(':', $hash, 2);
        $testHash = hash('sha256', $salt . $password);
        return $testHash === $storedHash;
    }
    
    // Si no contiene ':', podría ser un hash de PHP (para compatibilidad)
    if (function_exists('password_verify')) {
        return password_verify($password, $hash);
    }
    
    // Fallback: comparación directa (no recomendado para producción)
    return $password === $hash;
}

/**
 * Genera un salt aleatorio
 * @param int $length Longitud del salt
 * @return string Salt aleatorio
 */
function generateSalt($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $salt = '';
    
    for ($i = 0; $i < $length; $i++) {
        $salt .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    
    return $salt;
}

/**
 * Función para actualizar contraseñas existentes al nuevo formato
 * @param string $plainPassword Contraseña en texto plano
 * @param string $oldHash Hash anterior
 * @return string|false Nuevo hash si la contraseña es correcta, false si no
 */
function migratePassword($plainPassword, $oldHash) {
    // Verificar si la contraseña es correcta con el hash anterior
    if (verifyPasswordHash($plainPassword, $oldHash)) {
        // Crear nuevo hash con nuestro formato
        return createPasswordHash($plainPassword);
    }
    
    return false;
}

?>