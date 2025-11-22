<?php

/**
 * Clase para manejar respuestas JSON consistentes
 */
class ResponseView {
    
    /**
     * Enviar respuesta exitosa
     */
    public static function success($data = null, $message = null, $code = 200) {
        http_response_code($code);
        
        $response = [
            'success' => true,
            'code' => $code
        ];
        
        if ($message !== null) {
            $response['message'] = $message;
        }
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Enviar respuesta de error
     */
    public static function error($message, $code = 400, $errors = null) {
        http_response_code($code);
        
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $message
        ];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Enviar respuesta paginada
     */
    public static function paginated($data, $pagination, $message = null) {
        $response = [
            'success' => true,
            'code' => 200,
            'data' => $data,
            'pagination' => $pagination
        ];
        
        if ($message !== null) {
            $response['message'] = $message;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Enviar respuesta con estadísticas
     */
    public static function stats($stats, $message = null) {
        $response = [
            'success' => true,
            'code' => 200,
            'stats' => $stats
        ];
        
        if ($message !== null) {
            $response['message'] = $message;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Respuesta para creación exitosa
     */
    public static function created($data, $message = 'Recurso creado exitosamente') {
        self::success($data, $message, 201);
    }
    
    /**
     * Respuesta para actualización exitosa
     */
    public static function updated($data = null, $message = 'Recurso actualizado exitosamente') {
        self::success($data, $message, 200);
    }
    
    /**
     * Respuesta para eliminación exitosa
     */
    public static function deleted($message = 'Recurso eliminado exitosamente') {
        self::success(null, $message, 200);
    }
    
    /**
     * Respuesta para recurso no encontrado
     */
    public static function notFound($message = 'Recurso no encontrado') {
        self::error($message, 404);
    }
    
    /**
     * Respuesta para datos no válidos
     */
    public static function validationError($errors, $message = 'Datos no válidos') {
        self::error($message, 422, $errors);
    }
    
    /**
     * Respuesta para error de autorización
     */
    public static function unauthorized($message = 'No autorizado') {
        self::error($message, 401);
    }
    
    /**
     * Respuesta para error interno del servidor
     */
    public static function serverError($message = 'Error interno del servidor') {
        self::error($message, 500);
    }
    
    /**
     * Respuesta para método no permitido
     */
    public static function methodNotAllowed($message = 'Método no permitido') {
        self::error($message, 405);
    }
}