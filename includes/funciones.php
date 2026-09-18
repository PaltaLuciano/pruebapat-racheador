<?php
// Archivo: includes/funciones.php

/**
 * Calcula los días de racha desde la fecha de inicio o último reinicio.
 * Devuelve el número de días consecutivos.
 */
function dias_en_racha($fecha_inicio, $fecha_ultimo_reset = null) {
    $hoy = new DateTime();
    $inicio = new DateTime($fecha_inicio);
    
    if ($fecha_ultimo_reset) {
        $ultimo = new DateTime($fecha_ultimo_reset);
        // Si la fecha de reinicio es más reciente, se cuenta desde ahí
        if ($ultimo > $inicio) {
            $inicio = $ultimo;
        }
    }
    
    $diferencia = $hoy->diff($inicio);
    return $diferencia->days;
}

/**
 * Formatea fechas al estilo: 07/11/2025
 */
function formatear_fecha($fecha) {
    $f = new DateTime($fecha);
    return $f->format("d/m/Y");
}
?>